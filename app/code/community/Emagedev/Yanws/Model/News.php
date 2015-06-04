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
        $utils = Mage::helper('yanws/articleUtils');
        $helper = Mage::helper('yanws');

        $this->makeUrl($helper);

        parent::_beforeSave();
    }

    public function isPublished() {
        return $this->getIsPublished();
    }

    public function hasShortenForm() {
        return $this->getIsShorten();
    }

    private function makeUrl($helper) {
        $url_transliterator = Mage::helper('catalog/product_url');

        if($this->getUrl() === '') {
            $plainUrl = $url_transliterator->format($this->getTitle());
        } else {
            $plainUrl = $this->getUrl();
        }

        // this may be unsafe, but seems not
        $url = urlencode($plainUrl);

        for($i = 0; $helper->checkExistenceByUrlIgnoringItselfId($url, $this->getId()); $i++)  {
            $url = $plainUrl . $i;
        }

        $this->setUrl($url);
    }
} 