<?php

namespace common\models\query;
use common\models\Project;
use common\models\ProjectShare;

/**
 * This is the ActiveQuery class for [[\common\models\Project]].
 *
 * @see \common\models\Project
 */
class ProjectQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\Project[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\Project|array|null
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
        return $this->joinWith('projectShares')->andWhere([ProjectShare::tableName().'.user_id' => $userId]);
    }

    /**
     * @return $this
     */
    public function notDeleted()
    {
        return $this->andWhere([Project::tableName().'.deleted_at' => null]);
    }

    /**
     * @author Saiat Kalbiev <kalbievich11@gmail.com>
     * @param $id
     * @return $this
     */
    public function byId($id){
        return $this->andWhere([Project::tableName().'.id' => $id]);
    }

    /**
     * @param $token
     * @return $this
     */
    public function byToken($token)
    {
        return $this->andWhere([Project::tableName().'.token' => $token]);
    }
}
