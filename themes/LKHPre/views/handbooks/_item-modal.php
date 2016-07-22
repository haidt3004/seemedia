<!-- Modal -->
<div class="modal fade" id="myModal-<?php echo $index + 1; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<h4><?php echo $data->title; ?></h4>
				<?php if (strlen($data->short_content) > 0) { ?>
					<iframe src="<?php echo $data->short_content; ?>/preview" width="100%" height="650" frameborder="0"></iframe>
				<?php } ?>
			</div>

		</div>
	</div>
</div>
