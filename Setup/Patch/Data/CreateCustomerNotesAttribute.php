<?php

declare(strict_types=1);

namespace AdeoWeb\Customer\Setup\Patch\Data;

use Magento\Customer\Model\ResourceModel\Attribute as AttributeResource;
use Magento\Eav\Model\Config as EavConfig;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class CreateCustomerNotesAttribute implements DataPatchInterface
{
    public const CUSTOMER_NOTES = 'customer_notes';

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

    /**
     * @inheritDoc
     */
    public function getAliases(): array
    {
        return [];
    }

    public function apply(): void
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        $eavSetup->addAttribute(
            'customer_address',
            self::CUSTOMER_NOTES,
            [
                'type' => 'varchar',
                'label' => 'Customer Notes',
                'input' => 'text',
                'required' => false,
                'visible' => true,
                'user_defined' => false,
                'group' => 'General',
                'global' => true,
                'visible_on_front' => true,
                'position' => 999,
                'system' => false,
            ]
        );

        $customerNotesAttribute = $this->eavConfig->getAttribute('customer_address', self::CUSTOMER_NOTES);
        $customerNotesAttribute->setData(
            'used_in_forms',
            [
                'adminhtml_customer_address',
                'customer_address_edit',
                'customer_register_address'
            ]
        );

        $this->attributeResource->save($customerNotesAttribute);
    }

    /**
     * @inheritDoc
     */
    public static function getDependencies(): array
    {
        return [];
    }
}
