<?php

namespace Afea\UblTr\Models\CommonAggregateComponents;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\XmlElement;

class BillingReference
{
    #[SerializedName("InvoiceDocumentReference")]
    #[Type(DocumentReference::class)]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2")]
    public ?DocumentReference $invoiceDocumentReference = null;

    #[SerializedName("CreditNoteDocumentReference")]
    #[Type(DocumentReference::class)]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2")]
    public ?DocumentReference $creditNoteDocumentReference = null;

    #[SerializedName("DebitNoteDocumentReference")]
    #[Type(DocumentReference::class)]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2")]
    public ?DocumentReference $debitNoteDocumentReference = null;
}
