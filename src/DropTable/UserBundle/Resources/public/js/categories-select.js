$('#library_book_categories').select2({
    tags: true
});

//$('.select2 *').on('keydown', function(evt) {
//    if (this == evt.target) {
//        if (evt.which == 13) {
//            console.log('enter');
//            var last = $('select#library_book_categories option').val();
//            console.log(last);
//        }
//    }
//});

var $addEditBookForm = $('form#add-edit-book');

$addEditBookForm.submit(function(e) {
    e.preventDefault();

    var $categories = [];
    $('.select2-selection')
        .find('.select2-selection__choice')
        .each(function() {
            $categories.push($(this).attr('title'))
        });
    var $cats = JSON.stringify($categories);
    console.log($cats);

    $.ajax({
        url: Routing.generate('catalog.add_category'),
        type: "post",
        data: $cats
    }).done(function(jqXHR, textStatus){
        console.log(jqXHR);
        console.log(textStatus);
        $addEditBookForm.unbind();
        //$addEditBookForm.submit();
    });

    //$.post(
    //    Routing.generate('catalog.add_category'),
    //    $cats,
    //    function(data) {
    //        console.log(data);
    //        $addEditBookForm.submit();
    //    }
    //);
    console.log('ajaxed.');
});