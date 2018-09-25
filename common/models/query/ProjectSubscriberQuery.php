<?php

namespace common\models\query;
use common\models\ProjectLog;
use common\models\ProjectSubscriber;

/**
 * This is the ActiveQuery class for [[\common\models\ProjectSubscriber]].
 *
 * @see \common\models\ProjectSubscriber
 */
class ProjectSubscriberQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\ProjectSubscriber[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\ProjectSubscriber|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @author Saiat Kalbiev <kalbievich11@gmail.com>
     * @param $projectId
     * @return self
     */
    public function byProjectId($projectId)
    {
        return $this->andWhere([ProjectSubscriber::tableName() . '.project_id' => $projectId]);
    }

    /**
     * @author Saiat Kalbiev <kalbievich11@gmail.com>
     * @return self
     */
    public function notDeleted(){
        return $this->andWhere([ProjectSubscriber::tableName() . '.deleted_at' => null]);
    }

    /**
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     * @param $level
     * @return self
     */
    public function byLevel($level)
    {
        return $this->andWhere("IFNULL(".ProjectSubscriber::tableName().".level, :level) LIKE :levelLike", [
            ':level' => "{{".$level."}}",
            ':levelLike' => "%{{".$level."}}%",
        ]);
    }

    /**
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     * @param $category
     * @return self
     */
    public function byCategory($category)
    {
        return $this->andWhere("IFNULL(".ProjectSubscriber::tableName().".category, :category) LIKE :categoryLike", [
            ':category' => "{{".$category."}}",
            ':categoryLike' => "%{{".$category."}}%",
        ]);
    }

    /**
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     * @param $environment
     * @return self
     */
    public function byEnvironment($environment)
    {
        return $this->andWhere("IFNULL(".ProjectSubscriber::tableName().".environment, :environment) LIKE :environmentLike", [
            ':environment' => "{{".$environment."}}",
            ':environmentLike' => "%{{".$environment."}}%",
        ]);
    }
}
