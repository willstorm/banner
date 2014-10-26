<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright   Copyright (c) 2014 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Cms page edit form main tab
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */

class Storm_Banner_Block_Adminhtml_Group_Edit_Tab_Main extends Mage_Adminhtml_Block_Widget_Form  implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    protected function _prepareForm()
    {
        /* @var $model Storm_Banner_Model_Group */
        $model = Mage::registry('banner_group');
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('group_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend'=>Mage::helper('banner')->__('Group Information')));

        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', array(
                'name' => 'id',
            ));
        }

        $fieldset->addField('title', 'text', array(
            'name'      => 'title',
            'label'     => Mage::helper('banner')->__('Group Title'),
            'title'     => Mage::helper('banner')->__('Group Title'),
            'required'  => true,
        ));

        $fieldset->addField('code', 'text', array(
            'name'      => 'code',
            'label'     => Mage::helper('banner')->__('Code'),
            'title'     => Mage::helper('banner')->__('Code'),
            'required'  => true,
            'class'     => 'validate-identifier',
            'note'      => Mage::helper('banner')->__('The group code is used to identify groups to register widgets/blocks'),
        ));

        $fieldset->addField('is_active', 'select', array(
            'label'     => Mage::helper('banner')->__('Status'),
            'title'     => Mage::helper('banner')->__('Group Status'),
            'name'      => 'is_active',
            'required'  => true,
            // 'options'   => $model->getAvailableStatuses(),
        ));

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return Mage::helper('banner')->__('Group Information');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('banner')->__('Group Information');
    }

    /**
     * Returns status flag about this tab can be shown or not
     *
     * @return true
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Returns status flag about this tab hidden or not
     *
     * @return true
     */
    public function isHidden()
    {
        return false;
    }
}
