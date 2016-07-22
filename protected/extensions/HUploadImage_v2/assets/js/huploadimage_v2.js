/**
 * @author Haidt <haidt3004@gmail.com>
 * @version 2: huploadimage_v2.js  2015-04-20 23:00:22
 */

var hupload = {};
hupload.v2 = {
	setAsMainImage: function (that) {
//		if (confirm('Do you want to set this image as main?')) {
			var params = {};
			params.blockUI = true;				
			var update = that.attr('data-update');
			params.that = that;
			params.url = that.attr('data-action');
			params.data = {
				id: that.attr('data-id'),
				model: that.attr('data-model'),
				parent_id: that.attr('data-parentid'),
				parent_field: that.attr('data-parentfield'),
				update_field: that.attr('data-updatefield'),
				actionType: 'set_main_image'};
			var promise = hupload.v2.requestH(params);
			promise.done(function (results) {
				hupload.v2.doUnBlockUI(params);
				hupload.v2.hideLoading(params);
				if (results.status) {
					$.fn.yiiListView.update(update);
					return false;
				}
			});
//		}
	},
	deleteHImage: function (that) {
		if (confirm('Do you want to delete this image?')) {
			var params = {};
			params.blockUI = true;
			var update = that.attr('data-update');
			params.loadingClass = that.attr('data-loading');
			params.that = that;
			params.url = that.attr('data-action');
			params.data = {
				id: that.attr('data-id'),
				model: that.attr('data-model'),
				actionType: 'delete'
			};
			var promise = hupload.v2.requestH(params);
			promise.done(function (results) {
				hupload.v2.doUnBlockUI(params);
				hupload.v2.hideLoading(params);
				if (results.status) {
					$.fn.yiiListView.update(update);
					return false;
				}
			});
		}
	},
//setup for using ajax request
	requestH: function (params) {
		var promise = $.ajax({
			url: params.url,
			type: 'POST',
			dataType: 'json',
			data: params.data,
			cache: false,
			beforeSend: function () {
				hupload.v2.doBlockUI(params);
				hupload.v2.displayLoading(params);
			}
		});
		return promise;
	},
	/** Haidt
	 * add an image action
	 */
	addImageH: function (that) {
//		if (confirm('Do you want to upload seleted images?')) {
			var params = {};
			params.blockUI = true;
			var form_id = that.attr('data-formid');
			var data = new FormData($("#" + form_id)[0]);
			var target = that.attr('data-target');
			var update = that.attr('data-update');
			params.url = that.attr('data-action');
			params.that = that;
			data.append("activeModel", that.attr('data-model'));
			data.append("actionUrl", params.url);
			params.data = data;
			params.action = 'add';
			var promise = hupload.v2.requestFormDataH(params);
			promise.done(function (results) {
				hupload.v2.doUnBlockUI(params);
				hupload.v2.hideLoading(params);
				hupload.v2.hideErrors(target);
				if (results.status) {
					$.fn.yiiListView.update(update);
					return false;
				} else {
					hupload.v2.showErrors(target, results.errors);
				}
			});
//		}
	},
//setup for using ajax request to submit a form
	requestFormDataH: function (params) {
		var promise = $.ajax({
			url: params.url,
			type: 'POST',
			dataType: 'json',
			data: params.data,
			cache: false,
			contentType: false,
			processData: false,
			beforeSend: function () {
				hupload.v2.doBlockUI(params);
				hupload.v2.displayLoading(params);
			}
		});
		return promise;
	},
//show error message
	showErrors: function (target, errors) {
		var model = $('#' + target).attr('data-model');
		$.each(errors, function (index, item) {
			var element = "#" + model + '_' + index;
			$('#' + target).find(element).parent().find('.errorMessage').show().text(item[0]);
			$('#' + target).find(element).parent().parent().find('.errorMessage').show().text(item[0]);
		});
	},
//hide error message
	hideErrors: function (target) {
		$('#' + target).find('.errorMessage').hide().text('');
	},
//sortable item
	hSortable: function (id, form_id, actionUrl, model) {
		$("#" + id + " .hupload-sortable").sortable({
			update: function (event, ui) {
				hupload.v2.updateOrder(id);
				hupload.v2.submitImageOrder(actionUrl, model, form_id);
			}
		});
	},
	updateOrder: function (id) {
		$("#" + id + " .hupload-sortable .thumbnail-h").each(function (key, item) {
			$(item).find('.display_order').val(key + 1);
		});
	},
	submitImageOrder: function (actionUrl, model, form_id) {
		var params = {};
		var data = new FormData($("#" + form_id)[0]);
		data.append("activeModel", model);
		data.append("actionType", 'sort');
		data.append("actionUrl", actionUrl);
		params.data = data;
		params.url = actionUrl;
		var promise = hupload.v2.requestFormDataH(params);
		promise.done(function (data) {
			hupload.v2.doUnBlockUI(params);
			hupload.v2.hideLoading(params);
		});
	},
	displayLoading: function (params) {
		$('.' + params.loadingClass).show();
	},
	hideLoading: function (params) {
		$('.' + params.loadingClass).hide();
	},
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
