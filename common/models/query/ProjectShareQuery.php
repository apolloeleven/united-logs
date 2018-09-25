<?php

namespace common\models\query;

use common\models\ProjectShare;

/**
 * This is the ActiveQuery class for [[\common\models\ProjectShare]].
 *
 * @see \common\models\ProjectShare
 */
class ProjectShareQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\ProjectShare[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\ProjectShare|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @param $userId
     * @return $this
     */
    public function byUserId($userId)
    {
        return $this->andWhere([ProjectShare::tableName() . '.user_id' => $userId]);
    }

    /**
     * @param $projectId
     * @return $this
     */
    public function byProjectId($projectId)
    {
        return $this->andWhere([ProjectShare::tableName() . '.project_id' => $projectId]);
    }
}
