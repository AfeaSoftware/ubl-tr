<?php

namespace Afea\UblTr\Models\CommonBasicComponents;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\XmlValue;

class Note
{
    #[Type("string")]
    #[XmlValue(cdata: false)]
    public string $value;

    public function __construct(string $value = '')
    {
        $this->value = $value;
    }
}
