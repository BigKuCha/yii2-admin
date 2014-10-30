<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

//$this->title = $name;
$this->params['breadcrumbs'] = [
    $name,
];
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>
    <p>
        服务器在处理您的请求时发生以上错误！
    </p>
    <p>
        如果你认为这是一个服务器错误，请联系我们。谢谢.
    </p>

</div>
