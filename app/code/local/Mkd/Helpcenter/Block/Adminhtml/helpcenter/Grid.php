<?php

class Mkd_Helpcenter_Block_Adminhtml_Helpcenter_Grid extends Mage_Adminhtml_Block_Widget_Grid {

	public function __construct()
	{
		parent::__construct();
		$this->setDefaultSort('created_at');
		$this->setDefaultDir('desc');
	}

	protected function _prepareCollection()
	{
		$collection = Mage::getResourceModel('helpcenter/collection_topic');
		$this->setCollection($collection);

		return parent::_prepareCollection();
	}

	protected function _prepareMassaction()
	{
		$this->setMassactionIdField('helpcenter_topic_id');
		$this->getMassactionBlock()->setFormFieldName('ids');
		$this->getMassactionBlock()->addItem('delete', [
		  'label' => 'Delete',
		  'url' => $this->getUrl('*/*/massDelete'),
		  'confirm' => 'Are you sure?',
		]);
		$this->getMassactionBlock()->addItem('active', [
		  'label' => 'Active',
		  'url' => $this->getUrl('*/*/massStatus/type/1'),
		]);
		$this->getMassactionBlock()->addItem('inactive', [
		  'label' => 'Inactive',
		  'url' => $this->getUrl('*/*/massStatus/type/0'),
		]);
		$this->getMassactionBlock()->addItem('inactive', [
		  'label' => 'Update Sort Order',
		  'url' => $this->getUrl('*/*/massSortOrder'),
		]);
		return $this;
	}


	protected function _prepareColumns()
	{

		$this->addColumn('helpcenter_topic_id',
		  [
			'header' => $this->__('ID'),
			'align' => 'left',
			'width' => '50px',
			'index' => 'helpcenter_topic_id',
		  ]
		);
		$this->addColumn('title',
		  [
			'header' => $this->__('Title'),
			'align' => 'left',
			'width' => '50px',
			'index' => 'title',
		  ]
		);
		$this->addColumn('descripton',
		  [
			'header' => $this->__('Description'),
			'align' => 'left',
			'width' => '50px',
			'index' => 'descripton',
		  ]
		);
		$this->addColumn('is_active',
		  [
			'header' => $this->__('Is Active'),
			'align' => 'center',
			'width' => '50px',
			'index' => 'is_active',
		    'type'  => 'options',
			'options' => Mage::getModel('adminhtml/system_config_source_yesno')->toArray(),
		  ]
		);
		$this->addColumn('sort',
		  [
			'header' => $this->__('Sort Order'),
			'align' => 'center',
			'width' => '50px',
			'index' => 'sort_order',

		  ]
		);
		$this->addColumn('creation_time',
		  [
			'header' => $this->__('Created At'),
			'index' => 'creation_time',
			'type' => 'date',
		    'align' => 'left',
			'format' => Mage::app()
			  ->getLocale()
			  ->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM),
		  ]
		);
		$this->addExportType('*/*/exportCsv', 'CSV');
		$this->addExportType('*/*/exportXml', 'XML');


		return parent::_prepareColumns();
	}

	public function getRowUrl($row)
	{
		return $this->getUrl('*/*/edit', ['id' => $row->getId()]);
	}

}