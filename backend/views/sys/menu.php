<?php
/**
 * Created by PhpStorm.
 * User: olebar
 * Date: 2014/10/22
 * Time: 16:31:54
 */
\backend\assets\TreeAsset::register($this);
$this->registerJs("
    $('.tree li:has(ul)').addClass('parent_li').find(' > span').attr('title', 'Collapse this branch');
        $('.tree li.parent_li > span').on('click', function (e) {
            var children = $(this).parent('li.parent_li').find(' > ul > li');
            if (children.is(':visible')) {
                children.hide('fast');
                $(this).attr('title', 'Expand this branch').find(' > i').addClass('icon-plus-sign').removeClass('icon-minus-sign');
            } else {
                children.show('fast');
                $(this).attr('title', 'Collapse this branch').find(' > i').addClass('icon-minus-sign').removeClass('icon-plus-sign');
            }
            e.stopPropagation();
        });
");
?>
<div class="tree well">
    <ul>
        <li>
            <span><i class="icon-folder-open"></i> 系统管理</span> <a href=""></a>
            <ul>
                <li>
                    <span><i class="icon-minus-sign"></i> 系统管理</span> <a href=""></a>
                    <ul>
                        <li>
                            <span><i class="icon-leaf"></i> 权限管理</span> <a href=""></a>
                        </li>
                        <li>
                            <span><i class="icon-leaf"></i> 菜单管理</span> <a href=""></a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
    </ul>
</div>