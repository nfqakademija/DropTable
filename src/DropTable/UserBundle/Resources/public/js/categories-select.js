$('#library_book_categories').select2({
    tags: true
});

$('#library_book_authors').select2({
    tags: true
});

var $addEditBookForm = $('form#add-edit-book');

$addEditBookForm.submit(function(e) {
    e.preventDefault();

    var $categories = [];
    $('.select-categories').next()
        .find('.select2-selection__choice')
        .each(function() {
            $categories.push($(this).attr('title'))
        });
    var $cats = JSON.stringify($categories);

    $.ajax({
        url: Routing.generate('catalog.add_category'),
        type: "post",
        data: $cats
    }).done(function(data, status){
        var $created = $.parseJSON(data);
        var $createdNames = [];
        // Build array of created categories names.
        $.each($created, function(key, value) {
            $createdNames.push(value);
        });

        $('select#library_book_categories').find('option:contains("")').each(
            function(){
                if (($.inArray($(this).text(), $createdNames)) >= 0) {
                    var $thisText = $(this).text();
                    $.each($created, function(key, value) {
                        if ($thisText == value) {
                            var $target = $("option[value="+value+"]");
                            $target.val(key);
                        }
                    });
                }
            });

        var $authors = [];
        $('.select-authors').next()
            .find('.select2-selection__choice')
            .each(function() {
                $authors.push($(this).attr('title'))
            });
        var $auths = JSON.stringify($authors);

        $.ajax({
            url: Routing.generate('catalog.add_author'),
            type: "post",
            data: $auths
        }).done(function(data, status){

            var $created = $.parseJSON(data);
            var $createdNames = [];
            // Build array of created categories names.
            $.each($created, function(key, value) {
                $createdNames.push(value);
            });

            $('select#library_book_authors').find('option:contains("")').each(
                function(){
                    if (($.inArray($(this).text(), $createdNames)) >= 0) {
                        var $thisText = $(this).text();
                        $.each($created, function(key, value) {
                            if ($thisText == value) {
                                var $target = $("option[value="+value+"]");
                                $target.val(key);
                            }
                        });
                    }
                });
            $addEditBookForm.unbind();
            $addEditBookForm.submit();
        });
    });


});