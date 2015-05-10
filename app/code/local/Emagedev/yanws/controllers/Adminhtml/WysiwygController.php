<?php
/**
 * Created by PhpStorm.
 * User: skm293504
 * Date: 09.05.15
 * Time: 3:08
 */

class Emagedev_Yanws_Adminhtml_WysiwygController extends Mage_Adminhtml_Controller_Action {
    public function indexAction() {
        $this->loadLayout();
        $this->_setActiveMenu('yanws');

        $contentBlock = $this->getLayout()->createBlock('yanws/adminhtml_news');
        $this->_addContent($contentBlock);
        $this->renderLayout();
    }
} 