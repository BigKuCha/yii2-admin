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
use yii\grid\GridView;
use yii\helpers\Html;
$this->params['breadcrumbs'] = [
    '角色管理',
];
?>
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
            'buttons'=>[
                'update'=>function($url, $model, $key)
                {
                    return Html::a('',$url,['class'=>'glyphicon glyphicon-pencil']);
                },
                'delete1'=>function($url,$model,$key)
                {
                    return \yii\helpers\Html::a('afe');
                }
            ]
        ]
    ],
]) ?>