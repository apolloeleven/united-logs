<?php

use yii\db\Migration;

class m170508_150158_project_subscriber extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%project_subscriber}}', [
            'id' => $this->primaryKey(),
            'project_id' => $this->integer()->notNull(),
            'email' => $this->text()->notNull(),
            'level' => $this->string(255)->null(),
            'category' => $this->text()->null(),
            'environment' => $this->text()->null()
        ]);

        $this->addForeignKey(
            'fk-project-subscriber-project_id',
            '{{%project_subscriber}}',
            'project_id',
            '{{%project}}',
            'id',
            'CASCADE'
        );

    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-project-subscriber-project_id','{{%project_subscriber}}');
        $this->dropTable('{{%project_subscriber}}');
    }
}
