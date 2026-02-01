<?php

namespace Afea\UblTr\Models\CommonExtensionComponents;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\XmlValue;

class ExtensionContent
{
    #[Type("string")]
    #[XmlValue]
    public mixed $content;

    public function __construct(mixed $content = null)
    {
        $this->content = $content;
    }
}
