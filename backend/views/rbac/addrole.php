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
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
$this->params['breadcrumbs'] = [
    [
        'label'=>'角色管理',
        'url'=>'/rbac/roles',
    ],
    ($model->isNewRecord)?'添加角色':'修改角色('.$model->name.')'
];
?>

<div class="col-lg-6">
<?php $form = ActiveForm::begin([
    'validationUrl'=>'/rbac/validateitemname',
]) ?>

<?= $form->field($model,'name',['enableAjaxValidation'=>true])->textInput() ?>
<?= $form->field($model,'description')->textarea() ?>
<?= Html::hiddenInput('id',$model->name) ?>

<div class="form-group center">
    <?= Html::submitButton('提交', ['class' => 'btn btn-lg btn-primary']) ?>
</div>

<?php $form->end() ?>

</div>