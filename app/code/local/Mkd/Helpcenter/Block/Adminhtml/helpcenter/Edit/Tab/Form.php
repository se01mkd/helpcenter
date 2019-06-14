<?php

class Mkd_Helpcenter_Block_Adminhtml_Helpcenter_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form {

	protected function _prepareLayout()
	{
		if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled())
		{
			$this->getLayout()->getBlock('head')->setCanLoadTinyMce(TRUE);
			$this->getLayout()->getBlock('head')->setCanLoadExtJs(TRUE);
		}
		parent::_prepareLayout();
	}

	protected function _prepareForm()
	{
		$configSettings = Mage::getSingleton('cms/wysiwyg_config')->getConfig(
		  [
			'add_widgets' => FALSE,
			'add_variables' => FALSE,
			'add_images' => FALSE,
			'files_browser_window_url' => $this->getBaseUrl().'admin/cms_wysiwyg_images/index/',
		  ]);

		$form = new Varien_Data_Form();
		$this->setForm($form);

		$fieldset = $form->addFieldset('topic',
		  ['legend' => 'Topic Information']);

		$fieldset->addField('title', 'text',
		  [
			'label' => 'Title',
			'class' => 'required-entry',
			'required' => TRUE,
			'name' => 'title',
		    'can_use_default_value' => 'true',
		    'can_use_website_value' => 'true'
		  ])
		  ->setRenderer(Mage::getBlockSingleton('adminhtml/system_config_form_field'));

		$fieldset->addField('description', 'editor', [
		  'name' => 'description',
		  'label' => 'Description',
		  'title' => 'Description',
		  'style' => 'width:700px; height:120px;',
		  'wysiwyg' => TRUE,
		  'required' => TRUE,
		  'config' => $configSettings,
		]);


		$fieldset->addField('meta_keywords', 'textarea',
		  [
			'label' => 'Meta Keywords',
			'class' => 'text-entry',
			'name' => 'meta_keywords',
			'style' => 'width:700px; height:70px;',

		  ]);
		$fieldset->addField('meta_description', 'textarea',
		  [
			'label' => 'Meta Description',
			'name' => 'meta_description',
			'style' => 'width:700px; height:70px;',
		  ]);
		$fieldset->addField('is_active', 'select',
		  [
			'label' => 'Is Active',
			'values' => Mage::getModel('adminhtml/system_config_source_yesno')
			  ->toOptionArray(),
			'class' => 'text-entry',
			'name' => 'is_active',

		  ]);

		$fieldset->addField('sort_order', 'text',
		  [
			'label' => 'Sort Orders',
			'class' => 'text-entry validate-number',
			'name' => 'sort_order',

		  ]);

		if (Mage::registry('topic'))
		{
			$form->setValues(Mage::registry('topic')->getData());
		}

		return parent::_prepareForm();
	}
}