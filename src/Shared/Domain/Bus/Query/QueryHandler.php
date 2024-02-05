<?php

namespace App\Shared\Domain\Bus\Query;

abstract class QueryHandler
{
    final public function __invoke(Query $query): QueryResponse
    {
        return $this->handle($query);
    }

    abstract protected function handle(Query $query): QueryResponse;
}
