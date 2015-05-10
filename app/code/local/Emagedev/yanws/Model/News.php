<?php
/**
 * Created by PhpStorm.
 * User: skm293504
 * Date: 08.05.15
 * Time: 2:18
 */

class Emagedev_Yanws_Model_News extends Mage_Core_Model_Abstract {

    public function _construct()
    {
        parent::_construct();
        $this->_init('yanws/news');
    }

    public function _beforeSave() {
        $url_transliterator = Mage::helper('catalog/product_url');
        if(!$this->getUrl()) {
            $this->setData("url", urlencode($url_transliterator->format($this->getTitle())));
        }
        // dispatch orig events after?
        parent::_beforeSave();
    }

    public function isPublished() {
        return $this->getIsPublished();
    }

    protected function _beforeToHtml()
    {
        $this->datetime = Mage::helper('yanws/prettyDateTime')->parse(new DateTime($this['timestamp_created']));
        parent::_beforeToHtml();
        return $this;
    }
} 