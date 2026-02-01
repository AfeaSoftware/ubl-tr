<?php

namespace Afea\UblTr\Models\CommonExtensionComponents;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\XmlElement;
use JMS\Serializer\Annotation\XmlList;

class UBLExtensions
{
    #[SerializedName("ext:UBLExtension")]
    #[Type("array<Afea\UblTr\Models\CommonExtensionComponents\UBLExtension>")]
    #[XmlList(inline: true, entry: "ext:UBLExtension")]
    public array $ublExtension;

    public function __construct(array $ublExtension = [])
    {
        $this->ublExtension = $ublExtension;
    }
}
