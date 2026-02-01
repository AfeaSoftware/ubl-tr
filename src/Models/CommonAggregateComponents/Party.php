<?php

namespace Afea\UblTr\Models\CommonAggregateComponents;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\XmlElement;
use JMS\Serializer\Annotation\XmlList;

class Party
{
    #[SerializedName("WebsiteURI")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public ?string $websiteURI = null;

    #[SerializedName("EndpointID")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public ?string $endpointID = null;

    #[SerializedName("IndustryClassificationCode")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public ?string $industryClassificationCode = null;

    #[SerializedName("cac:PartyIdentification")]
    #[Type("array<Afea\UblTr\Models\CommonAggregateComponents\PartyIdentification>")]
    #[XmlList(inline: true, entry: "cac:PartyIdentification")]
    public array $partyIdentification;

    #[SerializedName("PartyName")]
    #[Type(PartyName::class)]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2")]
    public ?PartyName $partyName = null;

    #[SerializedName("PostalAddress")]
    #[Type(PostalAddress::class)]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2")]
    public PostalAddress $postalAddress;

    #[SerializedName("PhysicalLocation")]
    #[Type(Location::class)]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2")]
    public ?Location $physicalLocation = null;

    #[SerializedName("PartyTaxScheme")]
    #[Type(PartyTaxScheme::class)]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2")]
    public ?PartyTaxScheme $partyTaxScheme = null;

    #[SerializedName("cac:PartyLegalEntity")]
    #[Type("array<Afea\UblTr\Models\CommonAggregateComponents\PartyLegalEntity>")]
    #[XmlList(inline: true, entry: "cac:PartyLegalEntity")]
    public ?array $partyLegalEntity = null;

    #[SerializedName("Contact")]
    #[Type(Contact::class)]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2")]
    public ?Contact $contact = null;

    #[SerializedName("Person")]
    #[Type(Person::class)]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2")]
    public ?Person $person = null;

    #[SerializedName("AgentParty")]
    #[Type(Party::class)]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2")]
    public ?Party $agentParty = null;
}
