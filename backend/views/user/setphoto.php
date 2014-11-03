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
use kartik\widgets\FileInput;
$this->params['breadcrumbs'] = [
    '设置头像'
];
?>
<div class="col-lg-6">
    <?= Html::beginForm(['user/setphoto'],'post',['enctype'=>'multipart/form-data']) ?>
    <?= FileInput::widget([
        'name'=>'photo',
        'showMessage'=>false,
        'pluginOptions'=>[
            'showUpload'=>false,
            'showRemove'=>false,
            'browseLabel'=>'浏览...',
            'initialPreview'=>[
                Html::img('/upload/user/'.$preview,['class'=>'file-preview-image'])
            ],
        ],
    ]) ?>
    <div class="form-group center">
        <?= Html::submitButton('提交',['class'=>'btn btn-lg btn-primary']) ?>
    </div>
    <?= Html::endForm() ?>
</div>