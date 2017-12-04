<?php

namespace app\widgets\feed\controllers;

use Yii;
use yii\web\Controller;
use app\widgets\feed\models\ContactForm;
use yii\helpers\Url;

/**
 * Class FeedController
 * @package app\widgets\feed\controllers
 */
class FeedController extends Controller
{

    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'backColor' => 0xF1F1F1,
                'foreColor' => 0xEE7600,
            ],
        ];
    }

    /**
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionContact()
    {
        if ($post = Yii::$app->request->post()) {
            $model = new ContactForm();
            if(Yii::$app->user->isGuest)
                $model->scenario = $model::SCENARIO_GUEST;
            if ($model->load($post) && $model->validate()) {
                // Метод sendEmail() в модели ContactForm отвечает за отправку
                if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                    $message = [
                        'status' => 'success',
                        'msg' => Yii::t('app', 'Thank you for contacting us. We will respond to you as soon as possible.'),
                    ];
                } else {
                    $message = [
                        'status' => 'danger',
                        'msg' => Yii::t('app', 'There was an error sending email.'),
                    ];
                }
            } else {
                $message = [
                    'status' => 'danger',
                    'msg' => Yii::t('app', 'Something went wrong!'),
                ];
            }
            if (Yii::$app->request->isAjax) {
                $msg = '<div class="alert alert-' . $message['status'] . '">' . $message['msg'] . '</div>';
                // Возвращаем виджет с сообщением
                return \app\widgets\feed\FeedWidget::widget([
                    'id' => 'contact-form',
                    'message' => $msg,
                    'clientOptions' => [
                        'data-pjax' => true,
                    ],
                    'pjaxOptions' => [
                        'enablePushState' => false,
                    ],
                ]);
            } else {
                Yii::$app->session->setFlash($message['status'], $message['msg']);
            }
        }
        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }
}