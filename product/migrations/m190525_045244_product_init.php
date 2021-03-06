<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m190525_045244_product_init
 */
class m190525_045244_product_init extends Migration
{
    /**
     * {@inheritdoc}
     */
	public $product_categories = 'product_categories';
	public $table_product = 'product';
	public $table_product_photo = 'product_photo';
	public $table_parcel = 'parcel';
	public $product_categories_products = 'product_categories_products';
	
	

    public function safeUp()
    {
        $tableOptions = null;
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		$this->createTable($this->product_categories, [
			'id'=>Schema::TYPE_INTEGER  . ' NOT NULL AUTO_INCREMENT',
			'uri' => $this->string(64)->notNull(),
            'name' => $this->string(64)->notNull(),
        /*     'data' => $this->binary(), */
			'description'=>$this->text(),
			'order'=>$this->string(64)->notNull(), 
			'parent_id'=>Schema::TYPE_INTEGER,
			'primary_photo_id'=>$this->string(64),
			'image'=>$this->string(64),
            'KEY  ([[parent_id]])',
            'PRIMARY KEY ([[id]])',
        ], $tableOptions);
		/*  $this->addForeignKey(
            'fk-post_tag-tag_id',
            'post_tag',
            'tag_id',
            'tag',
            'id',
            'CASCADE'
        ); */
        $this->createTable($this->table_product, [
			'id'=>Schema::TYPE_INTEGER  . ' NOT NULL AUTO_INCREMENT',
			'uri' => $this->string(64)->notNull(),
            'name' => $this->string(64)->notNull(),
        /*     'data' => $this->binary(), */
			'description'=>$this->text(),
			'primary_photo_id'=>$this->string(64),
			'visible'=>$this->tinyInteger(1),
            'created_at' => Schema::TYPE_TIMESTAMP.' NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => Schema::TYPE_TIMESTAMP.' NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'PRIMARY KEY ([[id]])',
        ], $tableOptions);
		/*  $this->addForeignKey(
            'fk-post_tag-tag_id',
            'post_tag',
            'tag_id',
            'tag',
            'id',
            'CASCADE'
        ); */
		$this->createTable($this->table_product_photo, [
			'id'=>Schema::TYPE_INTEGER  . ' NOT NULL AUTO_INCREMENT',
			'product_id'=>Schema::TYPE_INTEGER  . ' NOT NULL',
			'path_fullsize' => $this->string(64)->notNull(),
            'path_thumbnail' => $this->string(64)->notNull(),
            'PRIMARY KEY ([[id]])',
			/* 'UNIQUE KEY [[product_id_path_fullsize]] ([[product_id]],[[path_fullsize]])', */
			/* 'FOREIGN KEY ([[product_id]]) REFERENCES [[product]] '.
			'([[id]])'.' ON DELETE CASCADE ', */
        ], $tableOptions);
		$this->addForeignKey(
            'fk-product_photo_id-product_id',
            'product_photo',
            'product_id',
            'product',
            'id',
            'CASCADE'
        );
		$this->createTable($this->table_parcel, [
			'id'=>Schema::TYPE_INTEGER  . ' NOT NULL AUTO_INCREMENT',
			'product_id'=>Schema::TYPE_INTEGER  . ' NOT NULL',
			'code' => $this->string(64)->notNull(),
            'height'=>$this->integer(),
			'width'=>$this->integer(),
			'depth'=>$this->integer(),
            'PRIMARY KEY ([[id]])',
			'FOREIGN KEY ([[product_id]]) REFERENCES [[product]] '.
			'([[id]])'.' ON DELETE CASCADE ',
        ], $tableOptions);
		$this->createTable($this->product_categories_products, [
			'id'=>Schema::TYPE_INTEGER  . ' NOT NULL AUTO_INCREMENT',
			'product_id'=>Schema::TYPE_INTEGER  . ' NOT NULL',
			'category_id'=>Schema::TYPE_INTEGER  . ' NOT NULL',
            'PRIMARY KEY ([[id]])',
			'KEY  ([[product_id]])',
			'KEY  ([[category_id]])'
			/* 'FOREIGN KEY ([[product_id]]) REFERENCES [[product]] '.
			'([[id]])'.' ON DELETE CASCADE ', */
        ], $tableOptions);
		$this->createIndex(
            'fk_product',
            $this->product_categories_products,
            'product_id'
        );
		$this->createIndex(
            'fk_category_id',
            $this->product_categories_products,
            'category_id'
        );
		
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
//        echo "m190525_045244_product_init cannot be reverted.\n";
//        return false;
//        $this->execute('DROP TRIGGER {$schema}.trigger_auth_item_child;');
		if($this->tableExists($this->table_product_photo)){
			 $this->dropTable($this->table_product_photo);
		} 
		if($this->tableExists($this->table_parcel)){
			 $this->dropTable($this->table_parcel);
		}
		if($this->tableExists($this->product_categories)){
			 $this->dropTable($this->product_categories);
		}		
		if($this->tableExists($this->table_product)){
			 $this->dropTable($this->table_product);
		}
		if($this->tableExists($this->product_categories_products)){
			 $this->dropTable($this->product_categories_products);
		}
		
		/* $this->dropTable($this->table_product);
		$this->dropTable($this->table_product_photo); */
		
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
//yii migrate/history
// yii migrate/mark m19
//yii migrate/down 1 --migrationPath=@app/product/migrations