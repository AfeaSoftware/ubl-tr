<?php

namespace Afea\UblTr\DTO;

class CompanyInfo
{
    public ?string $websiteUri = null;
    public array $partyIdentifications = [];
    public string $name;
    public AddressInfo $address;
    public ?string $taxSchemeName = null;
    public ?ContactInfo $contact = null;
}
