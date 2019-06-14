<?php
class Mkd_Helpcenter_Block_Adminhtml_Grid extends Mage_Adminhtml_Block_Widget_Grid_Container {
    public function __construct()
    {
        $this->_blockGroup = 'admin_helpcenter'; // cái nằm ở dưới thẻ block của config.xml
        $this->_controller = 'helpcenter'; // xac dinh thu muc chua file grid
				$this->_headerText = 'Help Center';
				$this->_addButtonLabel = 'Add a Topic';

        parent::__construct();

    }

}

