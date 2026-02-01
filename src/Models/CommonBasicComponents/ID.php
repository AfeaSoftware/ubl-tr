<?php

namespace Afea\UblTr\Models\CommonBasicComponents;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\XmlAttribute;
use JMS\Serializer\Annotation\XmlValue;

class ID
{
    #[SerializedName("schemeID")]
    #[Type("string")]
    #[XmlAttribute]
    public ?string $schemeID = null;

    #[Type("string")]
    #[XmlValue(cdata: false)]
    public string $value;

    public function __construct(string $value = '', ?string $schemeID = null)
    {
        $this->value = $value;
        $this->schemeID = $schemeID;
    }
}
