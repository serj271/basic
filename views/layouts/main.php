<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\web\View;

AppAsset::register($this);
//$this->registerCssFile("@web/css/test.css", [
//    'depends' => [\yii\bootstrap\BootstrapAsset::className()],
//    'media' => 'print',
//], 'css-print-theme');//View: : POS _ HEAD

$this->registerJsFile(
    '@web/js/test.js',
	 ['position' => \yii\web\View::POS_END]
#    ['depends' => [\yii\web\JqueryAsset::className()]]
);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
	<?= Html::cssFile('@web/css/site2.css'); ?>
</head>
<?php
$backgroundColor = isset($this->params['background_color'])?$this->params['background_color']:'#FFFFFF'; ?>
<body style="background-color:<?php echo $backgroundColor; ?>" >

<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'About', 'url' => ['/site/about']],
            ['label' => 'Cont', 'url' => ['/site/contact']],
            ['label' => 'Signup', 'url' => ['/site/signup']],
            ['label' => 'User cr', 'url' => ['/useradmin/create']],
            ['label' => 'Adm', 'url' => ['/useradmin']],
            ['label' => 'Auth ad', 'url' => ['/authorization-manager']],
			['label' => 'News', 'url' => ['/news/index']],
			['label' => 'Comment', 'url' => ['/comment/index']],
			['label' => 'Cust', 'url' => ['/customer/grid']],
			['label' => 'Photo', 'url' => ['/product-photo/index']],
			['label' => 'Picker', 'url' =>['/jui-widgets/date-picker']],
			['label' => 'Mult', 'url' =>['/customers/create-multiple-models']],
			['label' => 'Category', 'url' =>['/categories/']],
			['label' => 'Product admin', 'url' =>['/product-admin/']],
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
		<div class="well">
			This is content for blockADV from view
			<br />
			<?php if(isset($this->blocks['blockADV'])) { ?>
			<?php echo $this->blocks['blockADV']; ?>
			<?php } else { ?>
			<i>No content available</i>
			<?php } ?>
		</div>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company 33<?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
