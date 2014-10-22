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
use yii\grid\SerialColumn;
use yii\bootstrap\Modal;
$this->params['breadcrumbs'] = [
    '用户管理',
];
?>

<?php
Modal::begin([
    'id'=>'md',
    'header' => '<h2>添加用户</h2>',
    'footer'=>'<button type="button" class="btn btn-primary" onclick="sbmt()">确定</button>',
]);
$form = \yii\widgets\ActiveForm::begin([
    'id'=>'userform',
    'action'=>'adduser',
    'validationUrl'=>'ajaxvalidate',
])
?>

<?= $form->field($model,'username',['enableAjaxValidation'=>true])->textInput() ?>
<?= $form->field($model,'password')->passwordInput() ?>
<?= $form->field($model,'password_repeat')->passwordInput() ?>

<?php
$form->end();
Modal::end();
?>
<?= \yii\helpers\Html::button('添加用户',['onclick'=>'$("#md").modal();']) ?>
<?= \yii\grid\GridView::widget([
    'dataProvider'=>$dataprovider,
    'columns'=>[
        ['class' => SerialColumn::className()],
        'username',
        'password',
        [
            'class'=>'yii\grid\ActionColumn'
        ],
    ],
]) ?>
<script>
    function sbmt()
    {
        $('#userform').submit();
    }
</script>