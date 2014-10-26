<?php
/**
 * Banner rotate
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   Storm
 * @package    Storm_Banner
 * @copyright  Copyright (c) 2014 Storm
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author     Willian Cordeiro de Souza <williancordeirodesouza@gmail.com>
 */
class Storm_Banner_Block_Adminhtml_Group_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('bannerGroupGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('ASC');
    }

    /**
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('banner/group')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * @return $this
     * @throws Exception
     */
    protected function _prepareColumns()
    {
        $this->addColumn('id', array(
            'header'    => Mage::helper('banner')->__('ID'),
            'align'     => 'left',
            'index'     => 'id',
        ));

        $this->addColumn('code', array(
            'header'    => Mage::helper('banner')->__('Code'),
            'index'     => 'code',
        ));

        $this->addColumn('title', array(
            'header'    => Mage::helper('banner')->__('Title'),
            'align'     => 'left',
            'index'     => 'title',
        ));

        $this->addColumn('is_active', array(
            'header'    => Mage::helper('banner')->__('Status'),
            'index'     => 'is_active',
            'type'      => 'options',
            'options'   => array(
                0 => Mage::helper('banner')->__('Disabled'),
                1 => Mage::helper('banner')->__('Enabled')
            ),
        ));

        return parent::_prepareColumns();
    }

    /**
     * @param $row Varien_Object
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}