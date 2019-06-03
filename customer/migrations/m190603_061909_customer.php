<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Class m190603_061909_customer
 */
class m190603_061909_customer extends Migration
{
	public $customer = 'customer';
	public $reservation = 'reservation';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		
		$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		$this->createTable($this->reservation, [
			'id'=>Schema::TYPE_INTEGER  . ' NOT NULL AUTO_INCREMENT',
			'room_id'=>Schema::TYPE_INTEGER  . ' NOT NULL',
			'customer_id'=>Schema::TYPE_INTEGER  . ' NOT NULL',
			'price_per_day' => Schema::TYPE_DECIMAL.'(20,2) NOT NULL',
            'date_from' => $this->date()->notNull(),
            'date_to' => $this->date()->notNull(),
            'reservation_date' =>  Schema::TYPE_TIMESTAMP.' NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'PRIMARY KEY ([[id]])',
			/* 'UNIQUE KEY [[product_id_path_fullsize]] ([[product_id]],[[path_fullsize]])', */
			/* 'FOREIGN KEY ([[product_id]]) REFERENCES [[product]] '.
			'([[id]])'.' ON DELETE CASCADE ', */
        ], $tableOptions);
		$this->createTable($this->customer, [
			'id'=>Schema::TYPE_INTEGER  . ' NOT NULL AUTO_INCREMENT',
			'name'=>$this->string(64)->notNull(),
			'surname'=>$this->string(64)->notNull(),
			'phone_number'=>$this->string(64),
            'PRIMARY KEY ([[id]])',
			/* 'UNIQUE KEY [[product_id_path_fullsize]] ([[product_id]],[[path_fullsize]])', */
			/* 'FOREIGN KEY ([[product_id]]) REFERENCES [[product]] '.
			'([[id]])'.' ON DELETE CASCADE ', */
        ], $tableOptions);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
		if($this->tableExists($this->reservation)){
			 $this->dropTable($this->reservation);
		} 
		if($this->tableExists($this->customer)){
			 $this->dropTable($this->customer);
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

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190603_061909_customer cannot be reverted.\n";

        return false;
    }
    */
}
