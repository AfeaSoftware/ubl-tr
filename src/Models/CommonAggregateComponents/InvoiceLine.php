<?php

namespace Afea\UblTr\Models\CommonAggregateComponents;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\XmlElement;
use JMS\Serializer\Annotation\XmlList;

class InvoiceLine
{
    #[SerializedName("ID")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public string $id;

    #[SerializedName("cbc:Note")]
    #[Type("array<Afea\UblTr\Models\CommonBasicComponents\Note>")]
    #[XmlList(inline: true, entry: "cbc:Note")]
    public ?array $note = null;

    #[SerializedName("InvoicedQuantity")]
    #[Type("Afea\\UblTr\\Models\\CommonBasicComponents\\Quantity")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2")]
    public \Afea\UblTr\Models\CommonBasicComponents\Quantity $invoicedQuantity;

    #[SerializedName("LineExtensionAmount")]
    #[Type("Afea\UblTr\Models\CommonBasicComponents\Amount")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2")]
    public \Afea\UblTr\Models\CommonBasicComponents\Amount $lineExtensionAmount;

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

    #[SerializedName("cac:WithholdingTaxTotal")]
    #[Type("array<Afea\UblTr\Models\CommonAggregateComponents\WithholdingTaxTotal>")]
    #[XmlList(inline: true, entry: "cac:WithholdingTaxTotal")]
    public ?array $withholdingTaxTotal = null;

    #[SerializedName("Item")]
    #[Type(Item::class)]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2")]
    public Item $item;

    #[SerializedName("Price")]
    #[Type(Price::class)]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2")]
    public Price $price;

    #[SerializedName("cac:SubInvoiceLine")]
    #[Type("array<Afea\UblTr\Models\CommonAggregateComponents\InvoiceLine>")]
    #[XmlList(inline: true, entry: "cac:SubInvoiceLine")]
    public ?array $subInvoiceLine = null;
}
