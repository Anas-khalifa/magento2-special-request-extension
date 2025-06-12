<?php
namespace Anas\SpecialRequest\Block;

use Magento\Framework\View\Element\Template;

class Message extends Template
{


    public function getAdminBlockHtml($identifier)
{
    try {
        $cmsBlock = $this->getLayout()
            ->createBlock(\Magento\Cms\Block\Block::class)
            ->setBlockId($identifier)
            ->toHtml();

        return $cmsBlock;
    } catch (\Exception $e) {
        return '';
    }
}

}
