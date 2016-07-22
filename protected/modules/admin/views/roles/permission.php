<?php
$this->breadcrumbs=array(
    "Manage Roles"=>array('roles/index'),
    'Setting Privilege Role',
);
?>

<h1>Setting Privilege Role: <?php echo $model->role_name ?></h1>
<?php 
    $this->renderNotifyMessage(); 
?>
<form method="post" >

<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <?php foreach($allController as $keyController=>$aController): ?>
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingOne">
            <h4 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-<?php echo $aController->id ?>" aria-expanded="true" aria-controls="collapseOne">
                <?php echo $aController->controller_name; ?>
            </a>
            </h4>
        </div>
        <div id="collapse-<?php echo $aController->id ?>" class="panel-collapse collapse in tab-action" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">
                <div class="col-md-12">
                   <p style="border-bottom:1px solid #eeeeee;">
                        <button type="button" id="checkAll" class="checkAll btn btn-default btn-xs btn-primary"> Check All</button>            
                        <button type="button" class="uncheckAll btn btn-default btn-xs btn-primary">UnCheck All</button>    
                     </p>                  
                </div>
                <div class="clearfix"></div>
                <?php $arrCheck  = isset($arrActionChecked[$aController->id]) ?  $arrActionChecked[$aController->id] : array();  ?>    
                <?php  echo $aController->BuildListActionAllow($arrCheck);?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>  

</div>

<div class="col-md-12">
    <button type="submit" class=" btn btn-default btn-primary">Save</button>            
</div>


</form>
<script type="text/javascript">
$(".checkAll").click(function () {
    var idTab  = $(this).closest('.tab-action').attr('id');
    var input  = '#'+idTab+' input:checkbox';
    $(input).prop('checked',true);
});
$(".uncheckAll").click(function () {
    var idTab  = $(this).closest('.tab-action').attr('id');
    var input  = '#'+idTab+' input:checkbox';
    $(input).prop('checked',false);
});
</script>