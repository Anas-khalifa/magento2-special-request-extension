<?php
namespace Anas\SpecialRequest\Model;

use Magento\Framework\Model\AbstractModel;

class SpecialRequest extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(\Anas\SpecialRequest\Model\ResourceModel\SpecialRequest::class);
    }
}
