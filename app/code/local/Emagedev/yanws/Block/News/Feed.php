<?php
/**
 * Created by PhpStorm.
 * User: skm293504
 * Date: 10.05.15
 * Time: 13:37
 */

class Emagedev_Yanws_Block_News_Feed extends Mage_Core_Block_Template {
    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $feed = Mage::registry('yanws_feed');
        $pager = $this->getLayout()->createBlock('page/html_pager', 'custom.pager');
        $pager->setAvailableLimit(array(5=>5, 10=>10, 20=>20));
        $pager->setLimit(10);
        $pager->setCollection($feed);

        $this->setFeed($feed);
        $this->setPager($pager->_toHtml());
        $this->setUtils(Mage::helper('yanws/articleUtils'));

        return $this;
    }
}