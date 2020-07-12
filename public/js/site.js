function startLoading() {
    if (!$('.loader').length) {
        $('body').append('<div class="loader"></div>');
    }
}

function stopLoading() {
    if ($('.loader').length) {
        $('.loader').fadeToggle(function () {
            $(this).remove();
        });
    }
}