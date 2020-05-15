var chosenSelectors = [];

function registerSelector(selectorId) {
    if (chosenSelectors.indexOf(selectorId) === -1) {
        chosenSelectors.push(selectorId);
        
        $(selectorId).on('chosen:showing_dropdown', function(evt, params) {
            $('#nav-tree').jstree(
                    'deselect_all',
                    true);
        });

        $(selectorId).on('change', function(evt, params) {
            if (params.selected) {
                $(selectorId + ' option[value=' + params.selected + ']').attr('selected','selected');
            }
            if (params.deselected) {
                $(selectorId + ' option[value=' + params.deselected + ']').removeAttr('selected');
            }
        });

        redrawSelectors();
    }
}

function redrawSelectors () {
    $.each(chosenSelectors, function (index, value) {
        $(value + '_chosen').remove();
        $(value).chosen('destroy');
        $(value).chosen(chosenOptions);
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
