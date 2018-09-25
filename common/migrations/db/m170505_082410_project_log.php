<?php

use yii\db\Migration;

class m170505_082410_project_log extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%project_log}}', [
            'id' => $this->primaryKey(),
            'project_id' => $this->integer()->notNull(),
            'level' => $this->smallInteger()->notNull(),
            'ip' => $this->string(255)->notNull(),
            'category' => $this->string(255)->notNull(),
            'environment' => $this->string(255)->notNull(),
            'message' => $this->text()->notNull(),
            'params' => $this->text(),
            'created_at' => $this->integer()
        ]);

        $this->addForeignKey(
            'fk-project-logs-project_id',
            '{{%project_log}}',
            'project_id',
            '{{%project}}',
            'id',
            'CASCADE'
        );

    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-project-logs-project_id','{{%project_log}}');
        $this->dropTable('{{%project_log}}');
    }
}
