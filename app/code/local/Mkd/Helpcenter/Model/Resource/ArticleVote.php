<?php
class Mkd_Helpcenter_Model_Resource_ArticleVote extends Mage_Core_Model_Resource_Db_Abstract{
		protected function _construct()
		{
				$this->_init('helpcenter/articlevote', 'helpcenter_article_vote_id');
		}
}