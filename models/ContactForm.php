<?php

namespace app\widgets\feed\models;

use Yii;
use yii\helpers\Url;
use yii\base\Model;

/**
 * Class ContactForm
 * @package app\widgets\feed\models
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;

    const SCENARIO_GUEST = 'guest';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'subject', 'body'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
            [['verifyCode'], 'required', 'on' => self::SCENARIO_GUEST],
            ['verifyCode', 'captcha', 'captchaAction' => Url::to(['/feed/captcha']), 'on' => self::SCENARIO_GUEST],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_GUEST] = ['name', 'email', 'subject', 'body', 'verifyCode'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'E-mail'),
            'subject' => Yii::t('app', 'Subject'),
            'body' => Yii::t('app', 'Body'),
            'verifyCode' => Yii::t('app', 'Verification Code'),
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return boolean whether the email was sent
     */
    public function sendEmail($email)
    {
        return Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom([$this->email => $this->name])
            ->setSubject($this->subject)
            ->setTextBody($this->body)
            ->send();
    }
}
