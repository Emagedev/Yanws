<?php

/**
 * Created by PhpStorm.
 * User: skm293504
 * Date: 08.05.15
 * Time: 13:42
 */
class Emagedev_Yanws_Adminhtml_YanwsController extends Mage_Adminhtml_Controller_Action
{
    // TODO: REFACTOR

    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('yanws');
        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $id = (int)$this->getRequest()->getParam('id');

        // It's okay, anyway
        Mage::register('current_news', Mage::getModel('yanws/news')->load($id));

        $this->loadLayout()->_setActiveMenu('yanws');
        $this->renderLayout();
    }

    public function saveAction()
    {
        $session = $this->_getSession();
        if ($data = $this->getRequest()->getPost()) {
            try {
                $data['is_shorten'] = empty($data['is_shorten']) ? 0 : $data['is_shorten'];
                $data['is_published'] = empty($data['is_published']) ? 1 : $data['is_published'];

                $model = Mage::getModel('yanws/news');
                $model->setData($data)->setId($this->getRequest()->getParam('id'));

                $model->save();

                $session->addSuccess($this->__('News was saved successfully'));
                $session->setFormData(false);
                $session->_redirect('*/*/');
            } catch (Exception $e) {
                $session->addError($e->getMessage());
                $session->setFormData($data);
                $this->_redirect('*/*/edit', array(
                    'id' => $this->getRequest()->getParam('id')
                ));
            }
            return;
        }
        $session->addError($this->__('Unable to find item to save'));
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        if ($id = $this->getRequest()->getParam('id')) {
            try {
                Mage::getModel('yanws/news')->setId($id)->delete();
                $this->_getSession()->addSuccess($this->__('News was deleted successfully'));
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $id));
            }
        }
        $this->_redirect('*/*/');
    }

    public function massDeleteAction()
    {
        $ids = $this->getRequest()->getParam('Yanws');
        if (!is_array($ids)) {
            $this->_getSession()->addError($this->__('Please select entries'));
        } else {
            try {
                foreach ($ids as $id) {
                    $news = Mage::getModel('yanws/news')->load($id);
                    $news->delete();
                }
                $this->_getSession()->addSuccess(
                    $this->__(
                        'Total of %d entries were successfully deleted', count($ids)
                    )
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
} 