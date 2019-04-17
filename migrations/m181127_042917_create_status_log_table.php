<?php

use yii\db\Migration;
use yii\db\Schema;
/**
 * Handles the creation of table `status_log`.
 */
class m181127_042917_create_status_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /* $this->createTable('status_log', [
            'id' => $this->primaryKey(),
        ]); */
		$tableOptions = null;
        if ($this->db->driverName === 'mysql') {
		  $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}
		$this->createTable('{{%status_log}}', [
			'id' => Schema::TYPE_PK,
			'status_id' => Schema::TYPE_INTEGER.' NOT NULL',
			'updated_by' => Schema::TYPE_INTEGER.' NOT NULL',
			'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
		], $tableOptions);          
		/* $this->addForeignKey('fk_status_log_id', '{{%status_log}}', 'status_id', '{{%status}}', 'id', 'CASCADE', 'CASCADE');     
		$this->addForeignKey('fk_status_log_updated_by', '{{%status_log}}', 'updated_by', '{{%user}}', 'id', 'CASCADE', 'CASCADE');   */
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('status_log');
		/* $this->dropForeignKey('fk_status_updated_by','{{%status_log}}');
		$this->dropForeignKey('fk_status_id','{{%status_log}}');
		$this->dropColumn('{{%status_log}}','updated_by'); */
    }
}

//./yii migrate/create create_status_log_table
