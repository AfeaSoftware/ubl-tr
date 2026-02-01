<?php

namespace Afea\UblTr\Exception;

use Afea\UblTr\Enum\IntegratorType;

class UnsupportedIntegratorException extends \RuntimeException
{
    public function __construct(IntegratorType $integrator)
    {
        parent::__construct("Unsupported integrator: {$integrator->value}");
    }
}
