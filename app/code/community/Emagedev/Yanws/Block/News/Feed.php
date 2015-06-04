<?php
/**
 * Created by PhpStorm.
 * User: skm293504
 * Date: 10.05.15
 * Time: 13:37
 */

class Emagedev_Yanws_Block_News_Feed extends Mage_Core_Block_Template {
    const MAX_WORDS = 90;

    protected $_utils;
    protected $_saveTags;
    protected $_forceTruncate;

    public function _construct() {
        $this->_utils = Mage::helper('yanws/articleUtils');
        $this->_saveTags = Mage::getStoreConfig('yanws_section/feed_group/save_tags');
        $this->_forceTruncate = Mage::getStoreConfig('yanws_section/feed_group/force_truncate');
    }

    protected function getShorten($entry) {
        return $this->_utils->getShorten($entry, self::MAX_WORDS, $this->_saveTags, $this->_forceTruncate);
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $feed = Mage::getModel('yanws/news')
            ->getCollection()
            ->addFieldToFilter('is_published', array('eq' => 1))
            ->setOrder('timestamp_created', 'DESC');

        $pager = $this->getLayout()->createBlock('page/html_pager', 'custom.pager');
        $pager->setAvailableLimit(array(5=>5, 10=>10));
        $pager->setLimit(10);
        $pager->setCollection($feed);

        $title = Mage::getStoreConfig('yanws_section/titles_group/feed_title');
        if($title === "") {
            $title = $this->__('News');
        }

        $this->setTitle($title);
        $this->setFeed($feed);
        $this->setPager($pager->_toHtml());
        $this->setUtils($this->_utils);

        return $this;
    }
}