<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Class m190516_063648_name_change
 */
class m190516_063648_name_change extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$this->renameColumn('user', 'name', 'first_name');
		$this->alterColumn('user', 'first_name', SCHEMA::TYPE_STRING);
		$this->addColumn('user', 'last_name', SCHEMA::TYPE_STRING);
		$this->alterColumn('user', 'email', SCHEMA::TYPE_STRING . '
		NOT NULL');
		$this->createIndex('user_unique_email', 'user', 'email',
		true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
 //       echo "m190516_063648_name_change cannot be reverted.\n";
 //       return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190516_063648_name_change cannot be reverted.\n";

        return false;
    }
    */
}
