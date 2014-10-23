<?php
/**
 * Created by PhpStorm.
 * User: olebar
 * Date: 2014/10/23
 * Time: 11:59:51
 */
$this->params['breadcrumbs'] = [
    [
        'label'=>'路由管理',
        'url'=>'/sys/menu'
    ],
    '添加路由'
];
use yii\helpers\Html;
?>

<div class="col-lg-6">
    <?php $form = \kartik\widgets\ActiveForm::begin([
        'action'=>'/sys/menumange',
        'validationUrl'=>'/sys/ajaxvalidate',
    ]) ?>

    <?= $form->field($model,'menuname')->textInput() ?>
    <?= $form->field($model,'route',['enableAjaxValidation'=>true])->textInput()->hint('一二级菜单也填写，用于权限管理') ?>
    <?= $form->field($model,'menuicon')->textInput() ?>
    <?= $form->field($model,'level')->dropDownList([
        '1'=>'一级菜单',
        '2'=>'二级菜单',
        '3'=>'三级菜单',
    ]) ?>
    <?= Html::activeHiddenInput($model,'parentid') ?>

    <div class="form-group center">
            <?= Html::submitButton('提交', ['class' => 'btn btn-lg btn-primary']) ?>
    </div>
    <?php $form ->end() ?>
</div>
