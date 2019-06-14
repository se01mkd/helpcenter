<?php

class Mkd_Helpcenter_Block_Adminhtml_Helpcenter_Edit extends Mage_Adminhtml_Block_Widget_Form_Container{

		public function __construct()
		{
				parent::__construct();
				//you will notice that assigns the same blockGroup the Grid Container
				$this->_blockGroup = 'admin_helpcenter';
				// and the same container
				$this->_controller = 'helpcenter';
				$this->_addButton('save_and_continue', array(
					'label' => 'Save And Continue Edit',
					'onclick' => 'saveAndContinueEdit()',
					'class' => 'save'
				));
				$this->_formScripts[] = "
             function saveAndContinueEdit(){
                editForm.submit($('edit_form').action + 'back/edit/');
             }
             ";
		}

		/* Here, we look at whether it was transmitted item to form
		 * to put the right text in the header (Add or Edit)
		 */

		public function getHeaderText()
		{
				if( Mage::registry('topic') && Mage::registry('topic')->getId() )
				{
						return 'Edit a topic "'.$this->htmlEscape( Mage::registry('topic')->getTitle().'"' );
				}
				else
				{
						return 'Add a topic';
				}
		}
}