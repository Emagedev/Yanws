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

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $id = (int) $this->getRequest()->getParam('id');
        Mage::register('current_news', Mage::getModel('yanws/news')->load($id));

        $this->loadLayout()->_setActiveMenu('yanws');
        $this->_addContent($this->getLayout()->createBlock('yanws/adminhtml_news_edit'));
        $this->renderLayout();
    }

    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            try {
                $model = Mage::getModel('yanws/news');
                $model->setData($data)->setId($this->getRequest()->getParam('id'));
                $model->save();

                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('News was saved successfully'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array(
                    'id' => $this->getRequest()->getParam('id')
                ));
            }
            return;
        }
        Mage::getSingleton('adminhtml/session')->addError($this->__('Unable to find item to save'));
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        if ($id = $this->getRequest()->getParam('id')) {
            try {
                Mage::getModel('yanws/news')->setId($id)->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('News was deleted successfully'));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $id));
            }
        }
        $this->_redirect('*/*/');
    }
} 