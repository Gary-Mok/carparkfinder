$(document).ready(function () {
    $("#ckbCheckAll").click(function () {
        $(".checkBoxClass").prop('checked', $(this).prop('checked'));
    });
});

$(function() {
    $("#deleteButton").click(function(){
        if (confirm("Please confirm your selection. You cannot undo a delete.")){
            $('form#delete').submit();
        }
    });
});