<?php

/**
 * @method $this setEntry
 * @method Emagedev_Yanws_Model_News getEntry
 * @method $this setLinks
 * @method array getLinks
 * @method $this setUtils
 * @method Emagedev_Yanws_Helper_ArticleUtils getUtils
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

            $links = array();
            if($prev->getId()) {
                $links['prev'] = $prev;
            } else {
                $links['prev'] = false;
            }

            if($next->getId()) {
                $links['next'] = $next;
            } else {
                $links['next'] = false;
            }

            $this->setLinks($links);
        }

        return $this;
    }
} 