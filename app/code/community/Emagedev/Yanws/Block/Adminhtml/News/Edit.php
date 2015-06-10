<?php

/**
 * Created by PhpStorm.
 * User: skm293504
 * Date: 09.05.15
 * Time: 3:05
 */
class Emagedev_Yanws_Block_Adminhtml_News_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function _construct()
    {
        parent::_construct();

        $this->_blockGroup = 'yanws';
        $this->_controller = 'adminhtml_news';
    }

    public function getHeaderText()
    {
        $model = Mage::registry('current_news');

        if ($model->getId()) {
            return $this->__("Edit news entry '%s'", $this->escapeHtml($model->getTitle()));
        } else {
            return $this->__("Add news entry");
        }
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
        }
    }
} 