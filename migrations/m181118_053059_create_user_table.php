<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m181118_053059_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		
        $this->createTable('users', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
		$tableName = $this->db->tablePrefix . 'users';
		if ($this->db->getTableSchema($tableName, true) === null){
			$this->dropTable('users');
		}
//        
    }
}
