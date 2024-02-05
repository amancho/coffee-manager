<?php

namespace App\Shared\Domain\Bus\Query;

interface QueryResponse
{
    public function toArray(): array;
}