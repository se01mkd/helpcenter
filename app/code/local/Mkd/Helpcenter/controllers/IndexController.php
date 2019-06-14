<?php

/**
 * Class Mkd_Helloworld_IndexController
 */
class Mkd_Helpcenter_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
				$blogpost = Mage::getModel('helpcenter/topic');
				echo("Loading the blogpost with an ID of 1");
				$blogpost->load(1);
				$data = $blogpost->getData();
				var_dump($data);
		}
}
