<?php

use yii\db\Migration;

/**
 * Class m211109_033347_user_phone
 */
class m211109_033347_user_phone extends Migration
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
        echo "m211109_033347_user_phone cannot be reverted.\n";

        return false;
    }

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('user_phone', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'phone' => $this->string(255)->notNull(),
        ]);

        $this->addForeignKey(
            'fk-user_phone-user_id',
            'user_phone',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropForeignKey(
            'fk-user_phone-user_id',
            'user_phone'
        );

        $this->dropTable('user_phone');
    }

}
