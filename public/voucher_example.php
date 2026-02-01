<?php

require __DIR__ . '/../vendor/autoload.php';

use Afea\UblTr\Builder\VoucherBuilder;
use Afea\UblTr\DTO\AddressInfo;
use Afea\UblTr\DTO\CompanyInfo;
use Afea\UblTr\DTO\ContactInfo;
use Afea\UblTr\DTO\CustomerInfo;
use Afea\UblTr\DTO\PartyIdentificationInfo;
use Afea\UblTr\DTO\PersonInfo;
use Afea\UblTr\DTO\TaxInfo;
use Afea\UblTr\DTO\VoucherInfo;
use Afea\UblTr\DTO\VoucherLineInfo;
use Afea\UblTr\Enum\IntegratorType;

function partyIdentification(string $schemeId, string $value): PartyIdentificationInfo
{
    $pi = new PartyIdentificationInfo();
    $pi->schemeId = $schemeId;
    $pi->value = $value;
    return $pi;
}

// Create VoucherInfo DTO
$voucherInfo = new VoucherInfo();
$voucherInfo->uuid = 'd3331d61-8277-4b51-8083-be208229311d';
$voucherInfo->id = 'ORK';
$voucherInfo->voucherSerieOrNumber = 'SMM2024-001';
$voucherInfo->issueDate = '2026-01-21';
$voucherInfo->issueTime = '12:16:00';
$voucherInfo->documentCurrencyCode = 'TRY';
// Note: Nilvera-specific values (UBLVersionID, CustomizationID, ProfileID, CopyIndicator, CreditNoteTypeCode) 
// are automatically set by the mapper
$voucherInfo->notes = ['YALNIZ : DÖRTBİNSEKİZYÜZ TL SIFIR Kr.'];
$voucherInfo->additionalDocumentReferenceId = 'ELEKTRONIK';
$voucherInfo->additionalDocumentReferenceIssueDate = '2026-01-21';
$voucherInfo->additionalDocumentReferenceDocumentTypeCode = 'SEND_TYPE';

// Create CompanyInfo DTO (Supplier)
$companyInfo = new CompanyInfo();
$companyInfo->websiteUri = 'https://www.nilvera11.com';
$companyInfo->partyIdentifications = [
    partyIdentification('VKN', '1234567801'),
    partyIdentification('TICARETSICILNO', '123'),
    partyIdentification('URETICINO', '1234'),
    partyIdentification('MERSISNO', '32423423423423'),
    partyIdentification('ARACIKURUMETIKET', 'TEST'),
];
$companyInfo->name = 'Test Kurum Bir';
$companyInfo->address = new AddressInfo();
$companyInfo->address->streetName = 'Teknopark13';
$companyInfo->address->citySubdivisionName = 'Melikgazi6';
$companyInfo->address->cityName = 'Kayseri';
$companyInfo->address->postalZone = '38070';
$companyInfo->address->countryName = 'Türkiye';
$companyInfo->taxSchemeName = 'Erciyes32123';
$companyInfo->contact = new ContactInfo();
$companyInfo->contact->telephone = '055455555581';
$companyInfo->contact->telefax = '05403211144';
$companyInfo->contact->electronicMail = 'denem222e10@gmail.com';

// Create CustomerInfo DTO
$customerInfo = new CustomerInfo();
$customerInfo->websiteUri = 'aa';
$customerInfo->partyIdentifications = [
    partyIdentification('TCKN', '36802551426'),
];
$customerInfo->address = new AddressInfo();
$customerInfo->address->streetName = 'aaaa';
$customerInfo->address->citySubdivisionName = 'Talas';
$customerInfo->address->cityName = 'Kayseri';
$customerInfo->address->postalZone = '38080';
$customerInfo->address->countryName = 'TR';
$customerInfo->taxSchemeName = 'Erciyes';
$customerInfo->contact = new ContactInfo();
$customerInfo->contact->telephone = '05078492213';
$customerInfo->contact->telefax = '0 (507) 849 22 ';
$customerInfo->contact->electronicMail = 'buse.duran@nilvera.com';
$customerInfo->person = new PersonInfo();
$customerInfo->person->firstName = 'Buse';
$customerInfo->person->familyName = 'Duran';

// Create VoucherLineInfo DTO
$voucherLine = new VoucherLineInfo();
$voucherLine->id = '1';
$voucherLine->itemName = 'DESTEK HİZMETİ';
$voucherLine->grossWageAmount = 4000.0;
$voucherLine->priceAmount = 4000.0;
$voucherLine->lineExtensionAmount = 4800.0;

// Create TaxInfo for the line
$tax1 = new TaxInfo();
$tax1->taxableAmount = 4000.0;
$tax1->taxAmount = 0.0;
$tax1->percent = 0.0;
$tax1->calculationSequenceNumeric = 1;
$tax1->taxSchemeName = 'GV. Stpj.';
$tax1->taxTypeCode = '0003';

$tax2 = new TaxInfo();
$tax2->taxableAmount = 4000.0;
$tax2->taxAmount = 800.0;
$tax2->percent = 20.0;
$tax2->calculationSequenceNumeric = 2;
$tax2->taxSchemeName = 'KDV';
$tax2->taxTypeCode = '0015';

$voucherLine->taxes = [$tax1, $tax2];

// Generate Nilvera XML
try {
    $nilveraXml = VoucherBuilder::create()
        ->setIntegrator(IntegratorType::NILVERA)
        ->voucherInfo($voucherInfo)
        ->companyInfo($companyInfo)
        ->customerInfo($customerInfo)
        ->addVoucherLine($voucherLine)
        ->toXml();

    if (PHP_SAPI !== 'cli') {
        header('Content-Type: application/xml; charset=utf-8');
    }

    echo $nilveraXml;
    exit;
} catch (\Exception $e) {
    if (PHP_SAPI !== 'cli') {
        header('Content-Type: text/html; charset=utf-8');
    }
    echo '<h1>Error</h1>';
    echo '<pre>';
    echo 'Message: ' . $e->getMessage() . "\n\n";
    echo 'File: ' . $e->getFile() . "\n";
    echo 'Line: ' . $e->getLine() . "\n\n";
    echo 'Stack Trace:' . "\n";
    echo $e->getTraceAsString();
    echo '</pre>';
}
