<?php

use yii\db\Migration;

/**
 * Class m211109_033330_user
 */
class m211109_033330_user extends Migration
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
        echo "m211109_033330_user cannot be reverted.\n";

        return false;
    }


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'first_name' => $this->string(255)->notNull(),
            'last_name' => $this->string(255),
            'email' => $this->string(255),
            'date_of_birth' => $this->date(),
        ]);
    }

    public function down()
    {
        $this->dropTable('user');
    }

}
