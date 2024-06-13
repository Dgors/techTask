<?php

/* @var $pos \app\models\ObjectPosition */
/* @var $reg \app\models\ObjectRegion */
/* @var $objects \app\models\Objects */
/* @var $this \yii\web\View */
/* @var $objReg \app\models\ObjectObjectRegion */
/* @var $objPos \app\models\ObjectObjectPosition */





use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$this->title = 'Map';

//Добавление объектов на карту из БД
$markersArr = array();

$query = $objects::find()->with('objectPositions')
        ->with('objectRegions')->asArray()->limit(100)->all();

foreach($query as $row) {
    $x_pos = $row['x_position'];
    $y_pos = $row['y_position'];
    $obj_name = $row['name'];
    $obj_pos = $row['objectPositions'];
    $obj_reg = $row['objectRegions'];
    $markersArr[] = ['x_pos' => $x_pos, 'y_pos' => $y_pos,
                    'obj_pos' => $obj_pos['object_position_name'], 'obj_reg' => $obj_reg['region'],
                    'obj_name' => $obj_name, 'id_pos' => $obj_pos['id'], 'id_reg' => $obj_reg['id']];
}
    $toJS = json_encode($markersArr);

    $this->registerJs("
    console.log('hello');
    const arr = {$toJS};
    window.onload = async () => {
        arr.forEach(function(markerInfo) {
            let elem = new new_Marker([markerInfo.x_pos, markerInfo.y_pos],
                    markerInfo.obj_name, markerInfo.obj_pos, markerInfo.obj_reg, markerInfo.id_reg, markerInfo.id_pos);
    });
    };
    import('../web/js/Filter.js')");
?>

<?php $form = ActiveForm::begin([
    'id' => 'marker-form',
    'options' => ['class' => 'form-horizontal']]);
 ?>
<div class="row">
    <div class="col-12">
        <?= $form->field($objects, 'name')->label('Имя объекта') ?>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <?= $form->field($objects, 'x_position')->label('Широта') ?>
    </div>
    <div class="col-6">
        <?= $form->field($objects, 'y_position')->label('Долгота') ?>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <?= $form->field($objPos, 'object_position_id')
        ->dropDownList($pos::find()->select(['object_position_name'])
        ->indexBy('id')->column(), ['prompt' => 'Выберите должность объекта'])
        ->label('Должность объекта') ?>
    </div>
    <div class="col-6">
        <?= $form->field($objReg, 'object_region_id')
            ->dropDownList($reg::find()->select(['region'])
                ->indexBy('id')->column(), ['prompt' => 'Выберите регион объекта'])
            ->label('Регион объекта') ?>
    </div>
</div>
<div class="form-group">
    <div class="col-lg-offset-1 col-lg-11">
        <?= Html::submitButton('Добавить объект', ['class' => 'btn btn-primary']) ?>
    </div>
</div>
<?php ActiveForm::end() ?>

<h1><?= Html::encode($this->title) ?></h1>
        <div class="map-content">
            <?= $this->render('../components/filter.php', ['pos' => $pos, 'reg' => $reg]) ?>
            <?= $this->render('../components/ymap.php', ['pos' => $pos, 'reg' => $reg]) ?>
        </div>

