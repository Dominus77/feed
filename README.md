Виджет ContactForm
=======

Поместить виджет в папку app\widgets\feed

Добавить в главный конфиг контроллер виджета и правила urlManager
app/config/web.php
```
$config = [
    'controllerMap' => [
        'feed' => [
            'class' => 'app\widgets\feed\controllers\FeedController',
        ],
    ],
    'components' => [
        //...
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => [
                'feed/contact' => 'feed/contact',
                'feed/captcha' => 'feed/captcha',
            ],
        ],
    ],
    //...
];
```
Вывод виджета:
```
<?= app\widgets\feed\FeedWidget::widget([
    'id' => 'contact-form',
    'clientOptions' => [
        'data-pjax' => true,
    ],
    'pjaxOptions' => [
        'enablePushState' => false,
    ],
); ?>
```