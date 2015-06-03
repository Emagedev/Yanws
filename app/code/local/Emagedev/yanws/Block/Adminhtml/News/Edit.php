<?php
/**
 * Created by PhpStorm.
 * User: skm293504
 * Date: 09.05.15
 * Time: 3:05
 */

class Emagedev_Yanws_Block_Adminhtml_Edit extends Mage_Adminhtml_Block_Widget {
    protected function _construct()
    {
        /// what????
        $this->_blockGroup = 'yanws';
        $this->_controller = 'adminhtml_news';
    }

    public function getHeaderText()
    {
        $helper = Mage::helper('yanws');
        $model = Mage::registry('current_news');

        if ($model->getId()) {
            return $helper->__("Edit News item '%s'", $this->escapeHtml($model->getTitle()));
        } else {
            return $helper->__("Add News item");
        }
    }
} 