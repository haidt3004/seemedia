//haidt - ajax request function
var req = {
	request: function (params) {
		var promise = $.ajax({
			url: params.url,
			type: 'POST',
			dataType: 'json',
			data: params.data,
			cache: false,
			beforeSend: function () {
				ui.doBlockUI(params);
				if (params.loadding) {
					params.loadding.show();
				}
			}
		});
		return promise;
	},
	//for submit file by ajax
	requestData: function (params) {
		var promise = $.ajax({
			url: params.url,
			type: 'POST',
			dataType: 'json',
			data: params.data,
			cache: false,
			processData: false, // Don't process the files
			contentType: false, // Set content type to false as jQuery will tell the server its a query string request
			beforeSend: function () {
				ui.doBlockUI(params);
				if (params.loadding) {
					params.loadding.show();
				}
			}
		});
		return promise;
	}
};

// haidt - ui block
var ui = {
	doBlockUI: function (params) {
		if (params.blockUI) {
			$.blockUI({message: null});
		}
	},
	doUnBlockUI: function (params) {
		if (params.blockUI) {
			$.unblockUI();
		}
	}
};