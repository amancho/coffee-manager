<?php

namespace CoffeeManager\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;

class IntegrationTestCase extends TestCase
{
    /** @var Application */
    protected Application $application;

    protected function setUp(): void
    {
        parent::setUp();

        $this->application = new Application();
    }
}
