<?php
class Mkd_Helpcenter_Model_Resource_ArticleConfig extends Mage_Core_Model_Resource_Db_Abstract{
		protected function _construct()
		{
				$this->_init('helpcenter/articleconfig', 'helpcenter_article_config_id');
		}
}