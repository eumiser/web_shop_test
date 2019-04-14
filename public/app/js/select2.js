$(document).ready(function () {
    var dropdownParent = 'body';
    if ($('#baseModalDialog').css('display') !== 'none') {
        dropdownParent = '#baseModalDialog';
    }

    $(".select2-autocomplete").select2({
        language: "es",
        minimumInputLength: 0,
        allowClear: true,
        placeholder: "",
        dropdownParent: $(dropdownParent)
    });
});