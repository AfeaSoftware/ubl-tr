<?php

namespace Afea\UblTr\Models\CommonAggregateComponents;

use Afea\UblTr\Models\CommonBasicComponents\Amount;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\XmlElement;
use JMS\Serializer\Annotation\XmlList;

class WithholdingTaxTotal
{
    #[SerializedName("TaxAmount")]
    #[Type(Amount::class)]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2")]
    public Amount $taxAmount;

    #[SerializedName("cac:TaxSubtotal")]
    #[Type("array<Afea\UblTr\Models\CommonAggregateComponents\TaxSubtotal>")]
    #[XmlList(inline: true, entry: "cac:TaxSubtotal")]
    public array $taxSubtotal;

    public function __construct(?Amount $taxAmount = null, array $taxSubtotal = [])
    {
        $this->taxAmount = $taxAmount ?? new Amount('0');
        $this->taxSubtotal = $taxSubtotal;
    }
}
