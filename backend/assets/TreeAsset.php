<?php
/**
 * Created by PhpStorm.
 * User: olebar
 * Date: 2014/10/22
 * Time: 16:32:40
 */

namespace backend\assets;


use yii\web\AssetBundle;

class TreeAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/treeview.css',
    ];
    public $depends = [
        'backend\assets\BootstrapjsAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
} 