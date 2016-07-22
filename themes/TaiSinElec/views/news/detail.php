<div class="mainchild">
    <div class="wrapper clearfix">
        <div class="colleft">
            <div class="box-last-news">
                <div class="page-header-left">
                    Announcement
                </div>
                <ul class="submenu">
                    <?php for ($index = 0; $index <= 5; $index++) {
                        $current_year = date_format(date_create($model->created_date), "Y");
                        $current_month = date_format(date_create($model->created_date), "n");
                        $year = date("Y") - $index;

                        $validMonth = 12;
                        if ($index == 0) {
                            $validMonth = date("n");
                        }
                        ?>

                        <li class="<?php echo $current_year == $year ? 'active' : ''; ?>">
                            <a href="#"><i class="fa fa-caret-right"></i><?php echo $year; ?></a>
                            <ul>
                                <?php for ($indexMonth = $validMonth; $indexMonth > 0; $indexMonth--) { ?>
                                    <li class="<?php echo ($current_month == $indexMonth && $current_year == $year) ? 'active' : ''; ?>">
                                        <a href="<?php echo yii::app()->createAbsoluteUrl('announcement/archive',array('year' => $year, 'month' => $indexMonth ));?>">
                                            <i class="fa fa-caret-right"></i><?php echo DateTime::createFromFormat('!m', $indexMonth)->format('F') ?>
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
