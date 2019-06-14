<?php

class Mkd_Helpcenter_Block_Adminhtml_Helpcenter_Edit_Tab_Article
  extends Mage_Adminhtml_Block_Widget_Grid {

	public function __construct()
	{
		parent::__construct();
		$this->setSaveParametersInSession(TRUE);
		$this->setUseAjax(TRUE);
		$this->setId('helpcenter_article_lists');

	}

	protected function _prepareCollection()
	{
		$collection = Mage::getResourceModel('helpcenter/collection_article');
		$collection->getSelect()->joinLeft(
		  ['topic' => 'helpcenter_topic'],
		  'topic.helpcenter_topic_id = main_table.helpcenter_topic_id',
		  [
			'topic.title' => 'topic.title',
			'main_table.title' => 'main_table.title',
		  ]
		);

		$this->setCollection($collection);
		return parent::_prepareCollection();
	}

	protected function _prepareColumns()
	{

		$this->addColumn('article',
		  [
			'header' => '',
			'align' => 'center',
			'type' => 'checkbox',
			'field_name' => 'article',
			'index' => 'helpcenter_article_id',
			'values' => $this->getSelectedArticles(),
		  ]);

		$this->addColumn('helpcenter_article_id',
		  [
			'header' => $this->__('ID'),
			'align' => 'center',
			'width' => '50px',
			'index' => 'helpcenter_article_id',
		  ]
		);
		$this->addColumn('grid_title',
		  [
			'header' => $this->__('Title'),
			'align' => 'left',
			'width' => '50px',
			'index' => 'main_table.title',
		  ]
		);
		$this->addColumn('grid_descripton',
		  [
			'header' => $this->__('Description'),
			'align' => 'center',
			'width' => '50px',
			'index' => 'descripton',
		  ]
		);
		$this->addColumn('topic_title',
		  [
			'header' => $this->__('Topic'),
			'align' => 'center',
			'width' => '50px',
			'index' => 'topic.title',
		  ]
		);

		return parent::_prepareColumns();
	}

	public function getGridUrl()
	{
		return $this->getUrl('*/*/articlesGrid', ['_current' => TRUE]);
	}

	public function getRowUrl($item)
	{
		return '#';
	}

}