<?php

use yii\db\Migration;

class m170505_073715_project_group extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%project_group}}', [
            'id' => $this->primaryKey(),
            'group_id' => $this->integer()->notNull(),
            'project_id' => $this->integer()->notNull()
        ]);

        $this->addForeignKey(
            'fk-project-group-group_id',
            '{{%project_group}}',
            'group_id',
            '{{%group}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-project-group-project_id',
            '{{%project_group}}',
            'project_id',
            '{{%project}}',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-project-group-project_id','{{%project_group}}');
        $this->dropForeignKey('fk-project-group-group_id','{{%project_group}}');
        $this->dropTable('{{%project_group}}');
    }
}
