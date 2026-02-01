<?php

namespace Afea\UblTr\Models\CommonBasicComponents;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\XmlAttribute;
use JMS\Serializer\Annotation\XmlValue;

class Amount
{
    #[SerializedName("currencyID")]
    #[Type("string")]
    #[XmlAttribute]
    public ?string $currencyID = null;

    #[Type("string")]
    #[XmlValue(cdata: false)]
    public string $value;

    public function __construct(string $value = '0', ?string $currencyID = null)
    {
        $this->value = $value;
        $this->currencyID = $currencyID;
    }
}
