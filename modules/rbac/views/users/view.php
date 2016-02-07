<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\base\Widget;

/* @var $this yii\web\View */
/* @var $model app\modules\rbac\models\Users */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
	<?php 
		echo \app\components\mytools::getFullnameByUser($model->id);
	?>
    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'fullname',
            'access_token',
            'auth_key',
            'active',
            [
            	'attribute' => 'userlog',
            	'value' => \app\components\mytools::getFullnameByUser($model->id),
    		],
            'datetimelog',
        ],
    ]) ?>
    
    <h2>Roles / Peran</h2>
    <p>
    <?= Html::a('Add Role', ['addrole', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>    
    <?php
    	//$roles = Yii::$app->authManager->getRolesByUser($model->id);
    	$roles = (new yii\db\Query())->select('')->from('auth_assignment a')
    		->join('INNER JOIN', 'auth_item b', 'b.name = a.item_name')
    		->where(['a.user_id'=>$model->id])->All(Yii::$app->authdb);
    	$rolesProvider = new \yii\data\ArrayDataProvider(
    			[ 'allModels' => $roles,
    			]);
    	echo GridView::widget([
    		'dataProvider'=> $rolesProvider,
    		'columns' => [
    			'name',
    			'description',
    			[
    				'class' => yii\grid\ActionColumn::className(),
    				'template' => '{delete}',
    				'urlCreator' => function ($action, $model, $key, $index) {
    					return Yii::$app->urlManager->createUrl(['rbac/authassignment/delete2', 
    						'item_name'=>$model['name'],
    						'user_id'=>$model['user_id']
    					]);}
    			],
    		]	
    	])
    ?>
	
	<h2>Permissions / Otoritas</h2>
    <?php
    	$permissions = Yii::$app->authManager->getPermissionsByUser($model->id);
    	$permissionsProvider = new \yii\data\ArrayDataProvider(
    			[ 'allModels' => $permissions,
    			]);
    	echo GridView::widget([
    		'dataProvider'=> $permissionsProvider,
    		'columns' => [
    			'name',
    			'description',
    			[
    				'attribute'=>'type',
    				'content'=>'app\components\columncontent::authitemtype',
    			],
    		]	
    	])
    ?>
</div>
