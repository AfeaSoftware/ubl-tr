<?php

namespace Afea\UblTr\Models\CommonAggregateComponents;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\XmlElement;
use JMS\Serializer\Annotation\XmlList;

class Item
{
    #[SerializedName("Description")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public ?string $description = null;

    #[SerializedName("Name")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public string $name;

    #[SerializedName("Keyword")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public ?string $keyword = null;

    #[SerializedName("BrandName")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public ?string $brandName = null;

    #[SerializedName("ModelName")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public ?string $modelName = null;

    #[SerializedName("BuyersItemIdentification")]
    #[Type(ItemIdentification::class)]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2")]
    public ?ItemIdentification $buyersItemIdentification = null;

    #[SerializedName("SellersItemIdentification")]
    #[Type(ItemIdentification::class)]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2")]
    public ?ItemIdentification $sellersItemIdentification = null;

    #[SerializedName("ManufacturersItemIdentification")]
    #[Type(ItemIdentification::class)]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2")]
    public ?ItemIdentification $manufacturersItemIdentification = null;

    #[SerializedName("cac:AdditionalItemIdentification")]
    #[Type("array<Afea\UblTr\Models\CommonAggregateComponents\ItemIdentification>")]
    #[XmlList(inline: true, entry: "cac:AdditionalItemIdentification")]
    public ?array $additionalItemIdentification = null;

    #[SerializedName("OriginCountry")]
    #[Type(Country::class)]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2")]
    public ?Country $originCountry = null;

    #[SerializedName("cac:CommodityClassification")]
    #[Type("array<Afea\UblTr\Models\CommonAggregateComponents\CommodityClassification>")]
    #[XmlList(inline: true, entry: "cac:CommodityClassification")]
    public ?array $commodityClassification = null;
}
