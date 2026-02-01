<?php

namespace Afea\UblTr\Models\CommonAggregateComponents;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\XmlElement;

class BuyerCustomerParty
{
    #[SerializedName("Party")]
    #[Type(Party::class)]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2")]
    public Party $party;

    #[SerializedName("DeliveryContact")]
    #[Type(Contact::class)]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2")]
    public ?Contact $deliveryContact = null;

    public function __construct(Party $party)
    {
        $this->party = $party;
    }
}
