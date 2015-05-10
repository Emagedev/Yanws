<?php
/**
 * Created by PhpStorm.
 * User: skm293504
 * Date: 09.05.15
 * Time: 3:05
 */

class Emagedev_Yanws_Block_Adminhtml_Editor extends Mage_Adminhtml_Block_Abstract {
    public function _construct() {
        $helper = Mage::helper('yanws');
        $this->_blockGroup = 'yanws';
        $this->_controller = 'adminhtml_news';

        $this->_headerText = $helper->__('News entry');
    }
} 