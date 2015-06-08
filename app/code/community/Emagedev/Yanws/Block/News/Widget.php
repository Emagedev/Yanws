<?php

/**
 * Created by PhpStorm.
 * User: skm293504
 * Date: 11.05.15
 * Time: 0:49
 */
class Emagedev_Yanws_Block_News_Widget extends Mage_Core_Block_Template
{

    const MAX_WORDS = 30;

    protected $_saveTags;
    protected $_forceTruncate;

    public function _construct()
    {
        $this->_saveTags = Mage::getStoreConfigFlag('yanws_section/widget_group/save_tags');
        $this->_forceTruncate = Mage::getStoreConfigFlag('yanws_section/widget_group/force_truncate');
        $this->setUtils(Mage::helper('yanws/articleUtils'));
    }

    protected function getShorten($entry)
    {
        $html = $this->getUtils()->getShorten($entry, self::MAX_WORDS, $this->_saveTags, $this->_forceTruncate);

        // Show image title instead of image
        $html = preg_replace("/<img[^>]*(alt=\"([^\"]+)\")[^>]*>/u", $this->__("Image: ") . "$2<br/>", $html);

        return $html;
    }

    protected function _beforeToHtml()
    {
        parent::_beforeToHtml();

        $collection = Mage::getModel('yanws/news')
            ->getCollection()
            ->setOrder('timestamp_created', 'desc');

        $last = $collection
            ->addFieldToFilter('is_published', array('eq' => 1))
            ->setPageSize(3)
            ->setCurPage(1);

        $title = Mage::getStoreConfig('yanws_section/titles_group/widget_title');
        if ($title === "") {
            $title = $this->__('Got news?');
        }

        $this->setTitle($title);
        $this->setLast($last);
    }

    public function _toHtml()
    {
        if (!Mage::getStoreConfig('yanws_section/widget_group/show') ||
            Mage::app()->getRequest()->getRouteName() == "yanws"
        ) {
            return '';
        } else {
            return parent::_toHtml();
        }
    }
} 