<?php

declare(strict_types=1);

namespace AdeoWeb\Customer\Setup\Patch\Data;

use Magento\Customer\Model\Customer;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class SetPhoneNumberAttributeOptional implements DataPatchInterface
{
    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    public function __construct(EavSetupFactory $eavSetupFactory, ModuleDataSetupInterface $moduleDataSetup)
    {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->moduleDataSetup = $moduleDataSetup;
    }

    /**
     * @inheritdoc
     */
    public function getAliases(): array
    {
        return [];
    }

    public function apply(): void
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        $eavSetup->updateAttribute(
            Customer::ENTITY,
            CreatePhoneNumberAttribute::PHONE_NUMBER,
            'is_required',
            false
        );
    }

    /**
     * @inheritdoc
     */
    public static function getDependencies(): array
    {
        return [
            CreatePhoneNumberAttribute::class
        ];
    }
}
