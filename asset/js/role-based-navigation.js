var chosenSelectors = [];

function redrawSelectors () {
    $.each(chosenSelectors, function (index, value) {
        $(value + '_chosen').remove();
        $(value).chosen('destroy');
        $(value).chosen(chosenOptions);
        $(value).on('chosen:showing_dropdown', value, function(evt, params) {
            $('#nav-tree').jstree(
                    'select_node',
                    $(value).closest("li .jstree-node").attr('id'));
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
