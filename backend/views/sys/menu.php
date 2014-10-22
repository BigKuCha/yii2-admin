<?php
/**
 * Created by PhpStorm.
 * User: olebar
 * Date: 2014/10/22
 * Time: 16:31:54
 */
\backend\assets\TreeAsset::register($this);
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
?>
<div class="tree">
    <ul>
        <li>
            <span><i class="icon-folder-open"></i> 系统管理</span> <a href=""></a>
            <a class="icon-plus" href="javascript:;"
               onclick="add('add',<?= $v->id; ?> , <?= $v->level ?>)" title="添加"></a>
            <a class="icon-edit" href="javascript:;"
               onclick="add('edit',<?= $v->id; ?> , <?= $v->level ?>)" title="编辑"></a>
            <a class="icon-trash" href="javascript:;" onclick="del(<?= $v->id; ?>,<?= $v->level ?>)" title="删除"></a>
            <ul>
                <li>
                    <span><i class="icon-minus-sign"></i> 系统管理</span> <a href=""></a>
                    <a class="icon-plus" href="javascript:;"
                       onclick="add('add',<?= $son->id; ?> , <?= $son->level ?>)" title="添加"></a>
                    <a class="icon-edit" href="javascript:;"
                       onclick="add('edit',<?= $son->id; ?> , <?= $son->level ?>)" title="编辑"></a>
                    <a class="icon-trash" href="javascript:;"
                       onclick="del(<?= $son->id; ?>,<?= $son->level ?>  )" title="删除"></a>
                    <ul>
                        <li>
                            <span><i class="icon-leaf"></i> 权限管理</span> <a href=""></a>
                            <a class="icon-edit" href="javascript:;"
                               onclick="add('edit',<?= $gson->id; ?> , <?= $gson->level ?>)" title="编辑"></a>
                            <a class="icon-trash" href="javascript:;"
                               onclick="del(<?= $gson->id; ?>,<?= $gson->level ?>)" title="删除"></a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
    </ul>
</div>