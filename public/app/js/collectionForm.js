var $collectionHolder;

// setup an "add a parameter" link
var $addParameterLink = $('<button type="button" class="add_parameter_link btn-info btn">' + labelAddParameter + '</button>');
var $newLinkLi = $('<div class="col-md-12"></div>').append($addParameterLink);

jQuery(document).ready(function () {
    // Get the ul that holds the collection of parameters
    $collectionHolder = $('div.parameters');

    // add the "add a parameter" anchor and li to the parameters ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addParameterLink.on('click', function (e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new parameter form (see code block below)
        addParameterForm($collectionHolder, $newLinkLi);
    });
});

function addParameterForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');

    // Replace '$$name$$' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newForm = prototype.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a parameter" link li
    var $newFormLi = $('<div class="row col-md-12"></div>').append(newForm);

    // also add a remove button, just for this example
    $newFormLi.append('<button href="#" class="remove-parameter btn btn-danger btn-xs">X</button>');

    $newLinkLi.before($newFormLi);

    $('.trans-parameter').addClass('col-md-6');

    // handle the removal, just for this example
    $('.remove-parameter').click(function (e) {
        e.preventDefault();

        $(this).parent().remove();

        return false;
    });
}
