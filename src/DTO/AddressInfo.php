<?php

namespace Afea\UblTr\DTO;

class AddressInfo
{
    public ?string $streetName = null;
    public ?string $citySubdivisionName = null;
    public string $cityName;
    public ?string $postalZone = null;
    public string $countryName;
}
