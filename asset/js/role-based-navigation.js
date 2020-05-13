var chosenSelectors = [];

function redrawSelectors () {
    $.each(chosenSelectors, function (index, value) {
        $(value + '_chosen').remove();
        $(value).chosen('destroy');
        $(value).chosen(chosenOptions);
        
        $(value).on('chosen:showing_dropdown', function(evt, params) {
            $('#nav-tree').jstree(
                    'deselect_all',
                    true);
        });

        $(value).on('change', function(evt, params) {
            if (params.selected) {
                $(value + ' option[value=' + params.selected + ']').attr('selected','selected');
            }
            if (params.deselected) {
                $(value + ' option[value=' + params.deselected + ']').removeAttr('selected');
            }
        });
    });
};

$(document).ready(function() {
        
    redrawSelectors();
        
     // Call redrawSelector when moving nodes
    $('#nav-tree').on("create_node.jstree", function(evt, data){
        redrawSelectors();
    });

    $('#nav-tree').on("move_node.jstree", function(evt, data){
        redrawSelectors();
    });
});
