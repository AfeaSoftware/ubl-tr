<?php

namespace Afea\UblTr\Models\CommonAggregateComponents;

use Afea\UblTr\Models\CommonBasicComponents\ID;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\XmlElement;

class PartyIdentification
{
    #[SerializedName("ID")]
    #[Type(ID::class)]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2")]
    public ID $id;

    public function __construct(?ID $id = null)
    {
        $this->id = $id ?? new ID();
    }
}
