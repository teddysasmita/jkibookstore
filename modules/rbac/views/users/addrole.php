<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;

/* @var $this yii\web\View */
/* @var $model app\modules\rbac\models\AuthAssignment */

$this->title = 'Add Permission';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $id, 'url' => ['view', 'id' => $id]];
$this->params['breadcrumbs'][] = ['label' => 'Add Permission'];
?>
<div class="auth-assignment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>
	
	<?php 
		echo Html::activeHiddenInput($model, 'user_id');
		echo Html::activeHiddenInput($model, 'created_at');
	?>
    <?= 
    	//$form->field($model, 'item_name')->textInput(['maxlength' => true]) 
    	$form->field($model, 'item_name')->widget(AutoComplete::className(), 
    		['clientOptions'=>['source'=> Yii::$app->urlManager->createUrl([
    				'lookup/getauthrole'])],
    				'options'=>['class'=>'form-control'],
    	])
    ?>

    <div class="form-group">
        <?= Html::submitButton('Add', ['class' => 'btn btn-success', 'name' => 'addroleAction']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

</div>
