$('#library_book_categories').select2({
    tags: true
});

$('.select2 *').on('keydown', function(evt) {
    if (this == evt.target) {
        if (evt.which == 13) {
            console.log('enter');
            var last = $('select#library_book_categories option').val();
            console.log(last);
        }
    }
});