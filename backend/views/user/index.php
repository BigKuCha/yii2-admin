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
use kartik\widgets\ActiveForm;
$this->params['breadcrumbs'] = [
    '用户管理',
];
?>

<?php
Modal::begin([
    'id'=>'md',
    'header' => '<h4>添加用户</h4>',
    'footer'=>'<button type="button" class="btn btn-primary" onclick="sbmt()">确定</button>',
]);
$form = ActiveForm::begin([
    'id'=>'userform',
    'action'=>'/user/adduser',
    'validationUrl'=>'/user/ajaxvalidate',
])
?>

<?= $form->field($model,'username',['enableAjaxValidation'=>true])->textInput() ?>
<?= $form->field($model,'password')->passwordInput() ?>
<?= $form->field($model,'password_repeat')->passwordInput() ?>

<?php
$form->end();
Modal::end();
?>
<p>
    <?= \yii\helpers\Html::button('添加用户',[
        'class'=>'btn btn-sm btn-success',
        'onclick'=>'$("#md").modal();'
    ]) ?>
</p>
<?= \yii\grid\GridView::widget([
    'dataProvider'=>$dataprovider,
    'columns'=>[
        [
            'class'=>'yii\grid\CheckboxColumn',
        ],
        [
            'header'=>'编号',
            'class' => SerialColumn::className()
        ],
        'username',
        'password',
        [
            'header'=>'操作',
            'class'=>'yii\grid\ActionColumn',
            'template' => '{view} {update} {delete}',
            'buttons'=>[
                'view'=>function($url,$model,$key)
                {
                    return \common\components\MyHelper::actionbutton('/rbac/assignrole?id='.$key,'view',['title'=>'查看/添加角色']);
                },
            ]
        ],
    ],
]) ?>
<script>
    function sbmt()
    {
        $('#userform').submit();
    }
</script>