<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;

/* @var $this yii\web\View */
/* @var $model app\modules\rbac\models\AuthItemChild */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auth-item-child-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= //$form->field($model, 'parent')->textInput(['maxlength' => true]);
		$form->field($model, 'parent')->widget(AutoComplete::className(), [
			'clientOptions' => [
				'source' => Yii::$app->urlManager->createUrl(['lookup/getauthitem']),
			],
			'options'=>['class'=>'form-control'],
		]); ?>

    <?= //$form->field($model, 'child')->textInput(['maxlength' => true]); 
		$form->field($model, 'child')->widget(AutoComplete::className(), [
				'clientOptions' => [
						'source' => Yii::$app->urlManager->createUrl(['lookup/getauthitem']),
				],
				'options'=>['class'=>'form-control'],
		]);
	?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
