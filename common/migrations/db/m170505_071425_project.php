<?php

use yii\db\Migration;

class m170505_071425_project extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%project}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'token' => $this->string(128)->notNull(),
            'description' => $this->text(),
            'image' => $this->string(255)->null(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'deleted_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'deleted_by' => $this->integer()
        ]);

        $this->addForeignKey(
            'fk-project-creator_id',
            '{{%project}}',
            'created_by',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-project-updater_id',
            '{{%project}}',
            'updated_by',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-project-deleter_id',
            '{{%project}}',
            'deleted_by',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-project-deleter_id','{{%project}}');
        $this->dropForeignKey('fk-project-updater_id','{{%project}}');
        $this->dropForeignKey('fk-project-creator_id','{{%project}}');
        $this->dropTable('{{%project}}');
    }
}
