var $project = $('#app_form_import_translation_keys_by_file_project');
var $user = $('#app_form_import_translation_keys_by_file_user');
// When sport gets selected ...
$project.change(function () {
    // ... retrieve the corresponding form.
    var $form = $(this).closest('form');
    // Simulate form data, but only include the selected sport value.
    var data = {};
    data[$project.attr('name')] = $project.val();
    data[$user.attr('name')] = $user.val();
    // Submit data via AJAX to the form's action path.
    $.ajax({
        url: $form.attr('action'),
        type: $form.attr('method'),
        data: data,
        success: function (html) {
            // Replace current position field ...
            $('#app_form_import_translation_keys_by_file_language').replaceWith(
                // ... with the returned one from the AJAX response.
                $(html).find('#app_form_import_translation_keys_by_file_language')
            );
            $('#app_form_import_translation_keys_by_file_domain').replaceWith(
                // ... with the returned one from the AJAX response.
                $(html).find('#app_form_import_translation_keys_by_file_domain')
            );
            $('#app_form_import_translation_keys_by_file_user').replaceWith(
                // ... with the returned one from the AJAX response.
                $(html).find('#app_form_import_translation_keys_by_file_user')
            );
            // Position field now displays the appropriate positions.
        }
    });
});