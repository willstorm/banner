<?php
class Storm_Banner_Block_Adminhtml_Group_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_blockGroup = 'banner';
        $this->_controller = 'adminhtml_group';

        $this->_updateButton('save', 'label', Mage::helper('banner')->__('Save Group'));
        $this->_updateButton('delete', 'label', Mage::helper('banner')->__('Delete Group'));

        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('banner')->__('Save and Continue Edit'),
            'onclick'   => 'saveAndContinueEdit(\''.$this->_getSaveAndContinueUrl().'\')',
            'class'     => 'save',
        ), -100);
    }

    public function getHeaderText()
    {
        if (Mage::registry('banner_group')->getId()) {
            return Mage::helper('banner')->__('Edit Group %s', $this->escapeHtml(Mage::registry('banner_group')->getTitle()));
        }
        else {
            return Mage::helper('banner')->__('New Group');
        }
    }

    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl('*/*/save', array(
            '_current'   => true,
            'back'       => 'edit',
            'active_tab' => '{{tab_id}}'
        ));
    }

    protected function _prepareLayout()
    {
        $tabsBlock = $this->getLayout()->getBlock('banner_group_edit_tabs');
        if ($tabsBlock) {
            $tabsBlockJsObject = $tabsBlock->getJsObjectName();
            $tabsBlockPrefix   = $tabsBlock->getId() . '_';
        } else {
            $tabsBlockJsObject = 'group_tabsJsTabs';
            $tabsBlockPrefix   = 'group_tabs_';
        }

        $this->_formScripts[] = "
            function saveAndContinueEdit(urlTemplate) {
                var tabsIdValue = " . $tabsBlockJsObject . ".activeTab.id;
                var tabsBlockPrefix = '" . $tabsBlockPrefix . "';
                if (tabsIdValue.startsWith(tabsBlockPrefix)) {
                    tabsIdValue = tabsIdValue.substr(tabsBlockPrefix.length)
                }
                var template = new Template(urlTemplate, /(^|.|\\r|\\n)({{(\w+)}})/);
                var url = template.evaluate({tab_id:tabsIdValue});
                editForm.submit(url);
            }
        ";
        return parent::_prepareLayout();
    }
}
