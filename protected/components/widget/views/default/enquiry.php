<h2>Enquire Now</h2>
<?php if (Yii::app()->user->hasFlash('msg')) : ?>
            <div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <?php echo Yii::app()->user->getFlash('msg'); ?>
            </div>
        <?php endif; ?>
<?php $form=$this->beginWidget('CActiveForm', array(
    'htmlOptions'=>array('class'=>'form-type'),
)); ?>
    <div class="row">
        <div class="col-sm-6">
            <div class="in-row clearfix">
                <?php echo $form->labelEx($model,'name', array('class' => 'lb')); ?>
		<div class="group">
                    <?php echo $form->textField($model,'name', array('class' => 'form-control')); ?>
                    <?php echo $form->error($model,'name'); ?>
                </div>
            </div>
            <div class="in-row clearfix">
                <?php echo $form->labelEx($model,'email', array('class' => 'lb')); ?>
		<div class="group">
                    <?php echo $form->textField($model,'email', array('class' => 'form-control')); ?>
                    <?php echo $form->error($model,'email'); ?>
                </div>
            </div>
            <div class="in-row clearfix">
                <?php echo $form->labelEx($model,'phone', array('class' => 'lb')); ?>
		<div class="group">
                    <?php echo $form->textField($model,'phone', array('class' => 'form-control')); ?>
                    <?php echo $form->error($model,'phone'); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <?php
//             echo "<pre>";
//             print_r($segments = Office::segmentModel(1));
//             echo "</pre>";
//             die;
            ?>
            <div class="in-row clearfix">
                <?php echo $form->labelEx($model,'country', array('class' => 'lb')); ?>
                <div class="group">
                    <?php echo $form->dropDownList($model,'country', Country::loadItems(1), array('class' => 'selectpicker')); ?>
                    <?php echo $form->error($model,'country'); ?>
                    <?php $countries = Country::model()->findAll("status = " . STATUS_ACTIVE); ?>
                    <?php if (!empty($countries)): ?>
                        
                        <?php // foreach ($countries as $country): ?>
                            <div class="row check-list" id="of-country-<?php // echo $country->id?>">
                                <?php $segments = Office::segmentModel($country->id) ?>
                                <?php if (!empty($segments)): ?>
                                    <?php foreach ($segments as $key => $offices): ?>
                                        <div class="col-xs-6">
                                            <ul>
                                                <?php if (!empty($offices)): ?>
                                                    <?php
                                                    echo $form->checkBoxList(
                                                        $model, 'offices', CHtml::listData($offices, 'id', 'name'), array(
                                                            'container' => '',
                                                            'separator' => '',
                                                            'template' => '<li class="checkbox">{input}{label}</li>',
                                                            'uncheckValue' => null,
                                                            'baseID' => "ContactForm_offices_{$country->id}_$key",
                                                    ));
                                                    ?>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        <?php // endforeach; ?>
                    <?php endif; ?>
                    <?php echo $form->error($model, 'offices'); ?>
                    
                </div>
            </div>                                   
            <div class="output">
                <button type="submit" class="btn-1">Submit</button>
            </div>
        </div>
    </div>
<?php $this->endWidget(); ?>
<script>
    $(document).ready(function(){
        //
//        var country_id = $('#ContactForm_country').val();
//        $('.check-list').hide();
//        $('#of-country-' + country_id).show();
//        $("#ContactForm_country").change(function() {
//            var country_id = $(this).val();
//            $('.check-list').hide();
//            $('#of-country-' + country_id).show();
//        });
        //
    });
</script>
