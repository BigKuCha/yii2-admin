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
 *	 	┃　　　┗━━━┓
 *	    ┃　　　　　　　┣┓
 *	    ┃　　　　　　　┏┛
 *	    ┗┓┓┏━┳┓┏┛
 *	      ┃┫┫　┃┫┫
 *	      ┗┻┛　┗┻┛
 */
use yii\grid\GridView;
use yii\helpers\Html;
use common\components\MyHelper;
$this->params['breadcrumbs'] = [
    '角色管理',
];
?>
<p>
    <?= Html::a('添加角色',['rbac/addrole'],['class'=>'btn btn-sm btn btn-success']) ?>
</p>

<?= GridView::widget([
    'dataProvider'=>$dataprovider,
    'columns'=>[
        'type:text:类型',
        'name:text:名称',
        'description:text:描述',
        'ruleName:text:规则名称',
        'createdAt:datetime:创建时间',
        [
            'class'=>'yii\grid\ActionColumn',
            'header'=>'操作',
            'template'=>'{view} {update} {delete}',
            'buttons'=>[
                'view'=>function($url,$model,$key)
                {
                    return MyHelper::actionbutton($url,'view',['title'=>'分配角色']);
                },
                'update'=>function($url, $model, $key)
                {
                    return MyHelper::actionbutton($url,'update');
                },
                'delete'=>function($url,$model,$key)
                {
                    return MyHelper::actionbutton($url,'delete');
                }
            ]
        ]
    ],
]) ?>