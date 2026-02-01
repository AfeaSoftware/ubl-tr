<?php

namespace Afea\UblTr\DTO;

class CustomerInfo
{
    public ?string $websiteUri = null;
    public array $partyIdentifications = [];
    public ?string $name = null;
    public ?AddressInfo $address = null;
    public ?string $taxSchemeName = null;
    public ?ContactInfo $contact = null;
    public ?PersonInfo $person = null;
}
