<?php

namespace Afea\UblTr\Models\CommonAggregateComponents;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\XmlElement;

class AllowanceCharge
{
    #[SerializedName("ChargeIndicator")]
    #[Type("bool")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public bool $chargeIndicator;

    #[SerializedName("AllowanceChargeReasonCode")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public ?string $allowanceChargeReasonCode = null;

    #[SerializedName("AllowanceChargeReason")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public ?string $allowanceChargeReason = null;

    #[SerializedName("MultiplierFactorNumeric")]
    #[Type("float")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public ?float $multiplierFactorNumeric = null;

    #[SerializedName("SequenceNumeric")]
    #[Type("int")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public ?int $sequenceNumeric = null;

    #[SerializedName("Amount")]
    #[Type("Afea\UblTr\Models\CommonBasicComponents\Amount")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2")]
    public \Afea\UblTr\Models\CommonBasicComponents\Amount $amount;

    #[SerializedName("BaseAmount")]
    #[Type("Afea\UblTr\Models\CommonBasicComponents\Amount")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2")]
    public ?\Afea\UblTr\Models\CommonBasicComponents\Amount $baseAmount = null;

    public function __construct(bool $chargeIndicator = false, ?\Afea\UblTr\Models\CommonBasicComponents\Amount $amount = null)
    {
        $this->chargeIndicator = $chargeIndicator;
        $this->amount = $amount ?? new \Afea\UblTr\Models\CommonBasicComponents\Amount('0');
    }
}
