<?php

declare(strict_types=1);

namespace AdeoWeb\Customer\Setup\Patch\Data;

use Magento\Customer\Model\Customer;
use Magento\Customer\Model\ResourceModel\Attribute as AttributeResource;
use Magento\Eav\Model\Config as EavConfig;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class CreatePhoneNumberAttribute implements DataPatchInterface
{
    public const PHONE_NUMBER = 'phone_number';

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
            Customer::ENTITY,
            self::PHONE_NUMBER,
            [
                'type' => 'text',
                'label' => 'Phone Number',
                'input' => 'text',
                'required' => true,
                'visible' => true,
                'user_defined' => false,
                'position' => 999,
                'system' => 0,
            ]
        );

        $phoneNumberAttribute = $this->eavConfig->getAttribute(Customer::ENTITY, self::PHONE_NUMBER);
        $phoneNumberAttribute->setData(
            'used_in_forms',
            [
                'adminhtml_customer',
                'customer_account_create',
                'customer_account_edit'
            ]
        );

        $this->attributeResource->save($phoneNumberAttribute);
    }
}
