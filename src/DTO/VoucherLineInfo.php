<?php

namespace Afea\UblTr\DTO;

class VoucherLineInfo
{
    public string $id;
    public ?string $uuid = null;
    public string $itemName;
    public float $grossWageAmount;
    public float $priceAmount;
    public float $lineExtensionAmount;
    public array $taxes = [];
    public ?string $note = null;
}
