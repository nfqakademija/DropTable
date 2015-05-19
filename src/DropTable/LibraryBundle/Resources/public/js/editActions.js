jQuery(document).ready(function() {
    addRemoveTags();
    removeField();
    addLink('div#library_book_categories', 'Category');
    addLink('div#library_book_authors', 'Author');
});

function addLink($selector, $name) {
    var $addTagLink = $('<a href="#" class="add_"+$name+"_link">Add '+$name+'</a>');
    var $newLinkLi = $('<div></div>').append($addTagLink);
    // Get the ul that holds the collection of tags
    var $collectionHolder = $($selector);

    // add the "add a tag" anchor and li to the tags ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addTagLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new tag form (see code block below)
        addDynamicForm($collectionHolder, $newLinkLi);
    });
}

function addDynamicForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');

    // Replace '$$name$$' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newForm = prototype.replace(/__name__label__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormLi = $('<div></div>').append(newForm);

    // also add a remove button, just for this example
    $newFormLi.append('<a href="#" class="remove-tag">x</a>');

    $newLinkLi.before($newFormLi);

    $('.remove-tag').on('click', function(e) {
        e.preventDefault();

        $(this).parent().remove();

        return false;
    });
}

function removeField() {
    $('.remove-tag').on('click', function(e) {
        e.preventDefault();

        // Empty the field before deleting.
        var $field = $(this).parent().find('input');

        $field.val('');

        $(this).parent().remove();

        return false;
    });
}

function addRemoveTags() {
    var $target = $('#library_book_categories').find('> div');
    $target.append('<a href="#" class="remove-tag">x</a>');
}