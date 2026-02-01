<?php

namespace Afea\UblTr\Models\CommonAggregateComponents;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\XmlElement;
use JMS\Serializer\Annotation\XmlList;

class CreditNoteLine
{
    #[SerializedName("ID")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public string $id;

    #[SerializedName("UUID")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public ?string $uuid = null;

    #[SerializedName("cbc:Note")]
    #[Type("array<Afea\UblTr\Models\CommonBasicComponents\Note>")]
    #[XmlList(inline: true, entry: "cbc:Note")]
    public ?array $note = null;

    #[SerializedName("CreditedQuantity")]
    #[Type("Afea\\UblTr\\Models\\CommonBasicComponents\\Quantity")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2")]
    public ?\Afea\UblTr\Models\CommonBasicComponents\Quantity $creditedQuantity = null;

    #[SerializedName("LineExtensionAmount")]
    #[Type("Afea\UblTr\Models\CommonBasicComponents\Amount")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2")]
    public ?\Afea\UblTr\Models\CommonBasicComponents\Amount $lineExtensionAmount = null;

    #[SerializedName("cac:OrderLineReference")]
    #[Type("array<Afea\UblTr\Models\CommonAggregateComponents\OrderLineReference>")]
    #[XmlList(inline: true, entry: "cac:OrderLineReference")]
    public ?array $orderLineReference = null;

    #[SerializedName("cac:DespatchLineReference")]
    #[Type("array<Afea\UblTr\Models\CommonAggregateComponents\LineReference>")]
    #[XmlList(inline: true, entry: "cac:DespatchLineReference")]
    public ?array $despatchLineReference = null;

    #[SerializedName("cac:ReceiptLineReference")]
    #[Type("array<Afea\UblTr\Models\CommonAggregateComponents\LineReference>")]
    #[XmlList(inline: true, entry: "cac:ReceiptLineReference")]
    public ?array $receiptLineReference = null;

    #[SerializedName("cac:Delivery")]
    #[Type("array<Afea\UblTr\Models\CommonAggregateComponents\Delivery>")]
    #[XmlList(inline: true, entry: "cac:Delivery")]
    public ?array $delivery = null;

    #[SerializedName("cac:AllowanceCharge")]
    #[Type("array<Afea\UblTr\Models\CommonAggregateComponents\AllowanceCharge>")]
    #[XmlList(inline: true, entry: "cac:AllowanceCharge")]
    public ?array $allowanceCharge = null;

    #[SerializedName("TaxTotal")]
    #[Type(TaxTotal::class)]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2")]
    public ?TaxTotal $taxTotal = null;

    #[SerializedName("Item")]
    #[Type(Item::class)]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2")]
    public ?Item $item = null;

    #[SerializedName("Price")]
    #[Type(Price::class)]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2")]
    public ?Price $price = null;
}
