<?php
class Mkd_Helpcenter_Model_Resource_ArticleView extends Mage_Core_Model_Resource_Db_Abstract{
		protected function _construct()
		{
				$this->_init('helpcenter/articleview', 'helpcenter_article_view_id');
		}
}