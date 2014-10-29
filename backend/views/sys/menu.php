<?php
/**
 * Created by PhpStorm.
 * User: olebar
 * Date: 2014/10/22
 * Time: 16:31:54
 */
use backend\assets\TreeAsset;
use yii\helpers\Url;

TreeAsset::register($this);


$this->params['breadcrumbs'] = [
    '菜单管理'
];
?>

<div class="tree">
    <ul>
        <li>
            <span><i class="icon-leaf"></i> <?= Yii::$app->params['webname'] ?></span> <a href=""></a>
            <a class="icon-plus" href="<?= Url::to(['sys/menumange','pid'=>0,'level'=>0]) ?>" title="添加"></a>
        </li>
        <li>
            <ul>
                <?php \yii\widgets\Pjax::begin([]) ?>
                <!--一级菜单-->
                <?php foreach ($list as $father): ?>
                    <li>
                        <span><i class="<?= $father->menuicon ?>"></i> <?= $father->menuname ?></span> <a href=""></a>
                        <a class="icon-plus" href="<?= Url::to(['sys/menumange','pid'=>$father->id,'level'=>$father->level]) ?>" title="添加"></a>
                        <a class="icon-edit" href="<?= Url::to(['sys/menumange','id'=>$father->id]) ?>"  title="编辑"></a>
                        <a class="icon-trash" href="<?= Url::to(['sys/menudel','id'=>$father->id,'level'=>$father->level]) ?>" data-method="post"  data-confirm="确定要删除当前菜单以及所有子菜单吗?" title="删除"></a>

                        <ul>
                            <!--二级菜单-->
                            <?php foreach ($father->getSon()->all() as $son): ?>
                                <!--一级菜单下的3级菜单-->
                                <?php if ($son->level == 3): ?>
                                    <li>
                                        <span><i class="<?= $son->menuicon ?>"></i> <?= $son->menuname ?></span> <a href=""></a>
                                        <a class="icon-edit" href="<?= Url::to(['sys/menumange','id'=>$son->id]) ?>" title="编辑"></a>
                                        <a class="icon-trash" href="<?= Url::to(['sys/menudel','id'=>$son->id,'level'=>$son->level]) ?>" data-method="post"  data-confirm="确定删除当前菜单吗？" title="删除"></a>
                                    </li>
                                <?php else: ?>
                                    <li>
                                        <span><i class="icon-minus-sign"></i> <?= $son->menuname ?></span> <a
                                            href=""></a>
                                        <a class="icon-plus" href="<?= Url::to(['sys/menumange','pid'=>$son->id,'level'=>$son->level]) ?>"  title="添加"></a>
                                        <a class="icon-edit" href="javascript:;"
                                           onclick="add('edit',<?= $son->id; ?> , <?= $son->level ?>)" title="编辑"></a>
                                        <a class="icon-trash" href="<?= Url::to(['sys/menudel','id'=>$son->id,'level'=>$son->level]) ?>" data-method="post"  data-confirm="确定删除当前菜单以及所有子菜单吗" title="删除"></a>
                                        <ul>
                                            <!--三级菜单-->
                                            <?php foreach ($son->getSon()->all() as $gson): ?>
                                                <li>
                                                    <span><i class="<?= $gson->menuicon ?>"></i> <?= $gson->menuname ?></span> <a
                                                        href=""></a>
                                                    <a class="icon-edit" href="<?= Url::to(['sys/menumange','id'=>$gson->id]) ?>" title="编辑"></a>
                                                    <a class="icon-trash" href="<?= Url::to(['sys/menudel','id'=>$gson->id,'level'=>$gson->level]) ?>" data-method="post"  data-confirm="确定删除吗?" title="删除"></a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php \yii\widgets\Pjax::end() ?>
        </li>
    </ul>
</div>
<script>
    <?php $this->beginBlock('aa') ?>
    $('.tree li:has(ul)').addClass('parent_li').find(' > span');
    //默认收起
    //    $('.tree li.parent_li >span').parent('li.parent_li').find(' > ul > li').hide();
    $('.tree li.parent_li > span').on('click', function (e) {
        var children = $(this).parent('li.parent_li').find(' > ul > li');
        if (children.is(':visible')) {
            children.hide('fast');
            $(this).find(' > i').addClass('icon-plus-sign').removeClass('icon-minus-sign');
        } else {
            children.show('fast');
            $(this).find(' > i').addClass('icon-minus-sign').removeClass('icon-plus-sign');
        }
        e.stopPropagation();
    });
    <?php $this->endBlock(); ?>
</script>
<?php $this->registerJs($this->blocks['aa']) ?>