<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\components;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\rbac\models\AuthItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Auth Items';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Auth Item', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
        	[
        		'attribute' => 'type',
        		'content' => 'app\components\columncontent::authitemtype',
    		],
            'description:ntext',
            //'rule_name',
            //'data:ntext',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
