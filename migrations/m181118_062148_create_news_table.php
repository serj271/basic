<?php

use yii\db\Migration;

/**
 * Handles the creation of table `news`.
 */
class m181118_062148_create_news_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('news', [
            'id' => $this->primaryKey(),
			'title' => $this->string()->notNull(),
			'content' => $this->text(),
        ]);
		$this->insert('news', [
			'title' => 'test 1',
			'content' => 'content 1',
		]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $tableName = $this->db->tablePrefix . 'news';
		if ($this->db->getTableSchema($tableName, true) != null){
			$this->dropTable('news');
		}
    }
}
