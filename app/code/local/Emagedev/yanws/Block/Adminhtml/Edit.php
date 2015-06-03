<?php
/**
 * Created by PhpStorm.
 * User: skm293504
 * Date: 09.05.15
 * Time: 3:05
 */

class Emagedev_Yanws_Block_Adminhtml_Editor extends Mage_Adminhtml_Block_Widget {
    protected function _construct() {
        parent::_construct();
        $helper = Mage::helper('yanws');
        $this->_blockGroup = 'yanws';
        $this->_controller = 'adminhtml_editor';


    }
} 