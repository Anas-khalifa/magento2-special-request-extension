<?php
namespace Anas\SpecialRequest\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class SpecialRequest extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('anas_special_request', 'request_id'); // Table name, primary key
    }
}
