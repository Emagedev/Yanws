<?php
/**
 * Created by PhpStorm.
 * User: skm293504
 * Date: 08.05.15
 * Time: 2:04
 */

class Emagedev_Yanws_IndexController extends Mage_Core_Controller_Front_Action {


    public function indexAction()
    {
        $viewHelper = Mage::helper('yanws/news');
        $viewHelper->initFeed();
        $this->loadLayout();
        $this->renderLayout();
    }

    public function viewAction() {
        $viewHelper = Mage::helper('yanws/news');
        $page = $this->getRequest()->getParam("page");
        if($viewHelper->initEntry($page)) {
            $this->loadLayout();
            $this->renderLayout();
        } else {
            $this->_forward('noRoute');
        }

    }
}