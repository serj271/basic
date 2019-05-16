<?php
use yii\db\Schema;
use yii\db\Migration;

/**
 * Class m190516_065216_product_table
 */
class m190516_065216_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		
		$this->createTable('products', [
			'id' => Schema::TYPE_PK,
			'name' =>Schema::TYPE_STRING,
			'uri'  => Schema::TYPE_STRING." NOT NULL DEFAULT '#'",
			'description'  => Schema::TYPE_STRING,
			'primary_photo_id'  => Schema::TYPE_INTEGER,
			'avg_review_rating'  => Schema::TYPE_INTEGER,
			'visible' =>  Schema::TYPE_TINYINT.' NOT NULL DEFAULT 1',  
		]);
		$this->createIndex('user_unique_uri', 'products', 'uri',
		true); 
		
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
		if ($this->db->getTableSchema('products', true) != null){
			$this->dropTable('products');
		}
  //      echo "m190516_065216_product_table cannot be reverted.\n";
  //      return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190516_065216_product_table cannot be reverted.\n";

        return false;
    }
    */
}
