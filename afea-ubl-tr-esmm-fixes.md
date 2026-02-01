## e-SMM (Makbuz) toplam hataları — `afea/ubl-tr` implementation plan

Bu doküman, e‑Serbest Meslek Makbuzu (e‑SMM) XML üretiminde **Nilvera** ve **NES** önizlemelerinde görülen toplam / vergi sapmalarının **uygulama katmanında değil**, `afea/ubl-tr` paketinde çözülmesi için bir implementation plan içerir.

### Problem özeti

Elimizde iki tür entegratör var:

- **Nilvera**: UBL kökü `Voucher` (`urn:oasis:names:specification:ubl:schema:xsd:Voucher-2`)
- **NES**: UBL kökü `FreelancerVoucher` (`urn:oasis:names:specification:ubl:schema:xsd:FreelancerVoucher-2`)

Sorunlar:

- **Nilvera stopajlı senaryo**:
  - Stopaj (GV, TaxTypeCode=`0003`) yanlışlıkla `WithholdingAllowance` içine yazılabiliyor.
  - Nilvera önizleme `WithholdingAllowance`’ı stopaj gibi değil, pratikte **KDV tevkifatı** gibi yorumlayıp toplamları bozuyor.

- **Nilvera stopajsız senaryo**:
  - `PayableAmount` hesaplaması KDV’yi iki kere ekleyebiliyor (satır toplamı zaten KDV dahilken tekrar `TaxTotal` eklenmesi).

- **NES senaryosu**:
  - `FreelancerVoucherLegalMonetaryTotal/PayableAmount` Afea mapper’ında **daima brüt** olarak set ediliyor; tahsilat değil.
  - Bu nedenle NES önizlemede “ödenecek/tahsilat” alanı yanlış görünüyor.

---

### UBL alan semantiği (e‑SMM için referans)

> Bu bölümdeki formüller, “tahsilat”ın kullanıcıya/entegratör UI’ına yansıyan toplamla tutarlı olmasını hedefler.

Tanımlar:

- **Gross (Brüt / Matrah)**: `GrossWageAmount`
- **VAT (KDV)**: TaxTypeCode=`0015`
- **Withholding (Stopaj / GV)**: TaxTypeCode=`0003`

Toplamlar:

- \( net = gross - stopaj \)
- \( tahsilat = gross + kdv - stopaj \)

Nilvera `Voucher` için (başlık):

- `LegalMonetaryTotal/TaxInclusiveAmount` = **gross**
- `LegalMonetaryTotal/TaxExclusiveAmount` = **net**
- `LegalMonetaryTotal/LineExtensionAmount` = **net**
- `LegalMonetaryTotal/PayableAmount` = **tahsilat**

Nilvera `VoucherLine` için:

- `VoucherLine/GrossWage/GrossWageAmount` = **gross**
- `VoucherLine/Price/PriceAmount` = **net** (tek kalemde net; çoklu kalemde gerekirse “net birim”e indirgenmeli)
- `VoucherLine/LineExtensionAmount` = **tahsilat**

NES `FreelancerVoucher` için (başlık):

- `FreelancerVoucherLegalMonetaryTotal/GrossWageAmount` = **gross**
- `FreelancerVoucherLegalMonetaryTotal/PriceAmount` = **net**
- `FreelancerVoucherLegalMonetaryTotal/LineExtensionAmount` = **net**
- `FreelancerVoucherLegalMonetaryTotal/PayableAmount` = **tahsilat**

---

## Paket tarafında değişiklik planı

### 1) Nilvera: stopajı `WithholdingAllowance` içine koyma (kaldır)

**Dosya**

- `vendor/afea/ubl-tr/src/Mapper/Nilvera/NilveraVoucherMapper.php`

**Mevcut davranış**

- `calculateWithholdingAllowance()` stopaj (0003) toplamını alıp `WithholdingAllowance`’a basıyor.

**Hedef**

- `WithholdingAllowance` stopaj için kullanılmamalı.
- Stopaj zaten `TaxTotal/TaxSubtotal` altında (0003) temsil edilmeli.

**Önerilen kod değişikliği (örnek)**

```php
// NilveraVoucherMapper.php
private function calculateWithholdingAllowance(array $voucherLines, string $currencyCode): ?WithholdingAllowance
{
    // Stopaj (0003) burada OLMAMALI.
    // WithholdingAllowance Nilvera tarafında pratikte KDV tevkifatı gibi değerlendiriliyor.
    return null;
}
```

> Not: Eğer KDV tevkifatı desteği gerekiyorsa, bunun için ayrı bir tax code (örn. `9015`) ve ona bağlı hesaplama yapılmalı. Stopaj (0003) burada taşınmamalı.

---

### 2) Nilvera: `LegalMonetaryTotal/PayableAmount` hesaplamasını düzelt (KDV’yi iki kere ekleme)

**Dosya**

- `vendor/afea/ubl-tr/src/Mapper/Nilvera/NilveraVoucherMapper.php`

**Mevcut davranış**

- `calculateLegalMonetaryTotal()` içinde:
  - `payableAmount = lineExtensionAmount + totalTaxAmount`

Bu, satır `lineExtensionAmount` zaten tahsilat ise KDV’yi tekrar ekleyebilir.

**Hedef**

Başlık toplamları e‑SMM semantiğine göre yeniden hesaplanmalı:

- `gross = sum(line.grossWageAmount)`
- `kdv = sum tax(0015)`
- `stopaj = sum tax(0003)`
- `net = gross - stopaj`
- `tahsilat = gross + kdv - stopaj`

**Önerilen implementasyon iskeleti**

```php
private function calculateLegalMonetaryTotal(array $voucherLines, ?array $taxTotals, string $currencyCode): LegalMonetaryTotal
{
    $gross = 0.0;
    $kdv = 0.0;
    $stopaj = 0.0;

    foreach ($voucherLines as $line) {
        $gross += (float) $line->grossWageAmount;

        foreach ($line->taxes ?? [] as $tax) {
            if ($tax->taxTypeCode === '0015') {
                $kdv += (float) $tax->taxAmount;
            } elseif ($tax->taxTypeCode === '0003') {
                $stopaj += (float) $tax->taxAmount;
            }
        }
    }

    $net = $gross - $stopaj;
    $payable = $gross + $kdv - $stopaj;

    $total = new LegalMonetaryTotal();
    $total->lineExtensionAmount = new Amount((string) $net, $currencyCode);
    $total->taxExclusiveAmount = new Amount((string) $net, $currencyCode);
    $total->taxInclusiveAmount = new Amount((string) $gross, $currencyCode);
    $total->payableAmount = new Amount((string) $payable, $currencyCode);

    return $total;
}
```

---

### 3) Nilvera: TaxSubtotal sıralamasını deterministik yap

**Dosya**

- `vendor/afea/ubl-tr/src/Mapper/Nilvera/NilveraVoucherMapper.php`

**Hedef**

- `TaxSubtotal/CalculationSequenceNumeric` değerleri:
  - stopaj (0003) => 1
  - KDV (0015) => 2

**Öneri**

- `calculateTaxTotal()` içinde `taxTypeCode`’a göre `calculationSequenceNumeric` override edilebilir.

```php
$subtotal->calculationSequenceNumeric = match ($tax->taxTypeCode) {
    '0003' => 1,
    '0015' => 2,
    default => $tax->calculationSequenceNumeric ?? $sequence++,
};
```

---

### 4) NES: `PayableAmount` tahsilat olmalı (brüt değil)

**Dosya**

- `vendor/afea/ubl-tr/src/Mapper/Nes/NesVoucherMapper.php`

**Mevcut davranış**

- `calculateFreelancerLegalMonetaryTotal()` içinde:
  - `payableAmount = grossWageAmount` (yanlış)

**Hedef**

- `payableAmount = gross + kdv - stopaj`

**Önerilen implementasyon iskeleti**

```php
private function calculateFreelancerLegalMonetaryTotal(
    array $voucherLines,
    ?array $taxTotals,
    string $currencyCode
): NesFreelancerVoucherLegalMonetaryTotal {
    $gross = 0.0;
    $net = 0.0;

    foreach ($voucherLines as $line) {
        $gross += (float) $line->grossWageAmount;
        $net += (float) $line->priceAmount;
    }

    $vat = 0.0;
    $stopaj = 0.0;

    // Tercihen line taxes üzerinden hesapla (daha güvenli)
    foreach ($voucherLines as $line) {
        foreach ($line->taxes ?? [] as $tax) {
            if ($tax->taxTypeCode === '0015') {
                $vat += (float) $tax->taxAmount;
            } elseif ($tax->taxTypeCode === '0003') {
                $stopaj += (float) $tax->taxAmount;
            }
        }
    }

    $payable = $gross + $vat - $stopaj;

    $total = new NesFreelancerVoucherLegalMonetaryTotal();
    $total->grossWageAmount = new Amount((string) $gross, $currencyCode);
    $total->priceAmount = new Amount((string) $net, $currencyCode);
    $total->lineExtensionAmount = new Amount((string) $net, $currencyCode);
    $total->payableAmount = new Amount((string) $payable, $currencyCode);

    return $total;
}
```

---

## Test plan (paket içinde)

### Unit/fixture test senaryoları

> Paket repo’sunda PHPUnit/Pest altyapısı yoksa basit “fixture compare” testleri eklenebilir.

Senaryolar:

- **Nilvera / stopajlı**: \(tahsilat = gross + kdv - stopaj\)
- **Nilvera / stopajsız**: \(tahsilat = gross + kdv\) ve KDV iki kere eklenmemeli
- **NES / stopajlı**
- **NES / stopajsız**

Assert edilecek alanlar:

- Nilvera:
  - `LegalMonetaryTotal/PayableAmount` = tahsilat
  - Stopaj `TaxTotal/TaxSubtotal(0003)` altında
  - `WithholdingAllowance` stopaj içermiyor
- NES:
  - `FreelancerVoucherLegalMonetaryTotal/PayableAmount` = tahsilat

---

## Uygulama tarafı (Flextell) sonrası

`afea/ubl-tr` düzeltildikten sonra:

- Uygulama katmanındaki entegratör bazlı “normalize XML” gibi hack’ler kaldırılmalı.
- Mapper sadece doğru semantiklerle `VoucherLineInfo` doldurmalı; toplamlar paket içinde deterministik üretilmeli.

