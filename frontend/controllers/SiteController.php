<?php
namespace frontend\controllers;
use frontend\assets\AppAsset;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use app\models\Test;
use yii\data\Pagination;
//use frontend\models\Lang;
// use yii\web\View;
/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
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
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {

        //echo Lang::getCurrent()->url;
//        for ($i = 230328; $i <= 250000; $i++):
//            $test = new Test();
//            $test->id = $i;
//            $test->name = '<p>name ' . $i . '</p>';
//            $test->text = '<p>text ' . $i . ' text ' . $i . ' text ' . $i . ' text ' . $i . ' text ' . $i . ' text ' . $i . ' text ' . $i . ' text ' . $i . ' text ' . $i . ' text ' . $i . ' text ' . $i . ' text ' . $i . ' text ' . $i . ' text ' . $i . '</p><p>text ' . $i . ' text ' . $i . ' text ' . $i . ' text ' . $i . ' text ' . $i . ' text ' . $i . ' text ' . $i . ' text ' . $i . ' text ' . $i . ' text ' . $i . ' text ' . $i . ' text ' . $i . ' text ' . $i . ' text ' . $i . '</p><p>text ' . $i . ' text ' . $i . ' text ' . $i . ' text ' . $i . ' text ' . $i . ' text ' . $i . ' text ' . $i . ' text ' . $i . ' text ' . $i . ' text ' . $i . ' text ' . $i . ' text ' . $i . ' text ' . $i . ' text ' . $i . '</p>';
//            $test->date_standard = date('Y-m-d H:i:s');
//            $test->date_new = date('Y-m-d H:i:s');
//            $test->save();
//        endfor;
        //$this->view->css[] = '<link href="/css/main.css" rel="stylesheet">';
//        $query = Test::find();
//        $pagination = new Pagination([
//            'defaultPageSize' => 2,
//            'totalCount' => $query->count(),
//        ]);
//        $sites = $query->orderBy('id')
//            ->offset($pagination->offset)
//            ->limit($pagination->limit)
//            ->all();

        return $this->render('index',[
//            'sites' => $sites,
//            'pagination' => $pagination,
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Displays services page.
     *
     * @return mixed
     */
    public function actionServices()
    {
        return $this->render('services');
    }

    /**
     * Displays portfolio page.
     *
     * @return mixed
     */
    public function actionPortfolio()
    {
        return $this->render('portfolio');
    }

    /**
     * Displays blog page.
     *
     * @return mixed
     */
    public function actionBlog()
    {
        return $this->render('blog');
    }

    /**
     * Displays blog item page.
     *
     * @return mixed
     */
    public function actionBlogitem()
    {
        return $this->render('blogItem');
    }

    /**
     * Displays price page.
     *
     * @return mixed
     */
    public function actionPrice()
    {
        return $this->render('price');
    }

    /**
     * Displays Short codes page.
     *
     * @return mixed
     */
    public function actionShortcodes()
    {
        return $this->render('shortcodes');
    }
    

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
