<?php

declare(strict_types=1);

namespace AdeoWeb\Customer\Setup\Patch\Data;

use Magento\Customer\Model\ResourceModel\Attribute as AttributeResource;
use Magento\Eav\Model\Config as EavConfig;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class CreateAddressNameAttribute implements DataPatchInterface
{
    public const ADDRESS_NAME = 'address_name';

    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var EavConfig
     */
    private $eavConfig;

    /**
     * @var AttributeResource
     */
    private $attributeResource;

    public function __construct(
        EavSetupFactory $categorySetupFactory,
        ModuleDataSetupInterface $moduleDataSetup,
        EavConfig $eavConfig,
        AttributeResource $attributeResource
    ) {
        $this->eavSetupFactory = $categorySetupFactory;
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavConfig = $eavConfig;
        $this->attributeResource = $attributeResource;
    }

    public static function getDependencies(): array
    {
        return [];
    }

    public function getAliases(): array
    {
        return [];
    }

    public function apply(): void
    {
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        $eavSetup->addAttribute(
            'customer_address',
            self::ADDRESS_NAME,
            [
                'type' => 'varchar',
                'label' => 'Address Name',
                'input' => 'text',
                'required' => true,
                'visible' => true,
                'user_defined' => false,
                'group' => 'General',
                'global' => true,
                'visible_on_front' => true,
                'position' => 999,
                'system' => false,
            ]
        );

        $addressNameAttribute = $this->eavConfig->getAttribute('customer_address', self::ADDRESS_NAME);
        $addressNameAttribute->setData(
            'used_in_forms',
            [
                'adminhtml_customer_address',
                'customer_address_edit',
                'customer_register_address'
            ]
        );

        $this->attributeResource->save($addressNameAttribute);
    }
}
