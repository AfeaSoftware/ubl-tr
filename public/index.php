<?php

require __DIR__ . '/../vendor/autoload.php';

use Afea\UblTr\Builder\VoucherBuilder;
use Afea\UblTr\DTO\CompanyInfo;
use Afea\UblTr\DTO\CustomerInfo;
use Afea\UblTr\DTO\TaxInfo;
use Afea\UblTr\DTO\VoucherInfo;
use Afea\UblTr\DTO\VoucherLine;

// 1. VoucherInfo DTO'sunu oluştur
$voucherInfo = new VoucherInfo();
$voucherInfo->UUID = '550e8400-e29b-41d4-a716-446655440000';
$voucherInfo->VoucherSerieOrNumber = 'SMM2024-001';
$voucherInfo->IssueDate = '2024-01-15';
$voucherInfo->IssueTime = '10:30:00';
$voucherInfo->CurrencyCode = 'TRY';
$voucherInfo->ExchangeRate = 1.0;
$voucherInfo->SendType = 'EMAIL';
$voucherInfo->Notes = ['Örnek makbuz notu 1', 'Örnek makbuz notu 2'];
$voucherInfo->LineExtensionAmount = 1000.0;
$voucherInfo->KdvTotal = 180.0;
$voucherInfo->PayableAmount = 1180.0;

// 2. CompanyInfo DTO'sunu oluştur (Satıcı Firma)
$companyInfo = new CompanyInfo();
$companyInfo->TaxNumber = '1234567801'; // 10 haneli VKN
$companyInfo->Name = 'Test Firma A.Ş.';
$companyInfo->TaxOffice = 'KADIKÖY';
$companyInfo->Address = 'Test Mah. Test Cad. Test Sok. No:1-10';
$companyInfo->District = 'KADIKÖY';
$companyInfo->City = 'İSTANBUL';
$companyInfo->Country = 'Türkiye';
$companyInfo->PostalCode = '34710';
$companyInfo->Phone = '2122222222';
$companyInfo->Fax = '2122222222';
$companyInfo->Mail = 'info@testfirma.com';
$companyInfo->WebSite = 'www.testfirma.com.tr';

// 3. CustomerInfo DTO'sunu oluştur (Alıcı Müşteri)
$customerInfo = new CustomerInfo();
$customerInfo->TaxNumber = '98765432109'; // 11 haneli TCKN
$customerInfo->Name = 'Ahmet Yılmaz';
$customerInfo->Address = 'Müşteri Sokak No:5';
$customerInfo->District = 'BEŞİKTAŞ';
$customerInfo->City = 'İSTANBUL';
$customerInfo->Country = 'Türkiye';
$customerInfo->PostalCode = '34353';
$customerInfo->Phone = '5321234567';
$customerInfo->Mail = 'ahmet@example.com';

// 4. VoucherLine DTO'larını oluştur
$voucherLine1 = new VoucherLine();
$voucherLine1->Index = '1';
$voucherLine1->Name = 'Yazılım Geliştirme Hizmeti';
$voucherLine1->Description = 'Web uygulaması geliştirme hizmeti';
$voucherLine1->GrossWage = 500.0;
$voucherLine1->Price = 500.0;
$voucherLine1->KDVPercent = 18.0;
$voucherLine1->KDVTotal = 90.0;

// KDV için TaxInfo ekle
$taxInfo1 = new TaxInfo();
$taxInfo1->TaxCode = 'KDV';
$taxInfo1->Total = 90.0;
$taxInfo1->Percent = 18.0;
$voucherLine1->Taxes = [$taxInfo1];

$voucherLine2 = new VoucherLine();
$voucherLine2->Index = '2';
$voucherLine2->Name = 'Danışmanlık Hizmeti';
$voucherLine2->Description = 'Proje danışmanlık hizmeti';
$voucherLine2->GrossWage = 500.0;
$voucherLine2->Price = 500.0;
$voucherLine2->KDVPercent = 18.0;
$voucherLine2->KDVTotal = 90.0;

// KDV için TaxInfo ekle
$taxInfo2 = new TaxInfo();
$taxInfo2->TaxCode = 'KDV';
$taxInfo2->Total = 90.0;
$taxInfo2->Percent = 18.0;
$voucherLine2->Taxes = [$taxInfo2];

// 5. Builder ile UBL XML oluştur
try {
    $xml = VoucherBuilder::create()
        ->voucherInfo($voucherInfo)
        ->companyInfo($companyInfo)
        ->customerInfo($customerInfo)
        ->addVoucherLine($voucherLine1)
        ->addVoucherLine($voucherLine2)
        ->toXml();

    // 6. XML'i çıktıla
    header('Content-Type: application/xml; charset=utf-8');
    echo $xml;
} catch (\Exception $e) {
    // Hata durumunda detaylı bilgi göster
    header('Content-Type: text/html; charset=utf-8');
    echo '<h1>Hata Oluştu</h1>';
    echo '<pre>';
    echo 'Mesaj: ' . $e->getMessage() . "\n\n";
    echo 'Dosya: ' . $e->getFile() . "\n";
    echo 'Satır: ' . $e->getLine() . "\n\n";
    echo 'Stack Trace:' . "\n";
    echo $e->getTraceAsString();
    echo '</pre>';
}
