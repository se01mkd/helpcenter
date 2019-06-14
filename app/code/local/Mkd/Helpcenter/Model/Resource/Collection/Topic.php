<?php


class Mkd_Helpcenter_Model_Resource_Collection_Topic extends Mage_Core_Model_Resource_Db_Collection_Abstract  {
    protected function _construct()
    {
        $this->_init('helpcenter/topic');
    }
}