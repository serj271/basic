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
			'id' => Schema::TYPE_PK,
			// $this->primaryKey()
			'email' => Schema::TYPE_STRING,
			// $this->string(255) // String with 255 characters
			'password' => Schema::TYPE_STRING,
			'name' => Schema::TYPE_STRING,
			'created_at' => Schema::TYPE_INTEGER,
			// $this->integer()
			'updated_at' => Schema::TYPE_INTEGER
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

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190516_062411_user_table cannot be reverted.\n";

        return false;
    }
    */
}
