var $ = jQuery.noConflict();

$(document).ready(function () {
    $.get(WordpressMagicBoilerplate_AjaxOut2__vars.ajax_url_action, function (result) {
        console.log(result);
    });
});