<?php

/**
 * Created by PhpStorm.
 * User: skm293504
 * Date: 08.05.15
 * Time: 2:18
 */
class Emagedev_Yanws_Model_News extends Mage_Core_Model_Abstract
{

    public function _construct()
    {
        parent::_construct();
        $this->_init('yanws/news');
    }

    public function _beforeSave()
    {
        $helper = Mage::helper('yanws');

        $this->makeUrl($helper);
        $this->makeTimestamp();

        parent::_beforeSave();
    }

    public function isPublished()
    {
        return $this->getIsPublished();
    }

    public function hasShortenForm()
    {
        return $this->getIsShorten();
    }

    public function getDatetimeCreated()
    {
        return new DateTime($this->getTimestampCreated());
    }

    private function makeTimestamp()
    {
        if (!$this->getTimestampCreated()) {
            $date = Mage::getModel('core/date')->timestamp(time());
            $this->setTimestampCreated($date);
        }
    }

    private function makeUrl($helper)
    {
        // TODO: refactor

        $url_transliterator = Mage::helper('catalog/product_url');

        if ($this->getUrl() === '') {
            $url = $url_transliterator->format($this->getTitle());
        } else {
            $url = $this->getUrl();
        }

        for ($i = 0; $helper->checkExistenceByUrlIgnoringItselfId($url, $this->getId()); $i++) {
            $url .= $i;
        }

        $this->setUrl($url);
    }
} 