<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Class m190516_062411_user_table
 */
class m190516_062411_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$this->createTable('user', [
			'id' => Schema::TYPE_PK. ' NOT NULL AUTO_INCREMENT',
			// $this->primaryKey()
			'username' => $this->string(64)->notNull(),
			'email' => $this->string(64)->notNull(),
			'auth_key' => $this->string(64),
			'password_hash' => $this->string(64),
			'password_reset_token' => $this->string(64)->notNull(),
			'status' => Schema::TYPE_STRING,// String with 255 characters
			// $this->string(255) // String with 255 characters
			'role' => Schema::TYPE_SMALLINT,
			'created_at' => Schema::TYPE_INTEGER,
			// $this->integer()
			'updated_at' => Schema::TYPE_INTEGER,
			'PRIMARY KEY ([[id]])',
		]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
 //       echo "m190516_062411_user_table cannot be reverted.\n";
 //       return false;
		$tableName = $this->db->tablePrefix . 'user';
		if ($this->db->getTableSchema($tableName, true) != null){
			$this->dropTable('users');
		}
    }
}
