<?php

class m140526_170828_Init extends CDbMigration
{
	public function up()
	{
		$this->createTable('Author',array(
				'authorId' => 'pk',
				'fullName' => 'varchar(200)',
				'photo' => 'varchar(500)',
			));


		$this->createTable('Category',array(
				'categoryId' => 'pk',
				'name' => 'varchar(100)',
			));

		$this->createTable('Article',array(
				'articleId' => 'pk',
				'name' => 'varchar(200)',
				'categoryId' => 'int(11)',
				'index' => 'float(10,4)',
				'file' => 'varchar(500)',
			));

		$this->createTable('AuthorCategory',array(
				'authorCategoryId' => 'pk',
				'authorId' => 'int(11)',
				'categoryId' => 'int(11)',
			));

		$this->createTable('AuthorArticle',array(
				'authorArticleId' => 'pk',
				'authorId' => 'int(11)',
				'articleId' => 'int(11)',
			));

		$this->createTable('AuthorCitator',array(
				// 'authorCitatorId' => 'pk',
				'authorId' => 'int(11)',
				'citatorId' => 'int(11)',
			));

	}

	public function down()
	{
		$this->dropTable('AuthorCitator');
		$this->dropTable('AuthorArticle');
		$this->dropTable('AuthorCategory');
		$this->dropTable('Category');
		$this->dropTable('Author');
		$this->dropTable('Article');
	}
}