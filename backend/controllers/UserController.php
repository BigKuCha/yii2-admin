<?php
/**
 *	  ┏┓　　　┏┓
 *	┏┛┻━━━┛┻┓
 *	┃　　　　　　　┃
 *	┃　　　━　　　┃
 *	┃　┳┛　┗┳　┃
 *	┃　　　　　　　┃
 *	┃　　　┻　　　┃
 *	┃　　　　　　　┃
 *	┗━┓　　　┏━┛
 *	    ┃　　　┃   神兽保佑
 *	    ┃　　　┃   代码无BUG！
 *	 	 ┃　　　┗━━━┓
 *	    ┃　　　　　　　┣┓
 *	    ┃　　　　　　　┏┛
 *	    ┗┓┓┏━┳┓┏┛
 *	      ┃┫┫　┃┫┫
 *	      ┗┻┛　┗┻┛
 */ 

namespace backend\controllers;

use common\components\MyHelper;
use app\models\LoginForm;
use Yii;
use app\models\TAdmUser;
use yii\data\ActiveDataProvider;

class UserController extends BackendController
{
    public function actionIndex()
    {
        $q = TAdmUser::find();
        $dataprovider = new ActiveDataProvider([
            'query'=>$q,
        ]);
        return $this->render('index',[
            'model'=>new TAdmUser(),
            'dataprovider'=>$dataprovider
        ]);
    }

    /**
     * 登陆
     * @return null|string
     */
    public function actionLogin()
    {
        $model = new TAdmUser();
        if(Yii::$app->request->isPost)
        {
            $model = new LoginForm($_POST);
            $model->rememberMe = $_POST['rememberMe']?:false;
            if($model->login())
                return $this->goHome();
//                return MyHelper::dump(Yii::$app->user->identity);
        }
        $this->layout = 'main-login';
        return $this->render('login',[
            'model'=>$model
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
    public function actionAdduser()
    {
        $model = new TAdmUser();
        $model->username = 'admin';
        $model->password = Yii::$app->security->generatePasswordHash('admin');
        $model->password_repeat = $model->password;
        $model->save();
        return MyHelper::dump($model->getErrors());
    }
} 