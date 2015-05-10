<?php
/**
 * Created by PhpStorm.
 * User: skm293504
 * Date: 08.05.15
 * Time: 15:26
 */

class Emagedev_Yanws_Block_Adminhtml_News_Grid extends Mage_Adminhtml_Block_Widget_Grid {
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('yanws/news')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $helper = Mage::helper('yanws');

        $this->addColumn('id', array(
            'header' => $helper->__('ID'),
            'index' => 'id',
            'sortable'  => true,
            'editable'  => true
        ));
        $this->addColumn('title', array(
            'header' => $helper->__('Title'),
            'index' => 'title',
            'type' => 'text',
            'sortable'  => true,
            'editable'  => true
        ));
        $this->addColumn('article', array(
            'header' => $helper->__('Content'),
            'index' => 'article',
            'type' => 'text',
            'sortable'  => true,
            'editable'  => true
        ));
        $this->addColumn('shorten_article', array(
            'header' => $helper->__('Shorten'),
            'index' => 'article',
            'type' => 'text',
            'sortable'  => true,
            'editable'  => true
        ));
        $this->addColumn('url', array(
            'header' => $helper->__('URL'),
            'index' => 'url',
            'type' => 'text',
            'sortable'  => true,
            'editable'  => true
        ));
        $this->addColumn('timestamp_created', array(
            'header' => $helper->__('Created'),
            'index' => 'timestamp_created',
            'type' => 'datetime',
            'sortable'  => true,
            'editable'  => false
        ));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('news');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => $this->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
        ));
        return $this;
    }
} 