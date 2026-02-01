<?php

namespace Afea\UblTr\Models\CommonAggregateComponents;

use Afea\UblTr\Models\CommonBasicComponents\Amount;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\XmlElement;

class WithholdingAllowance
{
    #[SerializedName("WithholdableAmount")]
    #[Type(Amount::class)]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2")]
    public Amount $withholdableAmount;

    #[SerializedName("WithholdingAmount")]
    #[Type(Amount::class)]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2")]
    public Amount $withholdingAmount;

    public function __construct(?Amount $withholdableAmount = null, ?Amount $withholdingAmount = null)
    {
        $this->withholdableAmount = $withholdableAmount ?? new Amount('0');
        $this->withholdingAmount = $withholdingAmount ?? new Amount('0');
    }
}
