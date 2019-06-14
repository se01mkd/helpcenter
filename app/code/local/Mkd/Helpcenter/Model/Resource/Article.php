<?php
class Mkd_Helpcenter_Model_Resource_Article extends Mage_Core_Model_Resource_Db_Abstract{
		protected function _construct()
		{
				$this->_init('helpcenter/article', 'helpcenter_article_id');
		}
}