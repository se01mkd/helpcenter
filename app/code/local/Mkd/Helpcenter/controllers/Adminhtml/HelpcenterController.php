<?php

/*@var Varien_Data_Collection_Db */

class Mkd_Helpcenter_Adminhtml_HelpcenterController extends Mage_Adminhtml_Controller_Action {

	public function indexAction()
	{
		$this->loadLayout();
		$this->_title($this->__("Help Center"));
		$this->_setActiveMenu('cms/helpcenter');
		$this->renderLayout();
	}

	public function newAction()
	{
		$this->_forward('edit');
	}

	public function editAction()
	{
		$topicId = $this->getRequest()->getParam('id');
		$topicModel = Mage::getModel('helpcenter/topic')->load($topicId);
		if ($topicModel->getId() != NULL || $topicId == NULL)
		{
			Mage::register('topic', $topicModel);

			$this->loadLayout();
			$this->_setActiveMenu('cms/helpcenter');
			$this->_addBreadcrumb('Help Center', 'Helpcenter',
			  $this->getUrl('*/*'));
			$this->_addBreadcrumb('Add/Edit Topic ', 'Topic Description');

			$this->_addContent($this->getLayout()
			  ->createBlock('admin_helpcenter/helpcenter_edit'))
			  ->_addLeft($this->getLayout()
				->createBlock('admin_helpcenter/helpcenter_edit_tabs')
			  );
			$this->renderLayout();
		} else
		{
			Mage::getSingleton('adminhtml/session')
			  ->addError('Topic does not exist');
			$this->_redirect('*/*/');
		}
	}

	public function saveAction()
	{
		if ($articles = $this->getRequest()->getParam('article_ids', NULL))
		{
			$articles = Mage::helper('adminhtml/js')
			  ->decodeGridSerializedInput($articles);
		}
		if ($this->getRequest()->getPost())
		{
			try
			{
				$param = $this->getRequest()->getPost();
				$topic_id = $this->getRequest()->getParam('id');

				$topicModel = Mage::getModel('helpcenter/topic');

				if ($this->getRequest()->getParam('id') == NULL) // nếu ko có id
				{
					$topicModel->setCreationTime(date(now()));
				} else
				{
					$topicModel->load($topic_id);
				}
				$topicModel->setData('title', $param['title']);
				$topicModel->setData('description', $param['description']);
				$topicModel->setData('meta_keywords', $param['meta_keywords']);
				$topicModel->setData('meta_description',
				  $param['meta_description']);
				$topicModel->setData('is_active', $param['is_active']);
				$topicModel->setData('sort_order', $param['sort_order']);
				$topicModel->setData('updated_time', date(now()));

				//								$topicModel->setTitle($param['title']);
				//								$topicModel->setDescription($param['description']);
				//								$topicModel->setMetaKeywords($param['meta_keywords']);
				//								$topicModel->setMetaDescription($param['meta_description']);
				//								$topicModel->setIsActive($param['is_active']);
				//								$topicModel->setSortOrder($param['sort_order']);
				//								$topicModel->setUpdatedTime(date(now()));

				$topicModel->save();

				$topic_id = $topicModel->getID();

				Mage::getResourceModel('helpcenter/collection_article')
				  ->addFieldToFilter('helpcenter_topic_id', $topic_id)
				  ->setDataToAll('helpcenter_topic_id', NULL)->save();

				Mage::getResourceModel('helpcenter/collection_article')
				  ->addFieldToFilter('helpcenter_article_id',
					['in' => $articles])
				  ->setDataToAll('helpcenter_topic_id', $topic_id)->save();


				Mage::getSingleton('adminhtml/session')
				  ->addSuccess('Topic saved');
				if ($this->getRequest()->getParam('back'))
				{
					return $this->_redirect(
					  '*/*/edit',
					  [
						'id' => $topic_id,
					  ]
					);

				}

				return $this->_redirect('*/*/');
			} catch (Exception $e)
			{

				Mage::getSingleton('adminhtml/session')
				  ->addError($e->getMessage());
				$this->_redirect('*/*/edit',
				  ['id' => $this->getRequest()->getParam('id')]);
			}


		}
		$this->_redirect('*/*/');
	}

	public function deleteAction()
	{
		try
		{
			$topic = $this->getRequest()->getParam('id');
			$topic = Mage::getModel('helpcenter/topic')
			  ->load($topic);
			if ($topic != NULL)
			{
				$topic->delete();
				Mage::getSingleton('adminhtml/session')
				  ->addSuccess('Topic deleted');
			} else
			{
				Mage::getSingleton('adminhtml/session')
				  ->addError('Topic does not exist');
			}
			$this->_redirect('*/*/');
		} catch (Exception $e)
		{
			Mage::getSingleton('adminhtml/session')
			  ->addError($e->getMessage());
			$this->_redirect('*/*/');
		}

	}

	public function massDeleteAction()
	{
		$topics = $this->getRequest()->getParam('ids');
		if ( ! is_array($topics))
		{
			Mage::getSingleton('adminhtml/session')
			  ->addError('Please select item(s)');
		} else
		{
			try
			{

				$deleteTopics = Mage::getResourceModel('helpcenter/collection_topic')
				  ->addFieldToFilter('helpcenter_topic_id', ['in' => $topics])
				  ->walk('delete');

				Mage::getSingleton('adminhtml/session')->addSuccess(
				  Mage::helper('adminhtml')
					->__('Total of %d record(s) were successfully deleted',
					  count($deleteTopics))
				);
			} catch (Exception $e)
			{
				Mage::getSingleton('adminhtml/session')
				  ->addError($e->getMessage());
			}
		}
		$this->_redirect('*/*/');
	}

	public function massStatusAction()
	{

		$topics = $this->getRequest()->getParam('ids');
		$type = $this->getRequest()->getParam('type');

		if ( ! is_array($topics))
		{
			Mage::getSingleton('adminhtml/session')
			  ->addError('Please select item(s)');
		} else
		{
			try
			{

				$changeStatusTopics = Mage::getResourceModel('helpcenter/collection_topic')
				  ->addFieldToFilter('helpcenter_topic_id', ['in' => $topics])
				  ->setDataToAll('is_active', $type)
				  ->save();


				Mage::getSingleton('adminhtml/session')->addSuccess(
				  Mage::helper('adminhtml')
					->__('Total of %d record(s) were successfully change status',
					  count($changeStatusTopics))
				);
			} catch (Exception $e)
			{
				Mage::getSingleton('adminhtml/session')
				  ->addError($e->getMessage());
			}
		}
		$this->_redirect('*/*/');
	}

	public function exportCsvAction()
	{
		echo "\xEF\xBB\xBF";
		$fileName = 'helpcenter_topic.csv';
		$content = $this->getLayout()
		  ->createBlock('admin_helpcenter/helpcenter_grid');

		$this->_prepareDownloadResponse($fileName, $content->getCsvFile());
	}

	public function exportXmlAction()
	{
		echo "\xEF\xBB\xBF";
		$fileName = 'helpcenter_topic.xml';
		$content = $this->getLayout()
		  ->createBlock('admin_helpcenter/helpcenter_grid');
		$this->_prepareDownloadResponse($fileName, $content->getXml());
	}

	public function articlesTabAction()
	{
		$saved_article_ids = [];
		$topic_id = $this->getRequest()->getParam('id');
		if ($topic_id)
		{
			$saved_article_ids = Mage::getResourceModel('helpcenter/collection_article')
			  ->addFieldToFilter('helpcenter_topic_id', $topic_id)
			  ->getAllIds();
		}

		$this->loadLayout()
		  ->getLayout()
		  ->getBlock('helpcenter.tab.articles')
		  ->setSelectedArticles($saved_article_ids);
		$this->getLayout()
		  ->getBlock('helpcenter.serializer.articles')
		  ->setSerializeData($saved_article_ids);
		$this->renderLayout();
	}

	public function articlesGridAction()
	{
		$this->loadLayout()
		  ->getLayout()
		  ->getBlock('helpcenter.tab.articles')
		  ->setSelectedArticles($this->getRequest()->getPost('article', []));

		$this->renderLayout();
	}
}