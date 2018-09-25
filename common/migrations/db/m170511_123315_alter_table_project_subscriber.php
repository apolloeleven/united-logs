<?php

use yii\db\Migration;

class m170511_123315_alter_table_project_subscriber extends Migration
{
    public function up()
    {
        $this->addColumn('{{%project_subscriber}}','created_at',$this->integer(11)->null());
        $this->addColumn('{{%project_subscriber}}','updated_at',$this->integer(11)->null());
        $this->addColumn('{{%project_subscriber}}','deleted_at',$this->integer(11)->null());
    }

    public function down()
    {
        $this->dropColumn('{{%project_subscriber}}','created_at');
        $this->dropColumn('{{%project_subscriber}}','updated_at');
        $this->dropColumn('{{%project_subscriber}}','deleted_at');
    }
}
