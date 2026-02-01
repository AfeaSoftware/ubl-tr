<?php

namespace Afea\UblTr\Models\CommonAggregateComponents;

use Afea\UblTr\Models\CommonBasicComponents\Amount;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\XmlElement;

class TaxSubtotal
{
    #[SerializedName("TaxableAmount")]
    #[Type(Amount::class)]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2")]
    public ?Amount $taxableAmount = null;

    #[SerializedName("TaxAmount")]
    #[Type(Amount::class)]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2")]
    public Amount $taxAmount;

    #[SerializedName("CalculationSequenceNumeric")]
    #[Type("float")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public ?float $calculationSequenceNumeric = null;

    #[SerializedName("TransactionCurrencyTaxAmount")]
    #[Type(Amount::class)]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2")]
    public ?Amount $transactionCurrencyTaxAmount = null;

    #[SerializedName("Percent")]
    #[Type("float")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public ?float $percent = null;

    #[SerializedName("BaseUnitMeasure")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public ?string $baseUnitMeasure = null;

    #[SerializedName("PerUnitAmount")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public ?string $perUnitAmount = null;

    #[SerializedName("TaxCategory")]
    #[Type(TaxCategory::class)]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2")]
    public ?TaxCategory $taxCategory = null;
}
