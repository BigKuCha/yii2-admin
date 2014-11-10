<?php
/**
 * Created by PhpStorm.
 * User: BigKuCha
 * Date: 14-7-30
 * Time: 下午8:37
 */

namespace common\widgets;


use yii\web\AssetBundle;

class DateTimePickerAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'js/jquery.datetimepicker.js',
    ];
    public $css = [
        'css/jquery.datetimepicker.css'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
} 