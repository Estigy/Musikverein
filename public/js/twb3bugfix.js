$(function() {
    $('input[type=radio]').each(function() {
        $(this).closest('label').removeClass('col-sm-3 control-label');
    });
    $('input[type=checkbox]').each(function() {
        var l = $(this).closest('label');
        l.removeClass('col-sm-3 control-label checkbox-inline');
        var clDiv = l.closest('div');
        if (!clDiv.hasClass('checkbox')) {
            l.wrap('<div class="checkbox">');
        }
    });
});