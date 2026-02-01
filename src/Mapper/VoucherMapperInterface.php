<?php

namespace Afea\UblTr\Mapper;

use Afea\UblTr\DTO\CompanyInfo;
use Afea\UblTr\DTO\CustomerInfo;
use Afea\UblTr\DTO\VoucherInfo;
use Afea\UblTr\DTO\VoucherLineInfo;

interface VoucherMapperInterface
{
    /**
     * Maps DTOs to a format-specific voucher model
     *
     * @param VoucherInfo $voucherInfo
     * @param CompanyInfo $companyInfo
     * @param CustomerInfo $customerInfo
     * @param VoucherLineInfo[] $voucherLines
     * @return object The format-specific voucher model
     */
    public function map(
        VoucherInfo $voucherInfo,
        CompanyInfo $companyInfo,
        CustomerInfo $customerInfo,
        array $voucherLines
    ): object;
}
