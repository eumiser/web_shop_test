var $project = $('#app_form_import_translation_by_file_project');
// When sport gets selected ...
$project.change(function () {
    // ... retrieve the corresponding form.
    var $form = $(this).closest('form');
    // Simulate form data, but only include the selected sport value.
    var data = {};
    data[$project.attr('name')] = $project.val();
    // Submit data via AJAX to the form's action path.
    $.ajax({
        url: $form.attr('action'),
        type: $form.attr('method'),
        data: data,
        success: function (html) {
            // Replace current position field ...
            $('#app_form_import_translation_by_file_language').replaceWith(
                // ... with the returned one from the AJAX response.
                $(html).find('#app_form_import_translation_by_file_language')
            );
            $('#app_form_import_translation_by_file_domain').replaceWith(
                // ... with the returned one from the AJAX response.
                $(html).find('#app_form_import_translation_by_file_domain')
            );
        }
    });
});