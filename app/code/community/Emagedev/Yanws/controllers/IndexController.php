<?php

/**
 * Created by PhpStorm.
 * User: skm293504
 * Date: 08.05.15
 * Time: 2:04
 */
class Emagedev_Yanws_IndexController extends Mage_Core_Controller_Front_Action
{


    public function indexAction()
    {
        $this->_title($this->__("News"));
        $this->loadLayout();
        $this->renderLayout();
    }

    public function viewAction()
    {
        $helper = Mage::helper('yanws');
        $page = $this->getRequest()->getParam("page");

        $entry = $helper->checkExistenceByUrl($page, true);

        if ($entry !== false) {
            Mage::register('yanws_entry', $entry);
            $this->_title($this->__("News"))->_title($entry->getTitle());
            $this->loadLayout();
            $this->renderLayout();
        } else {
            $this->_forward('noRoute');
        }

    }
}