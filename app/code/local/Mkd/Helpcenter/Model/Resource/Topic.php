<?php
class Mkd_Helpcenter_Model_Resource_Topic extends Mage_Core_Model_Resource_Db_Abstract{
		protected function _construct()
		{
				$this->_init('helpcenter/topic', 'helpcenter_topic_id');
		}
}