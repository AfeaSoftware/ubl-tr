<?php

namespace Afea\UblTr\Models\CommonAggregateComponents;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\XmlElement;

class Country
{
    #[SerializedName("IdentificationCode")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public ?string $identificationCode = null;

    #[SerializedName("Name")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public ?string $name = null;

    public function __construct(?string $identificationCode = null, ?string $name = null)
    {
        $this->identificationCode = $identificationCode;
        $this->name = $name;
    }
}
