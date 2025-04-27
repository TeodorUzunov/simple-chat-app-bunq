<?php

declare(strict_types=1);

namespace App\Domain\DomainException;

class DomainRecordNotFoundException extends DomainException
{
    protected $message = 'The requested record was not found.';
}
