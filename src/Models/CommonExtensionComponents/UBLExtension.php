<?php

namespace Afea\UblTr\Models\CommonExtensionComponents;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\XmlElement;

class UBLExtension
{
    #[SerializedName("ExtensionContent")]
    #[Type("Afea\UblTr\Models\CommonExtensionComponents\ExtensionContent")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2")]
    public ExtensionContent $extensionContent;

    public function __construct(ExtensionContent $extensionContent)
    {
        $this->extensionContent = $extensionContent;
    }
}
