<?php

require __DIR__ . '/../vendor/autoload.php';

use Afea\UblTr\Builder\VoucherBuilder;
use Afea\UblTr\Models\Voucher;
use Afea\UblTr\Models\CommonAggregateComponents\AccountingSupplierParty;
use Afea\UblTr\Models\CommonAggregateComponents\AccountingCustomerParty;
use Afea\UblTr\Models\CommonAggregateComponents\Party;
use Afea\UblTr\Models\CommonAggregateComponents\PartyIdentification;
use Afea\UblTr\Models\CommonAggregateComponents\PartyName;
use Afea\UblTr\Models\CommonAggregateComponents\PostalAddress;
use Afea\UblTr\Models\CommonAggregateComponents\Contact;
use Afea\UblTr\Models\CommonAggregateComponents\Person;
use Afea\UblTr\Models\CommonAggregateComponents\PartyTaxScheme;
use Afea\UblTr\Models\CommonAggregateComponents\TaxScheme;
use Afea\UblTr\Models\CommonAggregateComponents\Country;
use Afea\UblTr\Models\CommonAggregateComponents\CreditNoteLine;
use Afea\UblTr\Models\CommonAggregateComponents\Item;
use Afea\UblTr\Models\CommonAggregateComponents\Price;
use Afea\UblTr\Models\CommonAggregateComponents\TaxTotal;
use Afea\UblTr\Models\CommonAggregateComponents\TaxSubtotal;
use Afea\UblTr\Models\CommonAggregateComponents\TaxCategory;
use Afea\UblTr\Models\CommonAggregateComponents\LegalMonetaryTotal;
use Afea\UblTr\Models\CommonAggregateComponents\AdditionalDocumentReference;
use Afea\UblTr\Models\CommonBasicComponents\ID;
use Afea\UblTr\Models\CommonBasicComponents\Amount;
use Afea\UblTr\Models\CommonBasicComponents\Quantity;
use Afea\UblTr\Models\CommonBasicComponents\Note;

// 1. Voucher modelini oluştur
$voucher = new Voucher();
$voucher->ublVersionID = '2.1';
$voucher->customizationID = 'TR1.2';
$voucher->profileID = 'EARSIVFATURA';
$voucher->id = 'SMM2024-001';
$voucher->uuid = '550e8400-e29b-41d4-a716-446655440000';
$voucher->issueDate = '2024-01-15';
$voucher->issueTime = '10:30:00';
$voucher->documentCurrencyCode = 'TRY';

// 2. Supplier Party (Satıcı Firma) oluştur
$supplierParty = new Party();
$supplierParty->partyIdentification = [
    new PartyIdentification(new ID('1234567801', 'VKN'))
];
$supplierParty->partyName = new PartyName('Test Firma A.Ş.');

$supplierAddress = new PostalAddress();
$supplierAddress->streetName = 'Test Mah. Test Cad. Test Sok. No:1-10';
$supplierAddress->district = 'KADIKÖY';
$supplierAddress->cityName = 'İSTANBUL';
$supplierAddress->citySubdivisionName = 'KADIKÖY';
$supplierAddress->postalZone = '34710';
$supplierAddress->country = new Country('TR', 'Türkiye');
$supplierParty->postalAddress = $supplierAddress;

$supplierContact = new Contact();
$supplierContact->telephone = '2122222222';
$supplierContact->electronicMail = 'info@testfirma.com';
$supplierParty->contact = $supplierContact;

$supplierTaxScheme = new TaxScheme();
$supplierTaxScheme->name = 'KADIKÖY';
$supplierPartyTaxScheme = new PartyTaxScheme();
$supplierPartyTaxScheme->taxScheme = $supplierTaxScheme;
$supplierParty->partyTaxScheme = $supplierPartyTaxScheme;

$voucher->accountingSupplierParty = new AccountingSupplierParty($supplierParty);

// 3. Customer Party (Alıcı Müşteri) oluştur
$customerParty = new Party();
$customerParty->partyIdentification = [
    new PartyIdentification(new ID('98765432109', 'TCKN'))
];
$customerParty->partyName = new PartyName('Ahmet Yılmaz');

$customerPerson = new Person();
$customerPerson->firstName = 'Ahmet';
$customerPerson->familyName = 'Yılmaz';
$customerParty->person = $customerPerson;

$customerAddress = new PostalAddress();
$customerAddress->streetName = 'Müşteri Sokak No:5';
$customerAddress->district = 'BEŞİKTAŞ';
$customerAddress->cityName = 'İSTANBUL';
$customerAddress->citySubdivisionName = 'BEŞİKTAŞ';
$customerAddress->postalZone = '34353';
$customerAddress->country = new Country('TR', 'Türkiye');
$customerParty->postalAddress = $customerAddress;

$customerContact = new Contact();
$customerContact->telephone = '5321234567';
$customerContact->electronicMail = 'ahmet@example.com';
$customerParty->contact = $customerContact;

$voucher->accountingCustomerParty = new AccountingCustomerParty($customerParty);

// 4. CreditNoteLine'ları oluştur
$line1 = new CreditNoteLine();
$line1->id = '1';
$line1->creditedQuantity = new Quantity('1', 'C62');
$line1->price = new Price(new Amount('500.00', 'TRY'));
$line1->lineExtensionAmount = new Amount('500.00', 'TRY');

$item1 = new Item();
$item1->name = 'Yazılım Geliştirme Hizmeti';
$item1->description = 'Web uygulaması geliştirme hizmeti';
$line1->item = $item1;

$line1TaxSubtotal = new TaxSubtotal();
$line1TaxSubtotal->taxableAmount = new Amount('500.00', 'TRY');
$line1TaxSubtotal->taxAmount = new Amount('90.00', 'TRY');
$line1TaxSubtotal->percent = 18.0;

$line1TaxCategory = new TaxCategory();
$line1TaxScheme = new TaxScheme();
$line1TaxScheme->id = 'KDV';
$line1TaxScheme->name = 'KDV';
$line1TaxScheme->taxTypeCode = 'KDV';
$line1TaxCategory->taxScheme = $line1TaxScheme;
$line1TaxSubtotal->taxCategory = $line1TaxCategory;

$line1TaxTotal = new TaxTotal(new Amount('90.00', 'TRY'), [$line1TaxSubtotal]);
$line1->taxTotal = $line1TaxTotal;

$line2 = new CreditNoteLine();
$line2->id = '2';
$line2->creditedQuantity = new Quantity('1', 'C62');
$line2->price = new Price(new Amount('500.00', 'TRY'));
$line2->lineExtensionAmount = new Amount('500.00', 'TRY');

$item2 = new Item();
$item2->name = 'Danışmanlık Hizmeti';
$item2->description = 'Proje danışmanlık hizmeti';
$line2->item = $item2;

$line2TaxSubtotal = new TaxSubtotal();
$line2TaxSubtotal->taxableAmount = new Amount('500.00', 'TRY');
$line2TaxSubtotal->taxAmount = new Amount('90.00', 'TRY');
$line2TaxSubtotal->percent = 18.0;

$line2TaxCategory = new TaxCategory();
$line2TaxScheme = new TaxScheme();
$line2TaxScheme->id = 'KDV';
$line2TaxScheme->name = 'KDV';
$line2TaxScheme->taxTypeCode = 'KDV';
$line2TaxCategory->taxScheme = $line2TaxScheme;
$line2TaxSubtotal->taxCategory = $line2TaxCategory;

$line2TaxTotal = new TaxTotal(new Amount('90.00', 'TRY'), [$line2TaxSubtotal]);
$line2->taxTotal = $line2TaxTotal;

$voucher->creditNoteLine = [$line1, $line2];

// 5. Tax Total oluştur
$taxSubtotal = new TaxSubtotal();
$taxSubtotal->taxableAmount = new Amount('1000.00', 'TRY');
$taxSubtotal->taxAmount = new Amount('180.00', 'TRY');
$taxSubtotal->percent = 18.0;

$taxCategory = new TaxCategory();
$taxScheme = new TaxScheme();
$taxScheme->id = 'KDV';
$taxScheme->name = 'KDV';
$taxScheme->taxTypeCode = 'KDV';
$taxCategory->taxScheme = $taxScheme;
$taxSubtotal->taxCategory = $taxCategory;

$taxTotal = new TaxTotal(new Amount('180.00', 'TRY'), [$taxSubtotal]);
$voucher->taxTotal = [$taxTotal];

// 6. Legal Monetary Total oluştur
$monetaryTotal = new LegalMonetaryTotal();
$monetaryTotal->lineExtensionAmount = new Amount('1000.00', 'TRY');
$monetaryTotal->taxExclusiveAmount = new Amount('1000.00', 'TRY');
$monetaryTotal->taxInclusiveAmount = new Amount('1180.00', 'TRY');
$monetaryTotal->payableAmount = new Amount('1180.00', 'TRY');
$voucher->legalMonetaryTotal = $monetaryTotal;

// 7. Additional Document Reference (SendType) oluştur
$additionalRef = new AdditionalDocumentReference('EMAIL', $voucher->issueDate);
$additionalRef->documentTypeCode = 'SEND_TYPE';
$voucher->additionalDocumentReference = [$additionalRef];

// 8. Notes oluştur
$voucher->note = [
    new Note('Örnek makbuz notu 1'),
    new Note('Örnek makbuz notu 2')
];

// 9. Signature (boş array)
$voucher->signature = [];

// 10. Builder ile XML oluştur
try {
    $xml = VoucherBuilder::create()
        ->voucher($voucher)
        ->toXml();

    // XML'i çıktıla
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
