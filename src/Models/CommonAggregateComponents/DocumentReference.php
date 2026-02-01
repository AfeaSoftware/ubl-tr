<?php

namespace Afea\UblTr\Models\CommonAggregateComponents;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\XmlElement;

class DocumentReference
{
    #[SerializedName("ID")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public string $id;

    #[SerializedName("IssueDate")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public string $issueDate;

    #[SerializedName("DocumentTypeCode")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public ?string $documentTypeCode = null;

    #[SerializedName("DocumentType")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public ?string $documentType = null;

    #[SerializedName("Attachment")]
    #[Type(Attachment::class)]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2")]
    public ?Attachment $attachment = null;

    public function __construct(string $id = '', string $issueDate = '')
    {
        $this->id = $id;
        $this->issueDate = $issueDate;
    }
}
