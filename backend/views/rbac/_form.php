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

use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

?>

<div class="col-lg-6">
    <?php $form = ActiveForm::begin([
        'validationUrl' => Url::toRoute(['rbac/validateitemname']),
    ]) ?>

    <?= $form->field($model, 'name', ['enableAjaxValidation' => true])->textInput() ?>
    <?= $form->field($model, 'description')->textarea() ?>
    <?= Html::hiddenInput('id', $model->name) ?>

    <div class="form-group center">
        <?= Html::submitButton('提交', ['class' => 'btn btn-lg btn-primary']) ?>
    </div>

    <?php $form->end() ?>

</div>