<?php

namespace Afea\UblTr\Models\CommonAggregateComponents;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\XmlElement;

class PaymentMeans
{
    #[SerializedName("ID")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public ?string $id = null;

    #[SerializedName("PaymentMeansCode")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public string $paymentMeansCode;

    #[SerializedName("PaymentDueDate")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public ?string $paymentDueDate = null;

    #[SerializedName("PaymentChannelCode")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public ?string $paymentChannelCode = null;

    #[SerializedName("InstructionNote")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public ?string $instructionNote = null;

    #[SerializedName("PayeeFinancialAccount")]
    #[Type(FinancialAccount::class)]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2")]
    public ?FinancialAccount $payeeFinancialAccount = null;

    public function __construct(string $paymentMeansCode = '')
    {
        $this->paymentMeansCode = $paymentMeansCode;
    }
}
