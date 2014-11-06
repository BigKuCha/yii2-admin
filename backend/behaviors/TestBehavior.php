<?php
/**
 * Created by PhpStorm.
 * User: olebar
 * Date: 2014/11/6
 * Time: 11:33:33
 */
namespace backend\behaviors;


use yii\base\Behavior;
use yii\web\Controller;

/**
 * Class TestBehavior
 * @package backend\behaviors
 */
class TestBehavior extends Behavior
{
    public $msg;
    public function events()
    {
        return [
            Controller::EVENT_AFTER_ACTION=>'myafter',
        ];
    }
    public function myafter()
    {
        echo '我来自TestBehavior!'.$this->msg.'<br>';
    }

    public static function Say(){
        echo "我是来自TestBehavior的静态方法 <br>";
    }

} 