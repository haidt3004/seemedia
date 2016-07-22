<?php   $model->getDataTranslate();?>


<div class="mainchild">
    <div class="wrapper clearfix">
        <div class="colleft">
            <div class="box-last-news">
                <div class="page-header-left">
                    <?php echo TextMultilangHelper::label('announcement'); ?>
                </div>
                <ul class="submenu">
                    <?php
                    $current_year = date_format(date_create($model->created_date), "Y");
                    $current_month = date_format(date_create($model->created_date), "n");

                    foreach (Announcement::getTimeExist() as $key => $value) { ?>

                        <li class="<?php echo $current_year == $key ? 'active' : ''; ?>">
                            <a href="<?php echo Yii::app()->createAbsoluteUrl('announcements/archive',array('year' => $key ));?>"><i class="fa fa-caret-right"></i><?php echo $key; ?></a>
                            <ul>
                                <?php foreach ($value as $item) { ?>
                                    <li class="<?php echo ($current_month == $item && $current_year == $key) ? 'active' : ''; ?>">
                                        <a href="<?php echo Yii::app()->createAbsoluteUrl('announcements/archive',array('year' => $key, 'month' => $item ));?>">
                                            <i class="fa fa-caret-right"></i><?php echo DateTime::createFromFormat('!m', $item)->format('F') ?>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>

                    <?php } ?>
                </ul>
            </div>

        </div>
        <div class="colright maincontent">
            <div class="t-header">
                <?php echo $model->title; ?>
            </div>
            <div class="document">
                <?php echo $model->content; ?>
            </div>

        </div>

    </div><!-- //wrapper -->
</div>
