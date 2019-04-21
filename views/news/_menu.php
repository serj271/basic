<?php 
use yii\widgets\Breadcrumbs;
?>
<div>
<?php 
echo Breadcrumbs::widget([
    'itemTemplate' => "<li><i>{link}</i></li>\n", // template for all links
    'links' => [
        [
            'label' => 'List news',
            'url' => ['news/items-list'],//parameter  'id' => 10
            'template' => "<li><b>{link}</b></li>\n", // template for this link only
        ],
        ['label' => 'Static info', 'url' => ['news/pages', 'view' => 'info']],
		['label' => 'adv block', 'url' => ['news/adv-test']],
        'Edit',
    ],
]);
 ?>
</div>
