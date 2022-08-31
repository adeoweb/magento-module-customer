<?php

declare(strict_types=1);

namespace AdeoWeb\Customer\Model\ResourceModel;

use Magento\Customer\Model\ResourceModel\Customer as BaseCustomer;

class Customer extends BaseCustomer
{
    public function getTaxClassId(int $customerId): int
    {
        $connection = $this->getConnection();
        $select = $connection->select();
        $select->from(
            ['customer' => $this->getEntityTable()],
            ['group.tax_class_id'],
        );
        $select->joinInner(
            ['group' => $connection->getTableName('customer_group')],
            'customer.group_id = group.customer_group_id',
            [],
        );
        $select->where('customer.entity_id = ?', $customerId);

        return (int)$connection->fetchOne($select);
    }
}
