<?php

use yii\db\Migration;

/**
 * Class m191015_050817_create_database_tests
 */
class m191015_050817_create_database_tests extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191015_050817_create_database_tests cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191015_050817_create_database_tests cannot be reverted.\n";

        return false;
    }
    */
}
