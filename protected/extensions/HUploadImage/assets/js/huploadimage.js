$(function () {
	//todo
});

/**
 * @author Haidt <haidt3004@gmail.com>
 * @version $Id: huploadimage.js  2015-04-20 23:00:22
 * @since 1.1
 */
function deleteHImage(that, id, model, elementId) {
	if (confirm('Do you want to delete this image?')) {
		var params = {};
		params.that = that;
		params.url = that.attr('data-action');
		params.data = {id: id, model: model, actionType: 'delete'};
		var promise = requestH(params);
		promise.done(function (results) {
			params.that.parent().parent().parent().parent().find('.loading').hide();
			if (results.status) {
				$('#' + elementId).remove();
			}
		});
	}
}

//setup for using ajax request
function requestH(params) {
	var promise = $.ajax({
		url: params.url,
		type: 'POST',
		dataType: 'json',
		data: params.data,
		cache: false,
		beforeSend: function () {
			params.that.parent().parent().parent().parent().find('.loading').show();
		}
	});
	return promise;
}

/** Haidt
 * add an image action
 */
function addImageH(that, form_id, target, model) {
	var params = {};
	var data = new FormData($("#" + form_id)[0]);
	params.url = that.attr('data-action');
	params.that = that;
	data.append("activeModel", model);
	data.append("actionUrl", params.url);
	params.data = data;
	params.action = 'add';
	var promise = requestFormDataH(params);
	promise.done(function (results) {
		that.parent().find('.loading').hide();
		params.that.attr('disabled', false);
		hideErrors(target);
		
		if (results.status) {
			$('#image-item-' + target).html(results.data);
		} else {
			showErrors(target, results.errors);
		}
	});
}

//setup for using ajax request to submit a form
function requestFormDataH(params) {
	var promise = $.ajax({
		url: params.url,
		type: 'POST',
		dataType: 'json',
		data: params.data,
		cache: false,
		contentType: false,
		processData: false,
		beforeSend: function () {
			if (params.action == 'add') {
				displayLoading(params);
			}
		}
	});
	return promise;
}

//show error message
function showErrors(target, errors) {
	var model = $('#' + target).attr('data-model');
	console.log(target);
	$.each(errors, function (index, item) {
		var element = "#" + model + '_' + index;
		$('#' + target).find(element).parent().find('.errorMessage').show().text(item[0]);
		$('#' + target).find(element).parent().parent().find('.errorMessage').show().text(item[0]);
	});
}

//hide error message
function hideErrors(target) {
	$('#' + target).find('.errorMessage').hide().text('');
}

//sortable item
function hSortable(id,form_id, actionUrl, model) {
	$("#" + id + " .hupload-sortable").sortable({
		update: function (event, ui) {
			updateOrder(id);
			submitImageOrder(actionUrl, model, form_id );
		}
	});
}

function updateOrder(id) {
	$("#" + id + " .hupload-sortable .thumbnail-h").each(function (key, item) {
		$(item).find('.display_order').val(key + 1);
	});
}

function submitImageOrder(actionUrl, model, form_id) {
	var params = {};
	var data = new FormData($("#" + form_id)[0]);
	data.append("activeModel", model);
	data.append("actionType", 'sort');
	data.append("actionUrl", actionUrl);
	params.data = data;
	params.url = actionUrl;
	var promise = requestFormDataH(params);
	promise.done(function (data) {
		$('.loading').hide();
	});
}

function displayLoading(params) {
	params.that.parent().find('.loading').show();
	params.that.attr('disabled', true);
}