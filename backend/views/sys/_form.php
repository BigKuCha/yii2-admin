<?php
/**
 *      ┏┓　　　┏┓
 *    ┏┛┻━━━┛┻┓
 *    ┃　　　　　　　┃
 *    ┃　　　━　　　┃
 *    ┃　┳┛　┗┳　┃
 *    ┃　　　　　　　┃
 *    ┃　　　┻　　　┃
 *    ┃　　　　　　　┃
 *    ┗━┓　　　┏━┛
 *        ┃　　　┃   神兽保佑
 *        ┃　　　┃   代码无BUG！
 *         ┃　　　┗━━━┓
 *        ┃　　　　　　　┣┓
 *        ┃　　　　　　　┏┛
 *        ┗┓┓┏━┳┓┏┛
 *          ┃┫┫　┃┫┫
 *          ┗┻┛　┗┻┛
 */
use yii\helpers\Html;

?>

<div class="col-lg-6">
    <?php $form = \kartik\widgets\ActiveForm::begin([
//        'action'        => '/sys/create',
        'validationUrl' => '/sys/ajaxvalidate',
    ]) ?>

    <?= $form->field($model, 'menuname')->textInput() ?>
    <?= $form->field($model, 'route', ['enableAjaxValidation' => true])->textInput()->hint('三级菜单必须要按照\'controller/action\'格式书写') ?>
    <?= $form->field($model, 'menuicon')->textInput()->hint('参照Bootstrap图标') ?>
    <?= $form->field($model, 'level')->dropDownList([
        '1' => '一级菜单',
        '2' => '二级菜单',
        '3' => '三级菜单',
    ], [
        'options' => [
            '1' => ['disabled' => ($plevel == 0) ? false : true],
            '2' => ['disabled' => ($plevel == 1) ? false : true],
            '3' => ['disabled' => ($plevel == 1 || $plevel == 2) ? false : true]
        ]
    ]) ?>
    <?= Html::activeHiddenInput($model, 'parentid') ?>
    <?= Html::hiddenInput('id', $model->id) ?>
    <div class="form-group center">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '更新', ['class' => 'btn btn-lg btn-primary']) ?>
    </div>
    <?php $form->end() ?>
</div>