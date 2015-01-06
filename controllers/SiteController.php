<?php

namespace app\controllers;

use dosamigos\qrcode\QrCode;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
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

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
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

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionBuildUrl()
    {
        $landingUrl = rtrim(strtolower(trim(Yii::$app->request->post('landing'))), '/\\');
        $medium = str_replace(" ", "+", strtolower(trim(Yii::$app->request->post('medium'))));
        $source = str_replace(" ", "+", strtolower(trim(Yii::$app->request->post('source'))));
        $content = str_replace(" ", "+", strtolower(trim(Yii::$app->request->post('content'))));
        $keyword = str_replace(" ", "+", strtolower(trim(Yii::$app->request->post('keyword'))));
        $campaignName = str_replace(" ", "+", strtolower(trim(Yii::$app->request->post('campaign'))));
        $parameter = Yii::$app->request->post('parameter');

        if ($landingUrl) {
            $regex = "(https?://)";
            if (!preg_match($regex, $landingUrl)) {
                $landingUrl = 'http://' . $landingUrl;
            }
            $regex = '_^(?:(?:https?|ftp)://)(?:\\S+(?::\\S*)?@)?(?:(?!10(?:\\.\\d{1,3}){3})(?!127(?:\\.\\d{1,3}){3})(?!169\\.254(?:\\.\\d{1,3}){2})(?!192\\.168(?:\\.\\d{1,3}){2})(?!172\\.(?:1[6-9]|2\\d|3[0-1])(?:\\.\\d{1,3}){2})(?:[1-9]\\d?|1\\d\\d|2[01]\\d|22[0-3])(?:\\.(?:1?\\d{1,2}|2[0-4]\\d|25[0-5])){2}(?:\\.(?:[1-9]\\d?|1\\d\\d|2[0-4]\\d|25[0-4]))|(?:(?:[a-z\\x{00a1}-\\x{ffff}0-9]+-?)*[a-z\\x{00a1}-\\x{ffff}0-9]+)(?:\\.(?:[a-z\\x{00a1}-\\x{ffff}0-9]+-?)*[a-z\\x{00a1}-\\x{ffff}0-9]+)*(?:\\.(?:[a-z\\x{00a1}-\\x{ffff}]{2,})))(?::\\d{2,5})?(?:/[^\\s]*)?$_iuS';
            if (preg_match($regex, $landingUrl)) {
                if ($medium) {
                    $data = $landingUrl . $parameter . 'utm_medium=' . $medium;
                    if ($source) {
                        $data .= '&utm_source=' . $source;
                    }
                    if ($content) {
                        $data .= '&utm_content=' . $content;
                    }
                    if ($keyword) {
                        $data .= '&utm_term=' . $keyword;
                    }
                    if ($campaignName) {
                        $data .= '&utm_campaign=' . $campaignName;
                    }
                    $response['id'] = $landingUrl;//$this->getShortUrl($data);
                    $response['longUrl'] = $data;
                    $response['qrcode'] = Url::to(['/site/qrcode', 'text' => $response['id']]);
                } else {
                    $response['error']['medium'] = "Medium is required";
                }
            } else {
                $response['error']['landing'] = "Entered Url is not valid";
            }
        } else {
            $response['error']['landing'] = "LandingUrl is required";

        }
        echo json_encode($response);
    }

    private function getShortUrl($longUrl)
    {
        $apiKey = "insert api key here";
        $postData = array('longUrl' => $longUrl, 'key' => $apiKey);
        $jsonData = json_encode($postData);

        $curlObj = curl_init();
        curl_setopt($curlObj, CURLOPT_URL, 'https://www.googleapis.com/urlshortener/v1/url');
        curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curlObj, CURLOPT_HEADER, 0);
        curl_setopt($curlObj, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
        curl_setopt($curlObj, CURLOPT_POST, 1);
        curl_setopt($curlObj, CURLOPT_POSTFIELDS, $jsonData);

        $response = curl_exec($curlObj);
        $json = json_decode($response);
        curl_close($curlObj);

        return $json->id;
    }

    public function actionQrcode($text)
    {
        return QrCode::png($text);
    }

    public function actionSendMail() {
        $email = Yii::$app->request->post('email');
        $landing = Yii::$app->request->post('landing');
        $taggedUrl = Yii::$app->request->post('taggedUrl');
        $shortenedUrl = Yii::$app->request->post('shortenedUrl');
        if ($email && $landing) {
            Yii::$app->mailer->compose('gacub/html', ['taggedUrl' => $taggedUrl, 'shortenedUrl' => $shortenedUrl])
                ->setFrom('fimak@bk.ru')
                ->setTo($email)
                ->setSubject("Campaign-tagged Landing Page URL for {$landing}")
                ->send();
            return 'fimak@bk.ru';
        }
        return 'error';
    }
}
