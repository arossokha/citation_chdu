<?php

class m120902_170534_adminUsers extends CDbMigration
{
	public function up()
	{
		$this->createTable('AdminUser', array(
											 'adminUserId' => 'pk',
											 'name' => 'varchar(20)',
											 'lastName' => 'varchar(20)',
											 'phone' => 'varchar(20)',
											 'email' => 'varchar(50)',
											 'login' => 'varchar(50)',
											 'password' => 'varchar(40)',
											 'salt' => 'varchar(100)',
											 'role' => 'int(2)',
											 'active' => 'int(1) DEFAULT 1',
											 'updated_timestamp' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
											 'created_timestamp' => 'timestamp',
										), 'ENGINE=InnoDB CHARSET=utf8');
		$this->execute("INSERT INTO `lib_chdu`.`AdminUser` (`adminUserId`, `name`, `lastName`, `phone`, `email`, `login`, `password`, `salt`, `role`, `active`, `updated_timestamp`, `created_timestamp`) VALUES (NULL, 'Admin', NULL, NULL, 'admin@mailinator.com', 'admin', MD5('admin'), NULL, '1', '1', CURRENT_TIMESTAMP, '0000-00-00 00:00:00');");
	}

	public function down()
	{
		$this->dropTable('AdminUser');
	}

}