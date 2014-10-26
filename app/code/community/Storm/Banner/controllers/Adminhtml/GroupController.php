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
class Storm_Banner_Adminhtml_GroupController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('cms/banner/group')
            ->_addBreadcrumb(Mage::helper('banner')->__('CMS'), Mage::helper('banner')->__('CMS'))
            ->_addBreadcrumb(Mage::helper('banner')->__('Manage Banners'), Mage::helper('banner')->__('Manage Banners'));

        return $this;
    }

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->_title($this->__('CMS'))
            ->_title($this->__('Banners'))
            ->_title($this->__('Manage Groups'));

        $this->_initAction();
        $this->renderLayout();
    }

    /**
     * Create new CMS page
     * @TODO
     */
    public function newAction()
    {
        // the same form is used to create and edit
        $this->_forward('edit');
    }

    /**
     * Edit CMS page
     * @TODO
     */
    public function editAction()
    {
        $this->_title($this->__('CMS'))
            ->_title($this->__('Banners'))
            ->_title($this->__('Manage Groups'));

        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('banner/group');

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (! $model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('banner')->__('This group no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }

        $this->_title($model->getId() ? $model->getTitle() : $this->__('New Group'));

        // 3. Set entered data if was error when we do save
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (! empty($data)) {
            $model->setData($data);
        }

        // 4. Register model to use later in blocks
        Mage::register('banner_group', $model);

        // 5. Build edit form
        $this->_initAction()
            ->_addBreadcrumb(
                $id ? Mage::helper('cms')->__('Edit Group')
                    : Mage::helper('cms')->__('New Group'),
                $id ? Mage::helper('cms')->__('Edit Group')
                    : Mage::helper('cms')->__('New Group'));

        $this->renderLayout();
    }

    /**
     * Save action
     * @TODO
     */
    public function saveAction()
    {
        // check if data sent
        if ($data = $this->getRequest()->getPost()) {
            $data = $this->_filterPostData($data);
            //init model and set data
            $model = Mage::getModel('cms/page');

            if ($id = $this->getRequest()->getParam('page_id')) {
                $model->load($id);
            }

            $model->setData($data);

            Mage::dispatchEvent('cms_page_prepare_save', array('page' => $model, 'request' => $this->getRequest()));

            //validating
            if (!$this->_validatePostData($data)) {
                $this->_redirect('*/*/edit', array('page_id' => $model->getId(), '_current' => true));
                return;
            }

            // try to save it
            try {
                // save the data
                $model->save();

                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('cms')->__('The page has been saved.'));
                // clear previously saved data from session
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                // check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('page_id' => $model->getId(), '_current'=>true));
                    return;
                }
                // go to grid
                $this->_redirect('*/*/');
                return;

            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
            catch (Exception $e) {
                $this->_getSession()->addException($e,
                    Mage::helper('cms')->__('An error occurred while saving the page.'));
            }

            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/edit', array('page_id' => $this->getRequest()->getParam('page_id')));
            return;
        }
        $this->_redirect('*/*/');
    }

    /**
     * Delete action
     * @TODO
     */
    public function deleteAction()
    {
        // check if we know what should be deleted
        if ($id = $this->getRequest()->getParam('page_id')) {
            $title = "";
            try {
                // init model and delete
                $model = Mage::getModel('cms/page');
                $model->load($id);
                $title = $model->getTitle();
                $model->delete();
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('cms')->__('The page has been deleted.'));
                // go to grid
                Mage::dispatchEvent('adminhtml_cmspage_on_delete', array('title' => $title, 'status' => 'success'));
                $this->_redirect('*/*/');
                return;

            } catch (Exception $e) {
                Mage::dispatchEvent('adminhtml_cmspage_on_delete', array('title' => $title, 'status' => 'fail'));
                // display error message
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                // go back to edit form
                $this->_redirect('*/*/edit', array('page_id' => $id));
                return;
            }
        }
        // display error message
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('cms')->__('Unable to find a page to delete.'));
        // go to grid
        $this->_redirect('*/*/');
    }
}