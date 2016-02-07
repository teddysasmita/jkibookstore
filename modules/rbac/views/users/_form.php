<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\rbac\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-form">

    <?php $form = ActiveForm::begin(); ?>
	<?php
		echo Html::activeHiddenInput($model, 'auth_key');
		echo Html::activeHiddenInput($model, 'access_token');	
		echo Html::activeHiddenInput($model, 'userlog');
		echo Html::activeHiddenInput($model, 'datetimelog');
		echo Html::activeHiddenInput($model, 'id');
	?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fullname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'active')->dropDownList(['1'=>'Ya', '0'=>'Tidak'],['prompt'=>'Harap Pilih']) ?>

    <div class="form-group">
    
        <?php 
        	if ($model->isNewRecord) 
        		echo Html::submitButton('Create', 
        			['class' => 'btn btn-success',
        			'name' => 'commandAction', 'value' => 'create' ]);
        	else
        		echo Html::submitButton('Update',
        			['class' => 'btn btn-primary',
        			'name' => 'commandAction', 'value' => 'update' ])
        ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
