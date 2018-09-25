<?php

namespace common\models\query;

use common\models\ProjectLog;

/**
 * This is the ActiveQuery class for [[\common\models\ProjectLog]].
 *
 * @see \common\models\ProjectLog
 */
class ProjectLogQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\ProjectLog[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\ProjectLog|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function byProjectId($projectId)
    {
        return $this->andWhere([ProjectLog::tableName() . '.project_id' => $projectId]);
    }
}
