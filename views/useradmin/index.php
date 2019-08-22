<?php
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */

$this->title = 'Useradmin';
$backgroundColor = isset($_REQUEST['bckg'])?$_REQUEST['bckg']:'#FFFFFF';
$this->params['background_color'] = $backgroundColor;

?>
<?= $this->context->id ?>
<table id="useradmin" class="table table-condenced table-bordered">
<tr>
<th>Id</th>
<th>Username</th>
<th>Email</th>
<th>Created</th>
<th>Delete</th>
</tr>
<?php foreach($userList as $item) { ?>
<tr>
<td><?php echo $item['id'] ?></td>
<td><?php echo $item['username'] ?></td>
<td><?php echo $item['email'] ?></td>
<td><?php echo Yii::$app->formatter->asDatetime($item['created_at'], "php:d/m/Y"); ?></td>
<td><?= Html::a( "Delete ",['useradmin/delete','id'=>$item['id']]) ?> </td>
</tr>
<?php } ?>
</table>

