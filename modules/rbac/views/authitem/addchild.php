<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;

/* @var $this yii\web\View */
/* @var $model app\modules\rbac\models\AuthItem */

$this->title = 'Create Auth Item Child';
$this->params['breadcrumbs'][] = ['label' => 'Auth Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->parent, 'url'=> ['view', 'id' => $model->parent]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-create">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php $form = ActiveForm::begin(); ?>
    
    <?php echo Html::activeHiddenInput($model, 'parent'); ?>

    <?= //$form->field($model, 'child')->textInput(['maxlength' => true]); 
		$form->field($model, 'child')->widget(AutoComplete::className(), [
				'clientOptions' => [
						'source' => Yii::$app->urlManager->createUrl(['lookup/getauthpermission']),
				],
				'options'=>['class'=>'form-control'],
		]);
	?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', 
        		['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
        		'name'=>'commandAction'
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


