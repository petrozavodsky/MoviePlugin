var $ = jQuery.noConflict();

var MoviePlugin_movies_banners_admin = {
    run: function () {

        this.add_upload_event();
    },
    add_upload_event: function () {
        $("[data-mbd]").on('click', function (e) {
            e.preventDefault();
            var elem = $(this);

            var uploader = wp.media.editor.send.attachment;
            wp.media.editor.send.attachment = function (props, attachment) {
                var image_id = attachment.id;
                var image = "<img src='"+attachment.url+"'>";
                var item_wrap = elem.closest('.banner__input-wrap');
                item_wrap.find('.banner__image-wrap').html( image );
                item_wrap.find('input').val(image_id);
                wp.media.editor.send.attachment = uploader;
            };
            wp.media.editor.open();
            return false;


        });


    }

};

$(document).ready(function () {
    MoviePlugin_movies_banners_admin.run();
});
