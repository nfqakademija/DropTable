$('#library_book_categories').select2({
    tags: true
});

$('#library_book_authors').select2({
    tags: true
});

$('#library_book_publisher').select2({
    tags: true
});


var $addEditBookForm = $('form#add-edit-book');

$addEditBookForm.submit(function(e) {
    e.preventDefault();

    // Dealing with categories.
    var $categories = [];
    $('.select-categories').next()
        .find('.select2-selection__choice')
        .each(function() {
            $categories.push($(this).attr('title'))
        });
    var $cats = JSON.stringify($categories);

    // Ajax call for categories.
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

        // Dealing with authors.
        var $authors = [];
        $('.select-authors').next()
            .find('.select2-selection__choice')
            .each(function() {
                $authors.push($(this).attr('title'))
            });
        var $auths = JSON.stringify($authors);

        // Ajax call for authors.
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

            // Dealing with publishers. TODO: Some renaming.
            var $publishers = [];
            $('.select-publisher').next()
                .find('.select2-selection__rendered')
                .each(function() {
                    $publishers.push($(this).attr('title'))
                });
            var $auths = JSON.stringify($publishers);

            // Ajax call for Publishers.
            $.ajax({
                url: Routing.generate('catalog.add_publisher'),
                type: "post",
                data: $auths
            }).done(function(data, status){

                var $created = $.parseJSON(data);
                var $createdNames = [];
                // Build array of created categories names.
                $.each($created, function(key, value) {
                    $createdNames.push(value);
                });

                $('select#library_book_publisher').find('option:contains("")').each(
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


});