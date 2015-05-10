<?php
/**
 * Created by PhpStorm.
 * User: skm293504
 * Date: 08.05.15
 * Time: 13:42
 */

class Emagedev_Yanws_Adminhtml_YanwsController extends Mage_Adminhtml_Controller_Action {
    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('yanws');

        $contentBlock = $this->getLayout()->createBlock('yanws/adminhtml_news');
        $this->_addContent($contentBlock);
        $this->renderLayout();
    }
} 