<?php

use yii\db\Migration;

class m170505_070638_group extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%group}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'user_id' => $this->integer()->notNull()
        ]);

        $this->addForeignKey(
            'fk-group-user_id',
            '{{%group}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-group-user_id','{{%group}}');
        $this->dropTable('{{%group}}');
    }
}
