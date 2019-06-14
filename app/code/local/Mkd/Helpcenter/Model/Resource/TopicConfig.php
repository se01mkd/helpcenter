<?php
class Mkd_Helpcenter_Model_Resource_TopicConfig extends Mage_Core_Model_Resource_Db_Abstract{
		protected function _construct()
		{
				$this->_init('helpcenter/topicconfig', 'helpcenter_topic_config_id');
		}
}