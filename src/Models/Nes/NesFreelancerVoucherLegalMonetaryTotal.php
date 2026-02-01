<?php

namespace Afea\UblTr\Models\Nes;

use Afea\UblTr\Models\CommonBasicComponents\Amount;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\XmlElement;

class NesFreelancerVoucherLegalMonetaryTotal
{
    #[SerializedName("GrossWageAmount")]
    #[Type(Amount::class)]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2")]
    public Amount $grossWageAmount;

    #[SerializedName("PriceAmount")]
    #[Type(Amount::class)]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2")]
    public Amount $priceAmount;

    #[SerializedName("LineExtensionAmount")]
    #[Type(Amount::class)]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2")]
    public Amount $lineExtensionAmount;

    #[SerializedName("PayableAmount")]
    #[Type(Amount::class)]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2")]
    public Amount $payableAmount;
}
