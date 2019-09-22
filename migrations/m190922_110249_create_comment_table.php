<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `{{%comment}}`.
 */
class m190922_110249_create_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
	public $comment = 'comment';
	public $page = 'page';
	
    public function safeUp()
    {        
		$tableOptions = null;
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		$this->createTable($this->page, [
			'id'=>Schema::TYPE_INTEGER  . ' NOT NULL AUTO_INCREMENT',
			'user_id'=>Schema::TYPE_INTEGER  . ' NOT NULL',
			'live' => Schema::TYPE_TINYINT  . ' NOT NULL',
            'title' => $this->string(100)->notNull(),
            'content' => Schema::TYPE_TEXT  . ' NULL',
            'name' => $this->string(64)->notNull(),
            'date_updated' => Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT CURRENT_TIMESTAMP',
			'date_published' => Schema::TYPE_DATETIME,
            'KEY  ([[user_id]])',
            'PRIMARY KEY ([[id]])',
        ], $tableOptions);
		$this->addForeignKey(
            'fk_page_user',
			'page',//table
			'user_id',//column
			'user',//table ref
            'id',//column ref
            'CASCADE',
            'NO ACTION '
        );
		$this->createIndex(
			'unit_transport_fk2',
			'page',
			'user_id'
	    );
		$this->createIndex(
			'date_published',
			'page',
			'date_published'
	    );
		$this->createTable($this->comment, [
			'id'=>Schema::TYPE_INTEGER  . ' NOT NULL AUTO_INCREMENT',
			'user_id'=>Schema::TYPE_INTEGER  . ' NOT NULL',
			'page_id'=>Schema::TYPE_INTEGER  . ' NOT NULL',
            'comment' => Schema::TYPE_TEXT  . ' NULL',
            'name' => $this->string(64)->notNull(),
            'date_entered' => Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'KEY  ([[user_id]])',
            'PRIMARY KEY ([[id]])',
        ], $tableOptions);
		$this->addForeignKey(
            'fk_comment_user_idx',
			'comment',//table
			'user_id',//column
			'user',//table ref
            'id',//column ref
            'CASCADE',
            'NO ACTION '
        );
		$this->addForeignKey(
            'fk_comment_page',
			'comment',//table
			'page_id',//column
			'page',//table ref
            'id',//column ref
            'CASCADE',
            'NO ACTION '
        );
		$this->createIndex(
			'fk_comment_user_idx',
			'comment',
			'user_id'
	    );
		$this->createIndex(
			'fk_comment_page_idx',
			'comment',
			'page_id'
	    );
		$this->createIndex(
			'date_entered',
			'comment',
			'date_entered'
	    );
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
		if($this->tableExists($this->comment)){
			$this->dropTable($this->comment);
		}
		if($this->tableExists($this->page)){
			/* $this->dropIndex(
				'unit_transport_fk2',
				'page'
			);
			$this->dropIndex(
				'date_published',
				'page'
			); */
			$this->dropTable($this->page);
		} 
		
	}
	
	private function tableExists($tableName, $db = null)
	{
		if ($db)
			$dbConnect = \Yii::$app->get($db);
		else
			$dbConnect = \Yii::$app->get('db');

		if (!($dbConnect instanceof \yii\db\Connection))
			throw new \yii\base\InvalidParamException;

		return in_array($tableName,$this->db->schema->getTableNames());
	}
    protected function buildFkClause($delete = '', $update = '')
    {
        return implode(' ', ['', $delete, $update]);
    }	
}
# yii migrate/redo [step]