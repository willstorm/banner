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
class Storm_Banner_Block_Adminhtml_Group extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_blockGroup = 'banner';
        $this->_controller = 'adminhtml_group';
        $this->_headerText = Mage::helper('banner')->__('Banner Groups');
        $this->_addButtonLabel = Mage::helper('banner')->__('Add New Group');
        parent::__construct();
    }
}
