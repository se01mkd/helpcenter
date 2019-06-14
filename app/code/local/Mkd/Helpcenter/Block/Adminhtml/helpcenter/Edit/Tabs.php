<?php

class Mkd_Helpcenter_Block_Adminhtml_Helpcenter_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {

	public function __construct()
	{
		parent::__construct();
		$this->setId('topic_tab');
		$this->setDestElementId('edit_form');
		$this->setTitle('Topic Infomation');
	}

	protected function _beforeToHtml()
	{
		$this->addTab('form_section', [
		  'label' => 'Topic',
		  'title' => 'Topic',
		  'content' => $this->getLayout()
			->createBlock('admin_helpcenter/helpcenter_edit_tab_form')
			->toHtml(),
		]);
		$this->addTab('article', [
		  'label' => 'Article',
		  'title' => 'Article',
		  'url' => $this->getUrl('*/*/articlestab', ['_current' => TRUE]),
		  'class' => 'ajax',
		]);
		return parent::_beforeToHtml();
	}
}