<?php

namespace Afea\UblTr\Models\CommonBasicComponents;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\XmlAttribute;
use JMS\Serializer\Annotation\XmlValue;

class Quantity
{
    #[SerializedName("unitCode")]
    #[Type("string")]
    #[XmlAttribute]
    public ?string $unitCode = null;

    #[Type("string")]
    #[XmlValue(cdata: false)]
    public string $value;

    public function __construct(string $value = '0', ?string $unitCode = null)
    {
        $this->value = $value;
        $this->unitCode = $unitCode;
    }
}
