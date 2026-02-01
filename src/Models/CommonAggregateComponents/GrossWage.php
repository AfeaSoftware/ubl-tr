<?php

namespace Afea\UblTr\Models\CommonAggregateComponents;

use Afea\UblTr\Models\CommonBasicComponents\Amount;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\XmlElement;

class GrossWage
{
    #[SerializedName("GrossWageAmount")]
    #[Type(Amount::class)]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2")]
    public Amount $grossWageAmount;

    public function __construct(?Amount $grossWageAmount = null)
    {
        $this->grossWageAmount = $grossWageAmount ?? new Amount('0');
    }
}
