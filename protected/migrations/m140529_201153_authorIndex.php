<?php

class m140529_201153_authorIndex extends CDbMigration
{
	public function up()
	{
		$this->addColumn('Author','index','float(10,4) DEFAULT 0');
	}

	public function down()
	{
		$this->dropColumn('Author','index');
	}
}