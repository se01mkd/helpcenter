<?php

$installer = $this;
$installer->startSetup();
/* @var $installer Mage_Core_Model_Resource_Setup */
if ($installer->getConnection()->isTableExists($installer->getTable('helpcenter/topic')))
{
		$installer->getConnection()->dropTable( $installer->getTable('helpcenter/topic'));
		$installer->getConnection()->dropTable( $installer->getTable('helpcenter/topicconfig'));
		$installer->getConnection()->dropTable( $installer->getTable('helpcenter/article'));
		$installer->getConnection()->dropTable( $installer->getTable('helpcenter/articleconfig'));
		$installer->getConnection()->dropTable( $installer->getTable('helpcenter/articleview'));
		$installer->getConnection()->dropTable( $installer->getTable('helpcenter/articlevote'));
}

$table = $installer->getConnection()->newTable($installer->getTable('helpcenter/topic'))
	->addColumn('helpcenter_topic_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 10, array(
		'unsigned' => true,
		'nullable' => false,
		'primary' => true,
		'identity' => true,
	))
	->addColumn('title', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
		'nullable' => false,
	))
	->addColumn('description', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
		'nullable' => true,
	))
	->addColumn('meta_keywords', Varien_Db_Ddl_Table::TYPE_VARCHAR, 300, array())
	->addColumn('meta_description', Varien_Db_Ddl_Table::TYPE_VARCHAR, 300, array())

	->addColumn('is_active', Varien_Db_Ddl_Table::TYPE_SMALLINT, 1, array(
		'nulable'=>false,
		'default'=>0,
	))
	->addColumn('sort_order', Varien_Db_Ddl_Table::TYPE_INTEGER, 10, array(
		'default'=>0
	))
	->addColumn('creation_time', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
		'nullable'=>false
	))
	->addColumn('updated_time', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
		'nullable'=>false
	));
$installer->getConnection()->createTable($table);


$table = $installer->getConnection()
	->newTable($installer->getTable('helpcenter/topicconfig'))
	->addColumn('helpcenter_topic_config_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 10, array(
		'unsigned' => true,
		'nullable' => false,
		'primary' => true,
		'identity' => true,
	))
	->addColumn('helpcenter_topic_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 10, array(
		'nullable' => false,
		'unsigned' => true,
	))
	->addColumn('website_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, 5, array(
		'nullable' => false,
		'unsigned' => true,
	))
	->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, 5, array(
		'nullable' => false,
		'unsigned' => true,
	))
	->addColumn('field', Varien_Db_Ddl_Table::TYPE_VARCHAR, 55, array(
		'nullable'=>false
	))
	->addColumn('value', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
		'default'=>NULL
	))
	->addForeignKey('topic_config',
		'helpcenter_topic_id','helpcenter_topic', 'helpcenter_topic_id',
		Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_NO_ACTION)
	->setComment('Topic Config')

	->addForeignKey('topic_website',
		'website_id','core_website', 'website_id',
		Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_NO_ACTION)
	->setComment('Topic website')

	->addForeignKey('topic_store',
		'store_id','core_store', 'store_id',
		Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_NO_ACTION)
	->setComment('Topic store')
;

$installer->getConnection()->createTable($table);


$table = $installer->getConnection()->newTable($installer->getTable('helpcenter/article'))
	->addColumn('helpcenter_article_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 10, array(
		'unsigned' => true,
		'nullable' => false,
		'primary' => true,
		'identity' => true,
	))

	->addColumn('helpcenter_topic_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 10, array(
		'nullable' => false,
		'unsigned' => true,
	))
	->addColumn('title', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
		'nullable' => false,
	))
	->addColumn('description', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
		'nullable' => true,
	))

	->addColumn('content', Varien_Db_Ddl_Table::TYPE_TEXT, null, array())
	->addColumn('meta_keywords', Varien_Db_Ddl_Table::TYPE_VARCHAR, 300, array())
	->addColumn('meta_description', Varien_Db_Ddl_Table::TYPE_VARCHAR, 300, array())

	->addColumn('is_active', Varien_Db_Ddl_Table::TYPE_SMALLINT, 1, array(
		'nulable'=>false,
		'default'=>0,
	))
	->addColumn('sort_order', Varien_Db_Ddl_Table::TYPE_INTEGER, 10, array(
		'default'=>0
	))
	->addColumn('creation_time', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
		'nullable'=>false
	))
	->addColumn('updated_time', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
		'nullable'=>false
	))

	->addForeignKey('article_topic',
		'helpcenter_topic_id','helpcenter_topic', 'helpcenter_topic_id',
		Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_NO_ACTION)
	->setComment('Topic - Article')
;
$installer->getConnection()->createTable($table);


$table = $installer->getConnection()
	->newTable($installer->getTable('helpcenter/articleconfig'))
	->addColumn('helpcenter_article_config_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 10, array(
		'unsigned' => true,
		'nullable' => false,
		'primary' => true,
		'identity' => true,
	))
	->addColumn('helpcenter_article_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 10, array(
		'nullable' => false,
		'unsigned' => true,
	))
	->addColumn('website_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, 5, array(
		'nullable' => false,
		'unsigned' => true,
	))
	->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, 5, array(
		'nullable' => false,
		'unsigned' => true,
	))
	->addColumn('field', Varien_Db_Ddl_Table::TYPE_VARCHAR, 55, array(
		'nullable'=>false
	))
	->addColumn('value', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
		'default'=>NULL
	))
	->addForeignKey('article_config',
		'helpcenter_article_id','helpcenter_article', 'helpcenter_article_id',
		Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_NO_ACTION)
	->setComment('Article Config')

	->addForeignKey('article_website',
		'website_id','core_website', 'website_id',
		Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_NO_ACTION)
	->setComment('Article website')

	->addForeignKey('article_store',
		'store_id','core_store', 'store_id',
		Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_NO_ACTION)
	->setComment('Article store')
;

$installer->getConnection()->createTable($table);



$table = $installer->getConnection()
	->newTable($installer->getTable('helpcenter/articleview'))
	->addColumn('helpcenter_article_view_id', Varien_Db_Ddl_Table::TYPE_BIGINT, 20, array(
		'unsigned' => true,
		'nullable' => false,
		'primary' => true,
		'identity' => true,
	))
	->addColumn('helpcenter_article_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 10, array(
		'nullable' => false,
		'unsigned' => true,
	))
	->addColumn('customer_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 10, array(
		'unsigned' => true,
	))
	->addColumn('visitor_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, 5, array())
	->addColumn('creation_time', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
		'nullable'=>false
	))

	->addForeignKey('article_view',
		'helpcenter_article_id','helpcenter_article', 'helpcenter_article_id',
		Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_NO_ACTION)
	->setComment('Article view')

	->addForeignKey('article_view_customer',
		'customer_id','customer_entity', 'entity_id',
		Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_NO_ACTION)
	->setComment('Article viewer')
;
$installer->getConnection()->createTable($table);

$table = $installer->getConnection()
	->newTable($installer->getTable('helpcenter/articlevote'))
	->addColumn('helpcenter_article_vote_id', Varien_Db_Ddl_Table::TYPE_BIGINT, 20, array(
		'unsigned' => true,
		'nullable' => false,
		'primary' => true,
		'identity' => true,
	))
	->addColumn('helpcenter_article_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 10, array(
		'nullable' => false,
		'unsigned' => true,
	))
	->addColumn('customer_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 10, array(
		'unsigned' => true,
	))
	->addColumn('vote', Varien_Db_Ddl_Table::TYPE_SMALLINT, 10, array(
		'nulable'=>'false'
	))


	->addForeignKey('article_vote',
		'helpcenter_article_id','helpcenter_article', 'helpcenter_article_id',
		Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_NO_ACTION)
	->setComment('Article view')

	->addForeignKey('article_vote_customer',
		'customer_id','customer_entity', 'entity_id',
		Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_NO_ACTION)
	->setComment('Article viewer')
;
$installer->getConnection()->createTable($table);

$installer->endSetup();