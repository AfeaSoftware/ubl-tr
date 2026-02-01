<?php

namespace Afea\UblTr\Builder;

use Afea\UblTr\DTO\CompanyInfo;
use Afea\UblTr\DTO\CustomerInfo;
use Afea\UblTr\DTO\VoucherInfo;
use Afea\UblTr\DTO\VoucherLineInfo;
use Afea\UblTr\Enum\IntegratorType;
use Afea\UblTr\Exception\UnsupportedIntegratorException;
use Afea\UblTr\Mapper\Nes\NesVoucherMapper;
use Afea\UblTr\Mapper\Nilvera\NilveraVoucherMapper;
use Afea\UblTr\Mapper\VoucherMapperInterface;
use JMS\Serializer\SerializerBuilder;

class VoucherBuilder
{
    private ?IntegratorType $integrator = null;
    private ?VoucherInfo $voucherInfo = null;
    private ?CompanyInfo $companyInfo = null;
    private ?CustomerInfo $customerInfo = null;
    private array $voucherLines = [];

    public static function create(): self
    {
        return new self();
    }

    public function setIntegrator(IntegratorType $integrator): self
    {
        $this->integrator = $integrator;
        return $this;
    }

    public function voucherInfo(VoucherInfo $voucherInfo): self
    {
        $this->voucherInfo = $voucherInfo;
        return $this;
    }

    public function companyInfo(CompanyInfo $companyInfo): self
    {
        $this->companyInfo = $companyInfo;
        return $this;
    }

    public function customerInfo(CustomerInfo $customerInfo): self
    {
        $this->customerInfo = $customerInfo;
        return $this;
    }

    public function addVoucherLine(VoucherLineInfo $voucherLine): self
    {
        $this->voucherLines[] = $voucherLine;
        return $this;
    }

    public function build(): object
    {
        $this->validate();
        $mapper = $this->getMapper();
        return $mapper->map(
            $this->voucherInfo,
            $this->companyInfo,
            $this->customerInfo,
            $this->voucherLines
        );
    }

    public function toXml(): string
    {
        $voucher = $this->build();
        $serializer = SerializerBuilder::create()->build();
        return $serializer->serialize($voucher, 'xml');
    }

    private function getMapper(): VoucherMapperInterface
    {
        if (!$this->integrator) {
            throw new \RuntimeException('Integrator must be set using setIntegrator() before calling toXml()');
        }

        return match ($this->integrator) {
            IntegratorType::NILVERA => new NilveraVoucherMapper(),
            IntegratorType::NES => new NesVoucherMapper(),
            default => throw new UnsupportedIntegratorException($this->integrator),
        };
    }

    private function validate(): void
    {
        if (!$this->integrator) {
            throw new \RuntimeException('Integrator must be set using setIntegrator()');
        }
        if (!$this->voucherInfo) {
            throw new \RuntimeException('VoucherInfo is required');
        }
        if (!$this->companyInfo) {
            throw new \RuntimeException('CompanyInfo is required');
        }
        if (!$this->customerInfo) {
            throw new \RuntimeException('CustomerInfo is required');
        }
        if (empty($this->voucherLines)) {
            throw new \RuntimeException('At least one VoucherLine is required');
        }
    }
}
