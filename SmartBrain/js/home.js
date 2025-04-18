const base_url = window.location.origin + "/Satu/Dashboard/";

function loadData() {
	$.ajax({
		url: base_url + "show_apk",
		type: "POST",
		dataType: "json",
		success: function (res) {
			$("#list-app").html(res.data);
		},
	});
}

$(function () {
	loadData();
});
