<?php

use yii\db\Migration;

/**
 * Class m191015_110648_car
 */
class m191015_110648_car extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$this->createTable('car', [
            'id' => $this->primaryKey(),
			'name' => $this->string()->notNull(),
			'model' => $this->string()->notNull(),
        ]); 

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $tableName = $this->db->tablePrefix . 'car';
		if ($this->db->getTableSchema($tableName, true) != null){
			$this->dropTable('car');
		}
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191015_110648_car cannot be reverted.\n";

        return false;
    }
    */
}
