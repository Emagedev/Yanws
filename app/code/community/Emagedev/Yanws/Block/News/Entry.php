<?php

/**
 * Created by PhpStorm.
 * User: skm293504
 * Date: 09.05.15
 * Time: 3:42
 */
class Emagedev_Yanws_Block_News_Entry extends Mage_Core_Block_Template
{
    public function _construct()
    {
        $this->setUtils(Mage::helper('yanws/articleUtils'));
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        /** @var Emagedev_Yanws_Model_News $entry */
        $entry = Mage::registry('yanws_entry');

        $entryTimestamp = $entry->getTimestampCreated();

        $prev = Mage::getModel('yanws/news')
            ->getCollection()
            ->addFieldToFilter('is_published', array('eq' => 1))
            ->addFieldToFilter('timestamp_created', array('lt' => $entryTimestamp))
            ->setOrder('timestamp_created', 'desc')
            ->setPageSize(1)
            ->setCurPage(1)
            ->getFirstItem();

        $next = Mage::getModel('yanws/news')
            ->getCollection()
            ->addFieldToFilter('is_published', array('eq' => 1))
            ->addFieldToFilter('timestamp_created', array('gt' => $entryTimestamp))
            ->setOrder('timestamp_created', 'asc')
            ->setPageSize(1)
            ->setCurPage(1)
            ->getFirstItem();

        if ($entry->isPublished()) {
            $this->setEntry($entry);
            $this->setLinks(array('next' => $next, 'prev' => $prev));
        }

        return $this;
    }
} 