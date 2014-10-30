<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/font-awesome.min.css',
        'css/ace.min.css',
        'css/ace-rtl.min.css',
        'css/ace-skins.min.css',
    ];
    public $js = [
        'js/ace-extra.min.js',
        'js/typeahead-bs2.min.js',
        'js/ace-elements.min.js',
        'js/ace.min.js',
        'js/jquery.cookie.js'
    ];
    public $depends = [
        'backend\assets\BootstrapjsAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
