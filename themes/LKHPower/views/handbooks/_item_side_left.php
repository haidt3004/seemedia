<div class="list-news-item itemdowload">
    <a class="title" rel="<?php echo $index + 1; ?>" href="<?php echo $data->short_content; ?>"
       data-toggle="modal" data-target="#myModal-<?php echo $index + 1; ?>" >
        <?php echo $data->title; ?>
    </a>
    <p class="learn-more"><a target="_blank" href="<?php echo Yii::app()->createAbsoluteUrl('documentation/detail', array('slug' => $data->slug)); ?>">Read More</a></p>
</div>