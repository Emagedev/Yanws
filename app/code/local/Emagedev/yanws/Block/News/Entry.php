<?php
/**
 * Created by PhpStorm.
 * User: skm293504
 * Date: 09.05.15
 * Time: 3:42
 */

class Emagedev_Yanws_Block_News_Entry extends Mage_Core_Block_Template {
    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $entry = Mage::getModel('yanws/news')
            ->load(Mage::app()->getRequest()->getParam("page"), 'url');

        $collectionPublished = Mage::getModel('yanws/news')
            ->getCollection();

        $entryTimestamp = $entry->getTimestampCreated();

        $prev = $collectionPublished
            ->addFieldToFilter('is_published', array('eq' => 1))
            ->addFieldToFilter('timestamp_created', array('lt' => $entryTimestamp))
            ->getFirstItem();

        $collectionPublished = Mage::getModel('yanws/news')
            ->getCollection();

        $next = $collectionPublished
            ->addFieldToFilter('is_published', array('eq' => 1))
            ->addFieldToFilter('timestamp_created', array('gt' => $entryTimestamp))
            ->getFirstItem();

        if ($entry->isPublished()) {
            $this->setEntry($entry);
            $this->setLinks(array('next' => $next, 'prev' => $prev));
        }
        
        $this->setUtils(Mage::helper('yanws/articleUtils'));

        return $this;
    }
} 