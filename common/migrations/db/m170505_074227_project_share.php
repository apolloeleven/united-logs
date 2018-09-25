<?php

use yii\db\Migration;

class m170505_074227_project_share extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%project_share}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'project_id' => $this->integer()->notNull(),
            'role' => $this->smallInteger()->notNull()
        ]);

        $this->addForeignKey(
            'fk-project-share-user_id',
            '{{%project_share}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-project-share-project_id',
            '{{%project_share}}',
            'project_id',
            '{{%project}}',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-project-share-project_id','{{%project_share}}');
        $this->dropForeignKey('fk-project-share-user_id','{{%project_share}}');
        $this->dropTable('{{%project_share}}');
    }
}
