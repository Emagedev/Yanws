<?php
/**
 * Created by PhpStorm.
 * User: skm293504
 * Date: 11.05.15
 * Time: 0:49
 */

class Emagedev_Yanws_Block_News_Widget extends Mage_Core_Block_Template {
    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $collection = Mage::getModel('yanws/news')->getCollection()->setOrder('timestamp_created', 'desc');
        $last = $collection
            ->addFieldToFilter('is_published', array('eq' => 1))
            ->setPageSize(3)
            ->setCurPage(1);
        $this->setLast($last);
        $this->setUtils(Mage::helper('yanws/articleUtils'));

    }
} 