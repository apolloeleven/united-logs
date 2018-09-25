<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\Group]].
 *
 * @see \common\models\Group
 */
class GroupQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\Group[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\Group|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
