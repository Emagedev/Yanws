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
        $this->loadLayout();
        $this->renderLayout();
    }

    public function viewAction() {
        $helper = Mage::helper('yanws');
        $page = $this->getRequest()->getParam("page");
        if($helper->checkExistenceByUrl($page, true)) {
            $this->loadLayout();
            $this->renderLayout();
        } else {
            $this->_forward('noRoute');
        }

    }
}