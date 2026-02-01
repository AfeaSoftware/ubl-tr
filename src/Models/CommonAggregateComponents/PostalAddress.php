<?php

namespace Afea\UblTr\Models\CommonAggregateComponents;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\XmlElement;

class PostalAddress
{
    #[SerializedName("ID")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public ?string $id = null;

    #[SerializedName("Postbox")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public ?string $postbox = null;

    #[SerializedName("Room")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public ?string $room = null;

    #[SerializedName("StreetName")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public ?string $streetName = null;

    #[SerializedName("BlockName")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public ?string $blockName = null;

    #[SerializedName("BuildingName")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public ?string $buildingName = null;

    #[SerializedName("BuildingNumber")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public ?string $buildingNumber = null;

    #[SerializedName("CitySubdivisionName")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public string $citySubdivisionName;

    #[SerializedName("CityName")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public string $cityName;

    #[SerializedName("PostalZone")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public ?string $postalZone = null;

    #[SerializedName("Region")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public ?string $region = null;

    #[SerializedName("District")]
    #[Type("string")]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2", cdata: false)]
    public ?string $district = null;

    #[SerializedName("Country")]
    #[Type(Country::class)]
    #[XmlElement(namespace: "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2")]
    public Country $country;
}
