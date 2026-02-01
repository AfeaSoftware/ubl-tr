<?php

namespace Afea\UblTr\Models\CommonAggregateComponents;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\XmlElement;

class Branch
{
    #[SerializedName("ID")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public ?string $id = null;

    #[SerializedName("Name")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public ?string $name = null;

    #[SerializedName("FinancialInstitution")]
    #[Type(FinancialInstitution::class)]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2")]
    public ?FinancialInstitution $financialInstitution = null;
}
