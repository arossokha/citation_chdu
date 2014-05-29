<?php

class m140529_195929_articleAuthor extends CDbMigration
{
	public function up()
	{
		$this->createTable('ArticleAuthor',array(
				'articleAuthorId' => 'pk',
				'articleId' => 'int(11)',
				'authorId' => 'int(11)',
			));
	}

	public function down()
	{
		$this->dropTable('ArticleAuthor');
	}


}