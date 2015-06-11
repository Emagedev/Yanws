<?php

/**
 * Created by PhpStorm.
 * User: skm293504
 * Date: 08.05.15
 * Time: 13:45
 */
class Emagedev_Yanws_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function checkExistenceByUrlIgnoringItselfId($entryUrl, $entryId, $published = false)
    {
        $entry = $this->getEntryByUrl($entryUrl);

        if (!$entry || $entry->getId() == $entryId) {
            return false;
        } else {
            if (!$entry->isPublished() && $published) {
                return false;
            } else {
                return true;
            }
        }
    }

    /*
     * @param entry url to get
     * @param bool is published
     * @return false if not exist, entry otherwise
     */

    public function checkExistenceByUrl($entryUrl, $published = false)
    {
        $entry = $this->getEntryByUrl($entryUrl);

        if (!$entry) {
            return false;
        } else {
            if (!$entry->isPublished() && $published) {
                return false;
            } else {
                return $entry;
            }
        }
    }

    private function getEntryByUrl($entryUrl)
    {
        $entry = Mage::getModel('yanws/news')
            ->load($entryUrl, 'url');

        $entryData = $entry->getData();

        if (empty($entryData)) {
            return false;
        } else {
            return $entry;
        }
    }

    public function _getTransliterator() {
        return Mage::helper('catalog/product_url');
    }
}