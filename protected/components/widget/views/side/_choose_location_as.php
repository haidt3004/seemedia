<div style="display:none;">
	<div id="modalChooseLocation" class="popUpContainer">
		<div class="popUpBg" id="select-location-wrap">
			<h5>Choose 1 or more locations.</h5>
			<div class="location-by-region">
				<h6>By <span class="region_state">State</span></h6>
				<ul class="select-region">
					<?php include '__region.php'; ?>
				</ul>
			</div>

			<div class="location-by-district">
				<h6>By District</h6>
				<div class="border-box">
					<ul class="select-district">
						<?php include '__district.php'; ?>
					</ul>

				</div>

			</div>

			<div class="clear"></div>
			<button type="button" class="reset-location-btn" onClick="listing.onResetLocation();">Reset</button>
			<button type="button" class="select-location-btn" onClick="parent.$.fn.colorbox.close();">Select Location</button>
			
		</div>

	</div>
</div>