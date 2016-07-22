<div id="book-tour" class="modal fade popup">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <?php 
                $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'booking-tour-form',
                        'action' => Yii::app()->createAbsoluteUrl('site/BookingTour'),
//                        'enableClientValidation' => true,
                        'enableAjaxValidation' => true,
                        'clientOptions' => array(
                                'validateOnSubmit' => true,
                        ),
                )); ?>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/img/ico-close.png" alt="close" /></button>
                <h3>Book a Tour</h3>
                <?php echo $form->textField($model,'name',array('class' => 'form-control')); ?>
                <?php echo $form->error($model, 'name'); ?>
                <?php echo $form->textField($model,'company_name',array('class' => 'form-control')); ?>
                <?php echo $form->error($model, 'company_name'); ?>
                <?php echo $form->textField($model,'phone',array('class' => 'form-control')); ?>
                <?php echo $form->error($model, 'phone'); ?>
                <?php echo $form->textField($model,'email',array('class' => 'form-control')); ?>
                <?php echo $form->error($model, 'email'); ?>
                <div class="select-type">
                    <?php echo $form->dropDownList($model, 'centre_id', CHtml::listData(Centres::model()->getListData(), 'id', 'name'), array('empty' => 'Choose a location')); ?>
                </div>
                <?php echo $form->textField($model,'date',array('class' => 'form-control custome_datetimepicker', 'placeholder' => 'dd/mm/yyyy')); ?>
                <div class="select-type">
                    <select>
                        <option value="Start time*">Start time</option>
                        <option value="9:00am">9:00am</option>
                        <option value="9:30am">9:30am</option>
                        <option value="10:00am">10:00am</option>
                        <option value="10:30am">10:30am</option>
                        <option value="11:00am">11:00am</option>
                        <option value="11:30am">11:30am</option>
                        <option value="12:00pm">12:00pm</option>
                        <option value="12:30pm">12:30pm</option>
                        <option value="1:00pm">1:00pm</option>
                        <option value="1:30pm">1:30pm</option>
                        <option value="2:00pm">2:00pm</option>
                        <option value="2:30pm">2:30pm</option>
                        <option value="3:00pm">3:00pm</option>
                        <option value="3:30pm">3:30pm</option>
                        <option value="4:00pm">4:00pm</option>
                        <option value="4:30pm">4:30pm</option>
                        <option value="5:00pm">5:00pm</option>
                        <option value="5:30pm">5:30pm</option>
                    </select>
                </div>
                <?php echo $form->textArea($model,'additional_info',array('class' => 'form-control', 'cols' => 30, 'rows' => 3)); ?>
                <?php if (CCaptcha::checkRequirements()) : ?>
                    <div class="captcha-wrap">
                        <?php echo $form->labelEx($model,'captcha_code', array('class' => 'lb')); ?>
                        <div class="group">
                                <?php
                                $this->widget('application.extensions.recaptcha.EReCaptcha', array(
                                    'model' => $model, 
                                    'attribute' => 'captcha_code',
                                    'language' => 'en',
                                    'publicKey' => Yii::app()->params['reCaptcha']['publicKey']));
                                ?>
                                <?php echo $form->error($model, 'captcha_code'); ?>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="output clearfix">
                    <button type="submit" class="btn-1">Submit</button>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->   
<script>
    $(document).ready(function() {
        $('.custome_datetimepicker').datetimepicker({format: 'DD/MM/YYYY'});
    });
</script>