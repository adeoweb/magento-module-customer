<?php

declare(strict_types=1);

namespace AdeoWeb\Customer\Model;

use Magento\Framework\AuthorizationInterface;

use function strpos;

use const PHP_SAPI;

class CliAuthorization implements AuthorizationInterface
{
    /**
     * @inheritDoc
     * @phpcs:disable Generic.CodeAnalysis.UnusedFunctionParameter.FoundInImplementedInterfaceAfterLastUsed
     */
    public function isAllowed($resource, $privilege = null): bool
    {
        return false !== strpos(PHP_SAPI, 'cli');
    }
}
