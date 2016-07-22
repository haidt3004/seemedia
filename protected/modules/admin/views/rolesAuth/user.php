<?php
$this->breadcrumbs=array(
    "Manage Roles"=>array('roles/index'),
    'Setting Privilege User',
);
?>

<h1>Setting Privilege User: <?php echo " $mUser->username - ".$mUser->first_name ?></h1>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'spa-roles-auth',
	'enableAjaxValidation'=>false,
)); ?>
    
<?php $this->renderNotifyMessage(); ?>   
<div class="clr"></div>

<div class="form form_fix_submit">
    <div class="row" style="padding-left: 50px;">
        <label class="lbchkAllow" for="chkAllow">Allow All</label>
        <input  id="chkAllow" type="checkbox" name="chkAllow" class="chkAllowDeny" rel="allow" style="float:left;">
    </div>
    <div class="clr"></div>
    <div class="row display_none" style="padding-left: 50px;">
        <label class="" for="chkCollapse">Collapse All</label>
        <input  id="chkCollapse" type="checkbox" name="chkCollapse" class="chkCollapse" style="float:left;">
        
    </div>
    <div class="clr"></div>

    <div class="row buttons" style="padding-left: 250px;">
        <?php echo CHtml::submitButton("Save", array('name'=>'submit', 'class'=>'btn btn-primary')); ?>
        <a class="btn_cancel display_none" onclick="confirmResetPermission(this); return false;" href="<?php echo Yii::app()->createAbsoluteUrl('admin/rolesAuth/resetRoleCustomOfUser', array('id'=>$_GET['id'])) ;?>">Reset all privilege of this user</a> 
        <!--<a class="" href="<?php echo Yii::app()->createAbsoluteUrl('admin/roles/index') ;?>">Cancel</a>-->
    </div>    
</div>
<div id="accordion">
    <?php foreach($this->aControllers as $keyController=>$aController): ?>
    
    <div class="block_privilege">
        <h3><a class="l_margin_20 item_b" href="#"><?php echo $aController['alias'] ?></a></h3>
        <?php
            $mController = Controllers::getByName($keyController);
            $aActionsAllowGroup = ActionsRoles::getActionArrayByRoleIdAndControllerId($mUser->role_id, $mController->id);
            $aActionsAllowUser = ActionsUsers::getActionArrayByUserIdAndControllerId($id, $mController->id);
            $mActionsUsers = ActionsUsers::model()->findAll('user_id='.$id.' AND controller_id='.$mController->id);
            
        ?>
        <div class="wrap_privilege">
            <!--<h2><?php echo $aController['alias'] ?></h2>-->
            <a href="javascript:void(0)" class="checkAll item_b">Select All</a> | <a href="javascript:void(0)" class="clearAll item_b">Deselect All</a><br><br>
            <ul class="permission-list">
                <?php foreach($aController['actions'] as $keyAction=>$aAction): ?>
                <?php $classCheck = ''; ?>
                <li><input type="checkbox" name="<?php echo $keyController.'['.$keyAction.']' ?>" value="1" id="<?php echo $keyController.'_'.$keyAction ?>" <?php if(in_array($keyAction, $aActionsAllowUser) || ($mActionsUsers==NULL && in_array($keyAction, $aActionsAllowGroup))) {echo 'checked="checked"'; $classCheck = 'hight_light_background';} ?>>
                    <label class="<?php echo $classCheck;?>" for="<?php echo $keyController.'_'.$keyAction ?>"><?php echo $aAction['alias'] ?></label>
                </li>
                <?php endforeach; ?>
            </ul>            
        </div> <!-- end wrap_privilege-->
    </div> <!-- end block_privilege-->
    <div class="clr"></div>
    <?php endforeach; ?>
</div>

<div class="form form_fix_submit">
    <div class="row buttons" style="padding-left: 250px; padding-top: 20px;">
        <?php echo CHtml::submitButton("Save", array('name'=>'submit', 'class'=>'btn btn-primary')); ?>
    </div>    
</div>
<?php $this->endWidget(); ?>          

<?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>
 <style>
.ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active { background:  #E5F1F4;}
.ui-widget-content{border: none;}
.block_privilege ul{list-style: none; padding:0; margin: 0;}
.block_privilege h2 { font-size: 14px;}
.permission-list li { width: 500px !important; float: left;}
.permission-list li label { float: left; margin-left: 5px; width: 470px;}
.permission-list li input { float: left;}
.wrap_privilege { border: 1px solid #AAAAAA;}

.item_b { font-weight: bold; }
.l_margin_20 { margin-left: 20px !important; }

</style>
 <script>
$(function() {
    $("#accordion > div").accordion({ header: "h3", collapsible: true });
    $('.checkAll').click(function(){

        $(this).parent().children('.permission-list').find('li').each(function(){
            $(this).find('input').prop('checked', true);
        });
    });

    $('.clearAll').click(function(){
        $(this).parent().children('.permission-list').find('li').each(function(){
            $(this).find('input').prop('checked', false);
        });
    });

    // ANH DUNG - May 12, 2014
    $('.chkAllowDeny').click(function(){
        if($(this).is(':checked'))
            $('#accordion').find('input:checkbox').attr('checked',true);
        else
            $('#accordion').find('input:checkbox').attr('checked',false);            
    });
    
    $('.chkCollapse').click(function(){
        $('#accordion h3').trigger('click');
    });
    // ANH DUNG// ANH DUNG - May 12, 2014

    $('.form').find('input:submit').click(function(){
//        $.blockUI({ overlayCSS: { backgroundColor: 'fff' } }); 
        $.blockUI({ message: null });
    });

});


function confirmResetPermission(obj)
{
    var r = confirm("Bạn có chắc muốn thiết lập lại tất cả quyền của nhân viên này?");
    if (r == true) {
        window.location=  obj.attr('href');
    } else {
        return false;
    }
}

</script>
