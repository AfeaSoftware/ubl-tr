<?php

namespace Afea\UblTr\Models;

use Afea\UblTr\Models\CommonAggregateComponents\AccountingCustomerParty;
use Afea\UblTr\Models\CommonAggregateComponents\AccountingSupplierParty;
use Afea\UblTr\Models\CommonAggregateComponents\AdditionalDocumentReference;
use Afea\UblTr\Models\CommonAggregateComponents\CreditNoteLine;
use Afea\UblTr\Models\CommonAggregateComponents\LegalMonetaryTotal;
use Afea\UblTr\Models\CommonAggregateComponents\TaxTotal;
use Afea\UblTr\Models\CommonExtensionComponents\UBLExtensions;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\XmlElement;
use JMS\Serializer\Annotation\XmlList;
use JMS\Serializer\Annotation\XmlNamespace;
use JMS\Serializer\Annotation\XmlRoot;

#[XmlRoot("Voucher", namespace: "urn:oasis:names:specification:ubl:schema:xsd:Voucher-2")]
#[XmlNamespace(uri: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", prefix: "cbc")]
#[XmlNamespace(uri: "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2", prefix: "cac")]
#[XmlNamespace(uri: "urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2", prefix: "ext")]
class Voucher
{
    #[SerializedName("ID")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public string $id;

    #[SerializedName("UBLExtensions")]
    #[Type(UBLExtensions::class)]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2")]
    public ?UBLExtensions $ublExtensions = null;

    #[SerializedName("UBLVersionID")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public string $ublVersionID;

    #[SerializedName("CustomizationID")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public string $customizationID;

    #[SerializedName("ProfileID")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public ?string $profileID = null;

    #[SerializedName("UUID")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public string $uuid;

    #[SerializedName("IssueDate")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public string $issueDate;

    #[SerializedName("IssueTime")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public ?string $issueTime = null;

    #[SerializedName("DocumentCurrencyCode")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public string $documentCurrencyCode;

    #[SerializedName("cbc:Note")]
    #[Type("array<Afea\UblTr\Models\CommonBasicComponents\Note>")]
    #[XmlList(inline: true, entry: "cbc:Note")]
    public ?array $note = null;

    #[SerializedName("cac:AdditionalDocumentReference")]
    #[Type("array<Afea\UblTr\Models\CommonAggregateComponents\AdditionalDocumentReference>")]
    #[XmlList(inline: true, entry: "cac:AdditionalDocumentReference")]
    public ?array $additionalDocumentReference = null;

    #[SerializedName("AccountingSupplierParty")]
    #[Type(AccountingSupplierParty::class)]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2")]
    public AccountingSupplierParty $accountingSupplierParty;

    #[SerializedName("AccountingCustomerParty")]
    #[Type(AccountingCustomerParty::class)]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2")]
    public AccountingCustomerParty $accountingCustomerParty;

    #[SerializedName("cac:TaxTotal")]
    #[Type("array<Afea\UblTr\Models\CommonAggregateComponents\TaxTotal>")]
    #[XmlList(inline: true, entry: "cac:TaxTotal")]
    public ?array $taxTotal = null;

    #[SerializedName("LegalMonetaryTotal")]
    #[Type(LegalMonetaryTotal::class)]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2")]
    public LegalMonetaryTotal $legalMonetaryTotal;

    #[SerializedName("cac:CreditNoteLine")]
    #[Type("array<Afea\UblTr\Models\CommonAggregateComponents\CreditNoteLine>")]
    #[XmlList(inline: true, entry: "cac:CreditNoteLine")]
    public array $creditNoteLine;

    #[SerializedName("cac:Signature")]
    #[Type("array<Afea\UblTr\Models\CommonAggregateComponents\Signature>")]
    #[XmlList(inline: true, entry: "cac:Signature")]
    public array $signature = [];
}
