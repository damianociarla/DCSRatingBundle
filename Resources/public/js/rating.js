$(function () {
    $(document).on('click', '.dcs-rating-container a', function (event) {
        event.preventDefault();
        var link = $(this);
        $.ajax(link.attr('href'))
            .done(function(data) {
                link.parent('.dcs-rating-container').html(data);
            });
    });
});