<?php

namespace Afea\UblTr\Models\Nilvera;

use Afea\UblTr\Models\CommonAggregateComponents\GrossWage;
use Afea\UblTr\Models\CommonAggregateComponents\Item;
use Afea\UblTr\Models\CommonAggregateComponents\Price;
use Afea\UblTr\Models\CommonAggregateComponents\TaxTotal;
use Afea\UblTr\Models\CommonBasicComponents\Amount;
use Afea\UblTr\Models\CommonBasicComponents\Note;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\XmlElement;
use JMS\Serializer\Annotation\XmlList;

class NilveraVoucherLine
{
    #[SerializedName("ID")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public string $id;

    #[SerializedName("UUID")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public ?string $uuid = null;

    #[SerializedName("LineExtensionAmount")]
    #[Type(Amount::class)]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2")]
    public Amount $lineExtensionAmount;

    #[SerializedName("TaxTotal")]
    #[Type(TaxTotal::class)]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2")]
    public ?TaxTotal $taxTotal = null;

    #[SerializedName("Item")]
    #[Type(Item::class)]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2")]
    public Item $item;

    #[SerializedName("GrossWage")]
    #[Type(GrossWage::class)]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2")]
    public GrossWage $grossWage;

    #[SerializedName("Price")]
    #[Type(Price::class)]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2")]
    public Price $price;

    #[SerializedName("cbc:Note")]
    #[Type("array<Afea\UblTr\Models\CommonBasicComponents\Note>")]
    #[XmlList(inline: true, entry: "cbc:Note")]
    public ?array $note = null;
}
