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
$this->registerJs("
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
");

$this->params['breadcrumbs'] = [
    '菜单管理'
];
?>

<div class="tree">
    <ul>
        <li>
            <span><i class="icon-leaf"></i> Nevermore</span> <a href=""></a>
            <a class="icon-plus" href="<?= Url::to(['sys/menumange','pid'=>0]) ?>" title="添加"></a>
        </li>
        <li>
            <ul>
                <!--一级菜单-->
                <?php foreach ($list as $father): ?>
                    <li>
                        <span><i class="icon-folder-open"></i> <?= $father->menuname ?></span> <a href=""></a>
                        <a class="icon-plus" href="" title="添加"></a>
                        <a class="icon-edit" href=""  title="编辑"></a>
                        <a class="icon-trash" href="" title="删除"></a>
                        <ul>
                            <!--二级菜单-->
                            <?php foreach ($father->getSon()->all() as $son): ?>
                                <!--一级菜单下的3级菜单-->
                                <?php if ($son->level == 3): ?>
                                    <li>
                                        <span><i class="icon-leaf"></i> <?= $son->menuname ?></span> <a href=""></a>
                                        <a class="icon-edit" href="javascript:;"
                                           onclick="add('edit',<?= $gson->id; ?> , <?= $gson->level ?>)" title="编辑"></a>
                                        <a class="icon-trash" href="javascript:;"
                                           onclick="del(<?= $gson->id; ?>,<?= $gson->level ?>)" title="删除"></a>
                                    </li>
                                <?php else: ?>
                                    <li>
                                        <span><i class="icon-minus-sign"></i> <?= $son->menuname ?></span> <a
                                            href=""></a>
                                        <a class="icon-plus" href="javascript:;"
                                           onclick="add('add',<?= $son->id; ?> , <?= $son->level ?>)" title="添加"></a>
                                        <a class="icon-edit" href="javascript:;"
                                           onclick="add('edit',<?= $son->id; ?> , <?= $son->level ?>)" title="编辑"></a>
                                        <a class="icon-trash" href="javascript:;"
                                           onclick="del(<?= $son->id; ?>,<?= $son->level ?>  )" title="删除"></a>
                                        <ul>
                                            <!--三级菜单-->
                                            <?php foreach ($son->getSon()->all() as $gson): ?>
                                                <li>
                                                    <span><i class="icon-leaf"></i> <?= $gson->menuname ?></span> <a
                                                        href=""></a>
                                                    <a class="icon-edit" href="javascript:;"
                                                       onclick="add('edit',<?= $gson->id; ?> , <?= $gson->level ?>)"
                                                       title="编辑"></a>
                                                    <a class="icon-trash" href="javascript:;"
                                                       onclick="del(<?= $gson->id; ?>,<?= $gson->level ?>)"
                                                       title="删除"></a>
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
        </li>
    </ul>

</div>