<?php

class m140527_185841_faq extends CDbMigration
{
	public function up()
	{

		$this->createTable('Faq', array(
										'faqId' => 'pk',
										'question' => 'varchar(500)',
										'answer' => 'text',
										'updated_timestamp' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
										'created_timestamp' => 'timestamp',
								   ), 'ENGINE=InnoDB CHARSET=utf8');
	}

	public function down()
	{
		$this->dropTable('Faq');
	}
}