<?php

namespace Afea\UblTr\Mapper\Nes;

use Afea\UblTr\DTO\CompanyInfo;
use Afea\UblTr\DTO\CustomerInfo;
use Afea\UblTr\DTO\VoucherInfo;
use Afea\UblTr\DTO\VoucherLineInfo;
use Afea\UblTr\Mapper\VoucherMapperInterface;
use Afea\UblTr\Models\CommonAggregateComponents\AccountingCustomerParty;
use Afea\UblTr\Models\CommonAggregateComponents\AccountingSupplierParty;
use Afea\UblTr\Models\CommonAggregateComponents\AdditionalDocumentReference;
use Afea\UblTr\Models\CommonAggregateComponents\Contact;
use Afea\UblTr\Models\CommonAggregateComponents\Country;
use Afea\UblTr\Models\CommonAggregateComponents\GrossWage;
use Afea\UblTr\Models\CommonAggregateComponents\Item;
use Afea\UblTr\Models\CommonAggregateComponents\Party;
use Afea\UblTr\Models\CommonAggregateComponents\PartyIdentification;
use Afea\UblTr\Models\CommonAggregateComponents\PartyName;
use Afea\UblTr\Models\CommonAggregateComponents\PartyTaxScheme;
use Afea\UblTr\Models\CommonAggregateComponents\Person;
use Afea\UblTr\Models\CommonAggregateComponents\PostalAddress;
use Afea\UblTr\Models\CommonAggregateComponents\Price;
use Afea\UblTr\Models\CommonAggregateComponents\TaxCategory;
use Afea\UblTr\Models\CommonAggregateComponents\TaxScheme;
use Afea\UblTr\Models\CommonAggregateComponents\TaxSubtotal;
use Afea\UblTr\Models\CommonAggregateComponents\TaxTotal;
use Afea\UblTr\Models\CommonBasicComponents\Amount;
use Afea\UblTr\Models\CommonBasicComponents\ID;
use Afea\UblTr\Models\CommonBasicComponents\Note;
use Afea\UblTr\Models\Nes\NesFreelancerVoucher;
use Afea\UblTr\Models\Nes\NesFreelancerVoucherLegalMonetaryTotal;
use Afea\UblTr\Models\Nes\NesFreelancerVoucherLine;

class NesVoucherMapper implements VoucherMapperInterface
{
    public function map(
        VoucherInfo $voucherInfo,
        CompanyInfo $companyInfo,
        CustomerInfo $customerInfo,
        array $voucherLines
    ): object {
        $voucher = new NesFreelancerVoucher();

        // Basic fields (no UBL metadata)
        $voucher->id = $voucherInfo->id;
        $voucher->uuid = $voucherInfo->uuid;
        $voucher->issueDate = $voucherInfo->issueDate;
        $voucher->issueTime = $voucherInfo->issueTime;
        $voucher->documentCurrencyCode = $voucherInfo->documentCurrencyCode;

        // Additional Document Reference
        if ($voucherInfo->additionalDocumentReferenceId) {
            $docRef = new AdditionalDocumentReference(
                $voucherInfo->additionalDocumentReferenceId,
                $voucherInfo->additionalDocumentReferenceIssueDate ?? $voucherInfo->issueDate
            );
            if ($voucherInfo->additionalDocumentReferenceDocumentTypeCode) {
                $docRef->documentTypeCode = $voucherInfo->additionalDocumentReferenceDocumentTypeCode;
            }
            $voucher->additionalDocumentReference = [$docRef];
        }

        // Notes
        if ($voucherInfo->notes) {
            $voucher->note = array_map(fn($note) => new Note($note), $voucherInfo->notes);
        }

        // Supplier Party
        $voucher->accountingSupplierParty = $this->mapSupplierParty($companyInfo);

        // Customer Party
        $voucher->accountingCustomerParty = $this->mapCustomerParty($customerInfo);

        // Tax Total
        $voucher->taxTotal = $this->calculateTaxTotal($voucherLines, $voucherInfo->documentCurrencyCode);

        // Freelancer Voucher Legal Monetary Total
        $voucher->freelancerVoucherLegalMonetaryTotal = $this->calculateFreelancerLegalMonetaryTotal(
            $voucherLines,
            $voucher->taxTotal,
            $voucherInfo->documentCurrencyCode
        );

        // Freelancer Voucher Lines
        $voucher->freelancerVoucherLine = array_map(
            fn($line) => $this->mapFreelancerVoucherLine($line, $voucherInfo->documentCurrencyCode),
            $voucherLines
        );

        return $voucher;
    }

    private function mapSupplierParty(CompanyInfo $companyInfo): AccountingSupplierParty
    {
        $party = new Party();
        $party->websiteURI = $companyInfo->websiteUri;
        $party->partyIdentification = array_map(
            fn($pi) => new PartyIdentification(new ID($pi->value, $pi->schemeId)),
            $companyInfo->partyIdentifications
        );
        $party->partyName = new PartyName();
        $party->partyName->name = $companyInfo->name;
        $party->postalAddress = $this->mapPostalAddress($companyInfo->address);
        if ($companyInfo->taxSchemeName) {
            $party->partyTaxScheme = new PartyTaxScheme();
            $party->partyTaxScheme->taxScheme = new TaxScheme();
            $party->partyTaxScheme->taxScheme->name = $companyInfo->taxSchemeName;
        }
        if ($companyInfo->contact) {
            $party->contact = $this->mapContact($companyInfo->contact);
        }

        return new AccountingSupplierParty($party);
    }

    private function mapCustomerParty(CustomerInfo $customerInfo): AccountingCustomerParty
    {
        $party = new Party();
        $party->websiteURI = $customerInfo->websiteUri;
        $party->partyIdentification = array_map(
            fn($pi) => new PartyIdentification(new ID($pi->value, $pi->schemeId)),
            $customerInfo->partyIdentifications
        );
        if ($customerInfo->name) {
            $party->partyName = new PartyName();
            $party->partyName->name = $customerInfo->name;
        }
        if ($customerInfo->address) {
            $party->postalAddress = $this->mapPostalAddress($customerInfo->address);
        }
        if ($customerInfo->taxSchemeName) {
            $party->partyTaxScheme = new PartyTaxScheme();
            $party->partyTaxScheme->taxScheme = new TaxScheme();
            $party->partyTaxScheme->taxScheme->name = $customerInfo->taxSchemeName;
        }
        if ($customerInfo->contact) {
            $party->contact = $this->mapContact($customerInfo->contact);
        }
        if ($customerInfo->person) {
            $party->person = new Person();
            $party->person->firstName = $customerInfo->person->firstName;
            $party->person->familyName = $customerInfo->person->familyName;
        }

        return new AccountingCustomerParty($party);
    }

    private function mapPostalAddress($addressInfo): PostalAddress
    {
        $address = new PostalAddress();
        $address->streetName = $addressInfo->streetName;
        // UBL model requires CitySubdivisionName; fall back to CityName if not provided.
        $address->citySubdivisionName = $addressInfo->citySubdivisionName ?? $addressInfo->cityName;
        $address->cityName = $addressInfo->cityName;
        $address->postalZone = $addressInfo->postalZone;
        $address->country = new Country();
        $address->country->name = $addressInfo->countryName;
        return $address;
    }

    private function mapContact($contactInfo): Contact
    {
        $contact = new Contact();
        $contact->telephone = $contactInfo->telephone;
        $contact->telefax = $contactInfo->telefax;
        $contact->electronicMail = $contactInfo->electronicMail;
        return $contact;
    }

    private function mapFreelancerVoucherLine(VoucherLineInfo $lineInfo, string $currencyCode): NesFreelancerVoucherLine
    {
        $line = new NesFreelancerVoucherLine();
        $line->id = $lineInfo->id;
        $line->lineExtensionAmount = new Amount((string)$lineInfo->lineExtensionAmount, $currencyCode);

        // Tax Total for line
        if (!empty($lineInfo->taxes)) {
            $line->taxTotal = $this->mapTaxTotal($lineInfo->taxes, $currencyCode);
        }

        // Item
        $line->item = new Item();
        $line->item->name = $lineInfo->itemName;

        // Gross Wage
        $line->grossWage = new GrossWage();
        $line->grossWage->grossWageAmount = new Amount((string)$lineInfo->grossWageAmount, $currencyCode);

        // Price
        $line->price = new Price();
        $line->price->priceAmount = new Amount((string)$lineInfo->priceAmount, $currencyCode);

        return $line;
    }

    private function calculateTaxTotal(array $voucherLines, string $currencyCode): ?array
    {
        $allTaxes = [];
        foreach ($voucherLines as $line) {
            foreach (($line->taxes ?? []) as $tax) {
                $key = $tax->taxTypeCode . '_' . ($tax->percent ?? 0);
                if (!isset($allTaxes[$key])) {
                    $allTaxes[$key] = [
                        'taxableAmount' => 0,
                        'taxAmount' => 0,
                        'tax' => $tax
                    ];
                }
                $allTaxes[$key]['taxableAmount'] += $tax->taxableAmount;
                $allTaxes[$key]['taxAmount'] += $tax->taxAmount;
            }
        }

        if (empty($allTaxes)) {
            return null;
        }

        $taxSubtotals = [];
        $totalTaxAmount = 0;
        $sequence = 1;

        foreach ($allTaxes as $taxData) {
            $tax = $taxData['tax'];
            $subtotal = new TaxSubtotal();
            $subtotal->taxableAmount = new Amount((string)$taxData['taxableAmount'], $currencyCode);
            $subtotal->taxAmount = new Amount((string)$taxData['taxAmount'], $currencyCode);
            $subtotal->calculationSequenceNumeric = $tax->calculationSequenceNumeric ?? $sequence++;
            $subtotal->percent = $tax->percent;
            $subtotal->taxCategory = new TaxCategory();
            $subtotal->taxCategory->taxScheme = new TaxScheme();
            $subtotal->taxCategory->taxScheme->name = $tax->taxSchemeName;
            $subtotal->taxCategory->taxScheme->taxTypeCode = $tax->taxTypeCode;
            $taxSubtotals[] = $subtotal;
            $totalTaxAmount += $taxData['taxAmount'];
        }

        $taxTotal = new TaxTotal();
        $taxTotal->taxAmount = new Amount((string)$totalTaxAmount, $currencyCode);
        $taxTotal->taxSubtotal = $taxSubtotals;

        return [$taxTotal];
    }

    private function mapTaxTotal(array $taxes, string $currencyCode): TaxTotal
    {
        $taxSubtotals = [];
        $totalTaxAmount = 0;
        $sequence = 1;

        foreach ($taxes as $tax) {
            $subtotal = new TaxSubtotal();
            $subtotal->taxableAmount = new Amount((string)$tax->taxableAmount, $currencyCode);
            $subtotal->taxAmount = new Amount((string)$tax->taxAmount, $currencyCode);
            $subtotal->calculationSequenceNumeric = $tax->calculationSequenceNumeric ?? $sequence++;
            $subtotal->percent = $tax->percent;
            $subtotal->taxCategory = new TaxCategory();
            $subtotal->taxCategory->taxScheme = new TaxScheme();
            $subtotal->taxCategory->taxScheme->name = $tax->taxSchemeName;
            $subtotal->taxCategory->taxScheme->taxTypeCode = $tax->taxTypeCode;
            $taxSubtotals[] = $subtotal;
            $totalTaxAmount += $tax->taxAmount;
        }

        $taxTotal = new TaxTotal();
        $taxTotal->taxAmount = new Amount((string)$totalTaxAmount, $currencyCode);
        $taxTotal->taxSubtotal = $taxSubtotals;

        return $taxTotal;
    }

    private function calculateFreelancerLegalMonetaryTotal(
        array $voucherLines,
        ?array $taxTotals,
        string $currencyCode
    ): NesFreelancerVoucherLegalMonetaryTotal {
        // e-SMM totals (NES FreelancerVoucher):
        // net = gross - stopaj (pratikte priceAmount toplamı)
        // tahsilat = gross + kdv - stopaj
        $gross = 0.0;
        $net = 0.0;
        $vat = 0.0;
        $stopaj = 0.0;

        foreach ($voucherLines as $line) {
            $gross += (float) ($line->grossWageAmount ?? 0);
            $net += (float) ($line->priceAmount ?? 0);

            foreach (($line->taxes ?? []) as $tax) {
                if ($tax->taxTypeCode === '0015') {
                    $vat += (float) ($tax->taxAmount ?? 0);
                } elseif ($tax->taxTypeCode === '0003') {
                    $stopaj += (float) ($tax->taxAmount ?? 0);
                }
            }
        }

        $gross = round($gross, 2);
        $net = round($net, 2);
        $vat = round($vat, 2);
        $stopaj = round($stopaj, 2);

        $payableAmount = round($gross + $vat - $stopaj, 2);

        $total = new NesFreelancerVoucherLegalMonetaryTotal();
        $total->grossWageAmount = new Amount((string)$gross, $currencyCode);
        $total->priceAmount = new Amount((string)$net, $currencyCode);
        $total->lineExtensionAmount = new Amount((string)$net, $currencyCode);
        $total->payableAmount = new Amount((string)$payableAmount, $currencyCode);

        return $total;
    }
}
