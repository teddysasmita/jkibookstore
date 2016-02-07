<?php

namespace app\controllers;

use yii\web\Controller;

class LookupController extends Controller
{
    public function actionGetauthitem($term)
    {
        return json_encode((new \yii\db\Query())->select('name as value, description as label')->from('auth_item')
        	->where(['like', 'description', $term])
        	->orWhere(['like', 'name', $term])->All());
    }
    
    public function actionGetauthpermission($term)
    {
    	return json_encode((new \yii\db\Query())->select('name as value, description as label')->from('auth_item')
    			->where(['and',['like', 'description', $term],['=','type','2']])
    			->orWhere(['and', ['like', 'name', $term], ['=','type','2'] ])->All());
    }
    
    public function actionGetauthrole($term)
    {
    	return json_encode((new \yii\db\Query())->select('name as value, description as label')->from('auth_item')
    			->where(['and',['like', 'description', $term],['=','type','1']])
    			->orWhere(['and', ['like', 'name', $term], ['=','type','1'] ])->All());
    }
}
