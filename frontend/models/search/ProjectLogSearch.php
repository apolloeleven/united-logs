<?php

namespace frontend\models\search;

use centigen\base\helpers\QueryHelper;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ProjectLog;
use yii\helpers\ArrayHelper;

/**
 * ProjectLogSearch represents the model behind the search form about `common\models\ProjectLog`.
 */
class ProjectLogSearch extends ProjectLog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'project_id', 'level', 'created_at'], 'integer'],
            [['category', 'environment', 'message',], 'string'],
            [['ip', 'params'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $projectId)
    {
        if(ArrayHelper::getValue($params, 'ProjectLogSearch.created_at')){
            $created_at = explode(' - ',$params['ProjectLogSearch']['created_at'],2);
            $start_date = strtotime($created_at[0]);
            $end_date = strtotime($created_at[1]);
            $query = ProjectLog::find()->byProjectId($projectId)->
            andWhere('(created_at - (created_at % 86400) >= :startDate) AND (created_at - (created_at % 86400) <=:endDate)')
                ->addParams([
                    ':startDate' => $start_date,
                    ':endDate' => $end_date
                ])->orderBy(['created_at' => SORT_DESC, 'id' => SORT_DESC]);
        }else{
            $query = ProjectLog::find()->byProjectId($projectId)->orderBy(['created_at' => SORT_DESC, 'id' => SORT_DESC]);;
        }







        $this->load($params);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'category' => $this->category,
            'project_id' => $this->project_id,
            'level' => $this->level
        ]);

        $query->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'environment', $this->environment])
            ->andFilterWhere(['like', 'message', $this->message])
            ->andFilterWhere(['like', 'params', $this->params]);

        return $dataProvider;
    }
}
