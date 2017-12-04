<?php
namespace app\widgets\feed;

use Yii;
use yii\bootstrap\Widget;
use yii\base\InvalidConfigException;
use yii\widgets\Pjax;
use yii\helpers\Url;
use app\widgets\feed\models\ContactForm;

/**
 * Class FeedWidget
 * @package app\widgets\feed
 */
class FeedWidget extends Widget
{
    public $id;
    public $url;
    public $message = '';
    public $clientOptions = [];
    public $pjaxOptions = [];    

    public function init()
    {
        parent::init();
        $this->id = $this->id ?: $this->getId();
        $this->url = $this->url ?: Url::to(['/feed/contact']);
        if (empty($this->url)) {
            throw new InvalidConfigException(Yii::t('app', 'The parameter url is not set'));
        }
        $this->options = [
            'id' => $this->id,
            'action' => $this->url,
            'options' => $this->clientOptions,
        ];
    }

    public function run()
    {
        Pjax::begin($this->pjaxOptions);
        echo $this->message;
        $model = new ContactForm();
        if(Yii::$app->user->isGuest)
            $model->scenario = $model::SCENARIO_GUEST;
        echo $this->render('_form', [
            'options' => $this->options,
            'model' => $model,
        ]);
        Pjax::end();
    }
}