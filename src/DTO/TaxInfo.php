<?php

namespace Afea\UblTr\DTO;

class TaxInfo
{
    public float $taxableAmount;
    public float $taxAmount;
    public ?float $percent = null;
    public ?int $calculationSequenceNumeric = null;
    public string $taxSchemeName;
    public string $taxTypeCode;
}
