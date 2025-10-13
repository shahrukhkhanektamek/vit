// function formatState(e) {
// 	return e.id ? $('<span><img src="assets/images/flags/select2/' + e.element.value.toLowerCase() + '.png" class="img-flag rounded" height="18" /> ' + e.text + "</span>") : e.text
// }

// function formatState(e) {
// 	var t;
// 	return e.id ? ((t = $('<span><img class="img-flag rounded" height="18" /> <span></span></span>')).find("span").text(e.text), t.find("img").attr("src", "assets/images/flags/select2/" + e.element.value.toLowerCase() + ".png"), t) : e.text
// }
$(document).ready(function() {
	$(".js-example-basic-single").select2(), 
    $(".js-example-basic-multiple").select2({
        closeOnSelect: false,
        // placeholder: "Placeholder",
        allowHtml: true,
        allowClear: true,
        tags: true,
        minimumResultsForSearch: -1,
    });
});
// $(".js-example-templating").select2({
// 	templateResult: formatState
// }), $(".select-flag-templating").select2({
// 	templateSelection: formatState
// }), $(".js-example-disabled").select2(), $(".js-example-disabled-multi").select2(), $(".js-programmatic-enable").on("click", function() {
// 	$(".js-example-disabled").prop("disabled", !1), $(".js-example-disabled-multi").prop("disabled", !1)
// }), $(".js-programmatic-disable").on("click", function() {
// 	$(".js-example-disabled").prop("disabled", !0), $(".js-example-disabled-multi").prop("disabled", !0)
// });