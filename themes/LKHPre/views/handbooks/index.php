<div class="mainchild">
	<div class="wrapper clearfix fullwidth">
		<!-- Documentation banner -->
		<?php $this->widget('BannerWidget',array('group_banner_id' => POLICY_ORG_CHART_BANNER,'layout' => 'inner_page_banner')); ?>
		<!-- End Documentation banner -->

		<div class="maincontent">
			<div class="t-header-org">
				Policy & Org_chart
			</div>

			<div class="group-handbook clearfix">

				<div class="side-left">

					<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingOne">
								<h4 class="panel-title">
									<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
										<i class="fa fa-minus-circle"></i>  Policy
									</a>
								</h4>
							</div>
							<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
								<div class="panel-body">
									<div class="content_tab">
										<ul>
											<?php foreach ($policyModels as $policyModel) : ?>
												<li class="list-news-item itemdowload">
													<a class="title handbook-modal" data-toggle="modal"
													   data-target="#myModal-policy-<?php echo $policyModel->id ?>"
													   link-ember="<?php echo $policyModel->short_content . '/preview'; ?>"
													   title="<?php echo $policyModel->title ?>"
													   rel="policy-<?php echo $policyModel->id ?>"><?php echo $policyModel->title ?></a>
												</li>
											<?php endforeach; ?>
										</ul>
									</div>

								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingTwo">
								<h4 class="panel-title">
									<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
										<i class="fa fa-minus-circle"></i> Orgnisation Chart
									</a>
								</h4>
							</div>
							<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
								<div class="panel-body">
									<div class="content_tab">
										<ul>
											<?php foreach ($orgChartModels as $orgChartModel) : ?>
												<li class="list-news-item itemdowload">
													<a class="title handbook-modal" data-toggle="modal"
													   data-target="#myModal-org-chart-<?php echo $orgChartModel->id ?>"
													   link-ember="<?php echo $orgChartModel->short_content . '/preview'; ?>"
													   title="<?php echo $orgChartModel->title ?>"
													   rel="org-chart-<?php echo $orgChartModel->id ?>"><?php echo $orgChartModel->title ?></a>
												</li>
											<?php endforeach; ?>
										</ul>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
				<div class="side-right">
					<div class="content-list-default document">
						Chart showing the structure of the organisation and employees reporting line.
						<h4>Policy</h4>
						<ul>
							<?php foreach ($policyModels as $policyModel) : ?>
								<li><?php echo $policyModel->title ?></li>
							<?php endforeach; ?>
						</ul>
						<h4>Orgnisation Chart</h4>
						<ul>
							<?php foreach ($orgChartModels as $orgChartModel) : ?>
								<li><?php echo $orgChartModel->title ?></li>
							<?php endforeach; ?>
						</ul>
					</div>
					<?php foreach ($policyModels as $policyModel) : ?>
						<div class="content-list document" id="list-policy-<?php echo $policyModel->id ?>">
							<h4><?php echo $policyModel->title ?></h4>
							<p><?php echo $policyModel->content ?></p>
						</div>
					<?php endforeach; ?>

					<?php foreach ($orgChartModels as $orgChartModel) : ?>
						<div class="content-list document" id="list-org-chart-<?php echo $orgChartModel->id ?>">
							<h4><?php echo $orgChartModel->title ?></h4>
							<p><?php echo $orgChartModel->content ?></p>
						</div>
					<?php endforeach; ?>
				</div>

			</div>

		</div>
	</div><!-- //wrapper -->
</div>

<!-- Modal -->
<div class="modal fade" id="myModal-handbook" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<h4></h4>
				<iframe src="" width="100%" height="650" frameborder="0"></iframe>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		$('.handbook-modal').on("click", function(e) {
			var link = $(this).attr('link-ember');
			var title = $(this).attr('title');
			$('#myModal-handbook .modal-body h4').text(title);
			$('#myModal-handbook .modal-body iframe').attr('src',link);
			$('#myModal-handbook').modal('show')
		});

		$('#myModal-handbook').on('hidden.bs.modal', function (e) {
			$('#myModal-handbook .modal-body h4').text('');
			$('#myModal-handbook .modal-body iframe').attr('src', '');
		})
	});
</script>
