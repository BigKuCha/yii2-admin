<?php
/**
 * Created by PhpStorm.
 * User: olebar
 * Date: 2014/11/6
 * Time: 11:14:32
 */

namespace backend\controllers;


use backend\behaviors\TestBehavior;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotAcceptableHttpException;

class TestController extends BackendController
{
    public function behaviors()
    {
        return [
            [
                'class'=>TestBehavior::className(),
//                'msg'=>'APEC开的真操蛋！'
            ]
        ];
    }

    /**
     * 事件
     * @return string
     */
    public function actionEvent()
    {
        $this->on(Controller::EVENT_AFTER_ACTION,[$this,'hello']);
        $this->on(Controller::EVENT_AFTER_ACTION,function(){
            echo "我是来自匿名函数的事件<br>";
        });
        self::say();
        return '---------';
    }

    public function actionTest()
    {
        self::say();
        return '++++++';
    }

    /**
     * 事件处理器
     */
    public function Hello()
    {
        echo 'hello World!';
    }

} 