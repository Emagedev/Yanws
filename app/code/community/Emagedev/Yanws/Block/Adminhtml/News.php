<?php

/**
 * Created by PhpStorm.
 * User: skm293504
 * Date: 08.05.15
 * Time: 15:08
 */
class Emagedev_Yanws_Block_Adminhtml_News extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    protected function _construct()
    {
        parent::_construct();

        $this->_blockGroup = 'yanws';
        $this->_controller = 'adminhtml_news';

        $this->_headerText = $this->__('News management');
        $this->_addButtonLabel = $this->__('New entry');
    }
} 