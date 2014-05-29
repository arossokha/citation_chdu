<?php

class m140529_210307_articleArticle extends CDbMigration
{
	public function up()
	{
		$this->createTable('ArticleArticle',array(
				'articleArticleId' => 'pk',
				'articleId' => 'int(11)',
				'citarticleId' => 'int(11)',
			));
	}

	public function down()
	{
		$this->dropTable('ArticleArticle');
	}

}