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

use backend\models\TMenu;
use common\components\MyHelper;
use app\models\LoginForm;
use Yii;
use backend\models\TAdmUser;
use yii\data\ActiveDataProvider;
use yii\web\Response;
use yii\widgets\ActiveForm;

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

    /**
     * 登出
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     * 添加用户
     * @return null|string
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function actionAdduser()
    {
        $model = new TAdmUser();
        if(Yii::$app->request->isPost)
        {
            $model->load($_POST);
            if($model->load($_POST) && $model->save())
                Yii::$app->session->setFlash('success');
            else
                Yii::$app->session->setFlash('fail','添加失败');
            return $this->goBack(['user/index']);
        }
    }

    /**
     * ajax验证是否存在
     * @return array
     */
    public function actionAjaxvalidate()
    {
        $model = new TAdmUser();
        if(Yii::$app->request->isAjax)
        {
            $model->load($_POST);
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model,'username');
        }
    }

    public function actionMenu()
    {
        $list = TMenu::find()->where('level=1')->all();
        return $this->render('menu',[
            'list'=>$list,
        ]);
        return MyHelper::dump($list);
    }
} 