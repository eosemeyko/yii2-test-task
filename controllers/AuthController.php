<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\SignUpForm;

class AuthController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays SignUp page
     *
     * @return string|Response
     */
    public function actionSignUp()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new SignUpForm();
        if ($model->load(Yii::$app->request->post()) && $model->signUp()) {
            if (Yii::$app->request->isPjax)
                return $this->renderAjax('sign-up', [
                    'model' => $model,
                    'registration_success' => true
                ]);

            return $this->asJson(['registration' => true]);
        }

        return $this->render('sign-up',
            compact('model')
        );
    }

    /**
     * Ajax Validate Form
     * @return Response
     */
    public function actionValidateForm()
    {
        $model = new SignUpForm();
        $req = Yii::$app->request;
        if (!$model->load($req->post()) || !$req->isAjax) {
            return $this->asJson(false);
        }

        return $this->asJson(ActiveForm::validate($model));
    }
}
