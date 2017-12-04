<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\widgets\feed\models\ContactForm */
/* @var $options array */

?>

<?php $form = ActiveForm::begin($options); ?>

    <div class="form-group">
        <?= $form->field($model, 'name')->textInput(['class' => 'form-control']) ?>
    </div>
    <div class="form-group">
        <?= $form->field($model, 'email')->textInput(['class' => 'form-control']) ?>
    </div>
    <div class="form-group">
        <?= $form->field($model, 'subject')->textInput(['class' => 'form-control']) ?>
    </div>
    <div class="form-group">
        <?= $form->field($model, 'body')->textarea(['rows' => 6, 'class' => 'form-control']) ?>
    </div>
    <?php if ($model->scenario === $model::SCENARIO_GUEST) : ?>
    <div class="form-group">
        <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
            'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
            'captchaAction' => Url::to(['/feed/captcha']),
            'imageOptions' => [
                'style' => 'display:block; border:none; cursor: pointer',
                'alt' => Yii::t('app', 'Code'),
                'title' => Yii::t('app', 'Click on the picture to change the code.'),
            ],
            'class' => 'form-control',
        ]) ?>
    </div>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-send"></span> ' . Yii::t('app', 'Submit'), ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
    </div>
<?php ActiveForm::end(); ?>