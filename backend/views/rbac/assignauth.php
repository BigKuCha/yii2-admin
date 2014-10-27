<?php
/**
 * Created by PhpStorm.
 * User: olebar
 * Date: 2014/10/27
 * Time: 15:37:32
 */
$auth = Yii::$app->authManager;
$user = Yii::$app->user;
?>
<div class="table-responsive">
    <table id="sample-table-1" class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th class="hidden-320">一级菜单</th>
            <th>二三级菜单</th>
        </tr>
        </thead>

        <tbody>
        <?php
        foreach ($list as $f): ?>
            <tr>
                <td style="width: 150px;">
                    <input type="checkbox" <?php if ($user->can($f->route)): ?> checked <?php endif; ?>
                           onclick="ckbox(1,this)" name="<?= $f['id'] ?>" id="<?= $f['id'] ?>"/>
                    &nbsp;<?= $f['menuname'] ?></td>
                <td>
                    <?php foreach ($f->getSon()->all() as $son): ?>
                        <div class="col-xs-12 col-sm-12 widget-container-span ui-sortable">
                            <div class="widget-box collapsed">
                                <div class="widget-header widget-header-small">
                                    <h6>
                                        <input type="checkbox"
                                               name="<?= $f['id'] . '_' . $son['id'] ?>"
                                               id="<?= $son['id'] ?>"
                                            <?php if ($user->can($son->route)): ?>
                                                checked
                                            <?php endif; ?>
                                               onclick="ckbox(2,this)"/>
                                        <?= $son['menuname'] ?>
                                    </h6>

                                    <div class="widget-toolbar">
                                        <a href="#" data-action="collapse">
                                            <i class="icon-chevron-down"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="widget-body">
                                    <div class="widget-body-inner" style="display: block;">
                                        <div class="widget-main">
                                            <?php foreach ($son->getSon()->all() as $gson): ?>
                                                <input type="checkbox"
                                                       name="<?= $f['id'] . '_' . $son['id'] . '_' . $gson['id'] ?>"
                                                       id="<?= $gson['id'] ?>"
                                                    <?php if ($user->can($gson->route)): ?>
                                                        checked
                                                    <?php endif; ?>
                                                       onclick="ckbox(3,this)"/>&nbsp;
                                                <?= $gson['menuname'] ?>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
    function ckbox(level, o) {
        var name = $(o).attr('name');
        var id = $(o).attr('id');
        var val = $(o).val();
        var thischecked = $(o).is(':checked');
        //选中所有子孙
        $('input[name*=' + name + '_]').prop('checked', thischecked);
        //取消选中时判断父节点
        var arr = name.split('_');
        if (level == 3) {
            //如果4级菜单全都没选中，对应的3级菜单也取消选中
            var cntf = $('input[name*=' + arr[0] + '_' + arr[1] + '_]:checked').size();
            if (cntf > 0) {
                $('input[name=' + arr[0] + '_' + arr[1] + ']').prop('checked', true);
            } else {
                $('input[name=' + arr[0] + '_' + arr[1] + ']').prop('checked', false);
            }
        }
        if (level >= 2) {
            //如果3级菜单都没选中 2级菜单也取消选中
            var cntt = $('input[name*=' + arr[0] + '_' + ']:checked').size();
            if (cntt > 0) {
                $('#' + arr[0]).prop('checked', true);
            } else {
                $('#' + arr[0]).prop('checked', false);
            }
        }
        //更新数据
        var data = 'level=' + level + '&menuid=' + id + '&cntf=' + cntf + '&cntt=' + cntt + '&ck=' + thischecked + '&roleid=' + '<?= $roleid ?>' + '&_csrf=' + '<?= Yii::$app->request->csrfToken ?>';
        /*$.ajax({
            url: '/admin/rbac/assignauth',
            type: 'post',
            data: data,
            success: function (o) {
            }
        })*/
    }
</script>