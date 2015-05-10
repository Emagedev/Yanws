<?php
/**
 * Created by PhpStorm.
 * User: skm293504
 * Date: 10.05.15
 * Time: 13:11
 */

class Emagedev_Yanws_Helper_News extends Mage_Core_Helper_Url {
    public function initEntry($entryUrl) {
        $entry = Mage::getModel('yanws/news')
            ->load($entryUrl, 'url');

        $collectionPublished = Mage::getModel('yanws/news')
            ->getCollection()
            ->addFieldToFilter('is_published', array('eq' => 1))
            /*->addAttributeToSort('id', 'desc')
            ->addAttributeToSort('timestamp_created', 'desc')*/;

        $entryTimestamp = $entry->getTimestampCreated();

        $prev = $collectionPublished
            ->addFieldToFilter('timestamp_created', array('lt' => $entryTimestamp))
            ->setOrder('id', 'desc')->getFirstItem();
        $next = $collectionPublished
            ->addFieldToFilter('timestamp_created', array('gt' => $entryTimestamp))
            ->setOrder('id', 'asc')->getLastItem();

        if (!$entry->isPublished()) {
            return false;
        } else {
            Mage::register('yanws_entry', $entry);
            Mage::register('yanws_near_links', array('next' => $next, 'prev' => $prev));
            return $entry;
        }
    }

    public function initFeed() {
        $feed = Mage::getModel('yanws/news')
            ->getCollection()
            ->addFieldToFilter('is_published', array('eq' => 1))
            ->setOrder('timestamp_created', 'DESC');

        Mage::register('yanws_feed', $feed);
        return $feed;
    }
} 