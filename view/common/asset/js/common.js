/* 元素为空 */
function isEmptyElem(data) {
	return data.length === 0
}

/* 数据为空 */
function isEmptyData(data) {
	return data === "" || data === null || data === undefined || data.length === 0
}

/* 弹出层-IFRAME */
function iframe(title, content, callback, area = ["800px", "600px"]) {
	layui.use(["layer"], function() {
		let layer = layui.layer
		layer.open({
			type: 2,
			area: area,
			title: title,
			content: content,
			btn: ["确认", "取消"],
			shadeClose: true,
			maxmin: true,
			id: "iframe",
			resize: false,
			scrollbar: false,
			yes: callback
		})
	})
}

/* 弹出层-MESSAGE */
function message(content, icon = -1, time = 1000) {
	layui.use(["layer"], function() {
		let layer = layui.layer
		layer.msg(content, {
			icon: icon,
			time: time
		})
	})
}

/* 修改选中 */
function selectAll(_this) {
	$("[name='id']").prop("checked", $(_this).prop("checked"))
}

/* 修改排序 */
function executeSort(_this, id, url) {
	let params = {
		id: id,
		sort: $(_this).val()
	}
	$.get(url, params, function(data) {
		if (data === true) {
			location.reload()
		}
	})
}

/* 修改状态 */
function executeStatus(status, id, url, message) {
	if (confirm(message)) {
		let params = {
			id: id,
			status: status
		}
		$.get(url, params, function(data) {
			if (data === true) {
				location.reload()
			}
		})
	}
}

/* 删除 */
function executeDestroy(id, url, message) {
	if (confirm(message)) {
		let params = {
			id: id
		}
		$.get(url, params, function(data) {
			if (data === true) {
				location.reload()
			}
		})
	}
}

/* 删除选中 */
function deleteAll(url, message) {
	if (confirm(message)) {
		let params = {
			ids: $.map($("[name='id']:checked"), function(value, index) {
				return $(value).val()
			})
		}
		$.get(url, params, function(data) {
			if (data === true) {
				location.reload()
			}
		})
	}
}

function laydate(options) {
	layui.use(["laydate"], function() {
		let laydate = layui.laydate
		laydate.render(options)
	})
}
