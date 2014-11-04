<?php
/**
 *	  ┏┓　　　┏┓
 *	┏┛┻━━━┛┻┓
 *	┃　　　　　　　┃
 *	┃　　　━　　　┃
 *	┃　┳┛　┗┳　┃
 *	┃　　　　　　　┃
 *	┃　　　┻　　　┃
 *	┃　　　　　　　┃
 *	┗━┓　　　┏━┛
 *	    ┃　　　┃   神兽保佑
 *	    ┃　　　┃   代码无BUG！
 *	 	 ┃　　　┗━━━┓
 *	    ┃　　　　　　　┣┓
 *	    ┃　　　　　　　┏┛
 *	    ┗┓┓┏━┳┓┏┛
 *	      ┃┫┫　┃┫┫
 *	      ┗┻┛　┗┻┛
 */
use yii\widgets\ActiveForm;
$this->params['breadcrumbs'] = [
    '修改密码'
];
?>
<div class="col-lg-6">
    <?php $form = ActiveForm::begin([]) ?>
    <?= $form->field($model,'password')->passwordInput(['value'=>'']) ?>
    <?= $form->field($model,'password_repeat')->passwordInput() ?>
    <div class="form-group center">
        <?= \yii\helpers\Html::submitButton('提交',['class'=>'btn btn-lg btn-primary']) ?>
    </div>
    <?php $form->end() ?>
</div>