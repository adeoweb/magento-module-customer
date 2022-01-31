<?php

declare(strict_types=1);

namespace AdeoWeb\Customer\Test\Unit\Model;

use AdeoWeb\Customer\Model\CliAuthorization;
use PHPUnit\Framework\TestCase;

class CliAuthorizationTest extends TestCase
{
    /**
     * @var CliAuthorization
     */
    private $object;

    public function testIsAllowedForCli(): void
    {
        $this->assertTrue($this->object->isAllowed('ACL'));
    }

    protected function setUp(): void
    {
        $this->object = new CliAuthorization();
    }
}
