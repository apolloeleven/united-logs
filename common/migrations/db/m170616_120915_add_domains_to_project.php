<?php

use yii\db\Migration;

class m170616_120915_add_domains_to_project extends Migration
{
    public function safeUp()
    {
        $this->addColumn(\common\models\Project::tableName(), 'trusted_domains', $this->string(2000));
    }

    public function safeDown()
    {
        $this->dropColumn(\common\models\Project::tableName(), 'trusted_domains');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170616_120915_add_domains_to_project cannot be reverted.\n";

        return false;
    }
    */
}
