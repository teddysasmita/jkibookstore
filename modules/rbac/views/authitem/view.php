<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\grid\ActionColumn;


/* @var $this yii\web\View */
/* @var $model app\modules\rbac\models\AuthItem */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Auth Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->name], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->name], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
        	 [ 
        		'attribute'=>'type',
        		'value' => \app\components\lookup::getAuthItemType($model->type),		
    		 ],
            'description:ntext',
            //'rule_name',
            //'data:ntext',
            'created_at',
            'updated_at',
        ],
    ]) ?>
    
    <h2><?= Html::encode('Children / Anak2') ?></h2>
    <p>
    <?= Html::a('Add Child / Tambah Anak', ['addchild', 'idparent' => $model->name], ['class' => 'btn btn-primary']) ?>
    </p>
    <?php 
    	$auth = Yii::$app->authManager;
    	$children_data = (new yii\db\Query())->select('a.parent, a.child, b.description')
    		->from('auth_item_child a')
    		->join('INNER JOIN','auth_item b', 'b.name = a.child')
    		->where(['parent'=>$model->name])->all(Yii::$app->authdb);
    	//$children_data = $auth->getChildren($model->name);
    	$dataProvider = new yii\data\ArrayDataProvider(
    			[
    				'allModels' => $children_data,				
    	]);
    	
    	$parentname = $model->name;
    	
    	
    	echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
				'child',
        		'description',
        		/*[
        			'attribute'=>'Name',
        			'content'=> function($model, $key, $index, $column) {
    					//print_r($model);
        				return $model->name;
    				},
    			],
    			[
	    			'attribute'=>'Description',
	    			'content'=> function($model, $key, $index, $column) {
	    				//print_r($model);
	    				return $model->description;
	    			},
    			],*/
    			[
    				'class' => ActionColumn::className(),
    				'template' => "{delete}",
    				'urlCreator' => function ($action, $model, $key, $index) {
    					return Yii::$app->urlManager->createUrl(['rbac/authitemchild/delete2', 'parent'=>$model['parent'],
    						'child'=>$model['child']
    					]);
	    			},
	    		],
      		],
    	]);
    ?>

</div>
