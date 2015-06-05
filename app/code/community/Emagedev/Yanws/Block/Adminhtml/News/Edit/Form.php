<?php
/**
 * Created by PhpStorm.
 * User: skm293504
 * Date: 14.05.15
 * Time: 0:57
 */

class Emagedev_Yanws_Block_Adminhtml_News_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareForm()
    {
        $helper = Mage::helper('yanws');
        $model = Mage::registry('current_news');

        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/save', array(
                'id' => $this->getRequest()->getParam('id')
            )),
            'method' => 'post',
            'enctype' => 'multipart/form-data'
        ));

        $entry = $model->getData();
        $this->setForm($form);

        $fieldset = $form->addFieldset('news_form', array('legend' => $helper->__('News Information')));

        $wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig(array('add_variables' => false,
            'add_widgets' => false,
            'add_images' => true,
            'files_browser_window_url' => Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/cms_wysiwyg_images/index'),
            'files_browser_window_width' => (int) Mage::getConfig()->getNode('adminhtml/cms/browser/window_width'),
            'files_browser_window_height'=> (int) Mage::getConfig()->getNode('adminhtml/cms/browser/window_height')
        ));

        $fieldset->addField('title', 'text', array(
            'label' => $helper->__('Title'),
            'required' => true,
            'name' => 'title',
        ));
        $fieldset->addField('article', 'editor', array(
            'label' => $helper->__('Article'),
            'wysiwyg'   => true,
            'style'     => 'width:700px; height:400px;',
            'config'    => $wysiwygConfig,
            'required' => true,
            'name' => 'article',
        ));
        $fieldset->addField('is_shorten', 'checkbox', array(
            'label' => $helper->__('Use shorten'),
            'required' => false,
            'name' => 'is_shorten',
            'value' => empty($entry) ? false : $model->getIsShorten(),
            'checked' => empty($entry) ? false : $model->getIsShorten(),
            'onclick'   => 'this.value = this.checked ? 1 : 0;'
        ));
        $fieldset->addField('shorten_article', 'editor', array(
            'label' => $helper->__('Shorten article'),
            'required' => false,
            'style'     => 'width:98%; height:600px;',
            'wysiwyg'   => true,
            'config'    => $wysiwygConfig,
            'name' => 'shorten_article',
        ));
        $fieldset->addField('url', 'text', array(
            'label' => $helper->__('URL'),
            'required' => false,
            'after_element_html' => '<div id="url-view-helper"><p>Пример ссылки: </p><span id="url-view-helper-url"></span></div>',
            'name' => 'url',
        ));
        $fieldset->addField('is_published', 'checkbox', array(
            'label' => $helper->__('Is published'),
            'required' => false,
            'name' => 'is_published',
            'value' => empty($entry) ? '1' : $model->isPublished(),
            'onclick'   => 'this.value = this.checked ? 1 : 0;'
        ));
        /*$fieldset->addField('timestamp_created', 'datetime', array(
            'label' => $helper->__('Created'),
            'format' => Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
            'name' => 'created',
            'readonly' => true
        ));*/

        $form->getElement('is_published')->setIsChecked(empty($entry) ? true : $model->isPublished());
        $form->setUseContainer(true);

        if($data = Mage::getSingleton('adminhtml/session')->getFormData()){
            $form->setValues($data);
        } else {
            $form->setValues($model->getData());
        }

        return parent::_prepareForm();
    }

    /*protected function _prepareLayout()
    {
        $return = parent::_prepareLayout();
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        return $return;
    }*/

}