<?php

namespace app\modules\rbac\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\rbac\models\Users;

/**
 * UsersSearch represents the model behind the search form about `app\modules\rbac\models\Users`.
 */
class UsersSearch extends Users
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'username', 'fullname', 'password', 'access_token', 'auth_key', 'active', 'userlog', 'datetimelog'], 'safe'],
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
    public function search($params)
    {
        $query = Users::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'fullname', $this->fullname])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'access_token', $this->access_token])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'active', $this->active])
            ->andFilterWhere(['like', 'userlog', $this->userlog])
            ->andFilterWhere(['like', 'datetimelog', $this->datetimelog]);

        return $dataProvider;
    }
}
