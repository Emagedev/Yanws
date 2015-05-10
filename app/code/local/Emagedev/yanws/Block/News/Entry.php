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

        $this->setLinks(Mage::registry('yanws_near_links'));
        $this->setEntry(Mage::registry('yanws_entry'));
        $this->setUtils(Mage::helper('yanws/articleUtils'));

        return $this;
    }
} 