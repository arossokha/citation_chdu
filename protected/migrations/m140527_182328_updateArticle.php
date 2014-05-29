<?php

class m140527_182328_updateArticle extends CDbMigration
{
	public function up()
	{
		$this->addColumn('Article', 'year', 'int(11)');
	}

	public function down()
	{
		$this->dropColumn('Article','year');
	}

}