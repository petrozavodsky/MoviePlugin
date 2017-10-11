var $ = jQuery.noConflict();


var meta_box_date_picker = {
    run: function () {
        this.date_picker()
    },

    date_picker: function () {
        jQuery('.example-datepicker').datepicker();

        $(".move-date-picker").datepicker({
            dateFormat: "yy-mm-dd"
        });
    }

};

$(document).ready(function () {
    meta_box_date_picker.run();
});
