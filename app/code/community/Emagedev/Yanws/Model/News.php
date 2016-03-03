<?php

/**
 * @method $this setIsPublished
 * @method string getIsPublished
 * @method $this setIsShorten
 * @method string getIsShorten
 * @method $this setTimestampCreated
 * @method int getTimestampCreated
 * @method $this setUrl
 * @method string getUrl
 * @method $this setTitle
 * @method string getTitle
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

    /**
     * Transliterate and format entry url before save
     *
     * @param $helper Emagedev_Yanws_Helper_Data
     */
    private function makeUrl($helper)
    {
        // TODO: refactor

        /** @var $url_transliterator Mage_Catalog_Helper_Product_Url */
        $url_transliterator = Mage::helper('yanws')->_getTransliterator();

        if ($this->getUrl() === '') {
            $plainUrl = $this->getTitle();
        } else {
            $plainUrl = $this->getUrl();
        }

        $plainUrl = preg_replace('#[^0-9a-z]+#i', '-', $url_transliterator->format($plainUrl));
        $plainUrl = strtolower($plainUrl);
        $plainUrl = trim($plainUrl, '-');

        // To handle rewrites
        if ($plainUrl == 'index') {
            $plainUrl = 'indexation';
        }

        $url = $plainUrl;

        for ($i = 0; $helper->checkExistenceByUrlIgnoringItselfId($url, $this->getId()); $i++) {
            $url = $plainUrl . $i;
        }

        $this->setUrl($url);
    }
} 