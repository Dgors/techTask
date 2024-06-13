<?php

/* @var $this \yii\web\View */
/* @var $pos \app\models\ObjectPosition|false|int */
/* @var $reg \app\models\ObjectRegion */

$posVal = $pos::find()->select('object_position_name')->orderBy('id')->asArray()->all();
$regVal = $reg::find()->select('region')->orderBy('id')->asArray()->all();
?>

<div class="filter-container position-relative">
<div class="row">
    <div class="col-md-2"><h4>Должность</h4></div>
    <div class="col-md-2"><h4>Направление</h4></div>
</div>
<div class="row">
    <div class="col-md-2"
    ><?php foreach ($posVal as $id => $pos): ?>
            <div class="form-check form-switch filter-text">
                <label class="form-check-label">
                    <input class="filter form-check-input" value="" type="checkbox" checked="checked" name="pos<?= $id + 1 ?>"><?= $pos['object_position_name'] ?>
                </label>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="col-md-2">
        <?php foreach ($regVal as $id => $reg): ?>
            <div class="form-check form-switch">
                <label class="form-check-label">
                    <input class="filter form-check-input" value="" type="checkbox" checked="checked" name="reg<?= $id + 1 ?>"><?= $reg['region'] ?>
                </label>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</div>





