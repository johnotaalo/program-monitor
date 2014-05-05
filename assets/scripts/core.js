$(document).ready(function() {
    var theclass;
    $('.fa-expand.normal').click(function() {
        theclass = $(this).parent().parent().parent().attr('class');
        $('.' + theclass).hide();
        $(this).parent().parent().find('.inner').hide();
        $('.inner.mini').show();
        $('.fa-compress').show();
        $('.fa-bar-chart-o').show();
        $('.fa-table').show();
        $(this).parent().find('.fa-table').addClass('selected');
        $(this).parent().find('.fa-bar-chart-o').removeClass('selected');
        $('.fa-expand').hide();
        $(this).parent().parent().parent().show();
        $(this).parent().parent().parent().removeClass('standard-graph');
        $(this).parent().parent().parent().addClass('x-large-graph');
    });
    $('.fa-compress.normal').click(function() {
        $('.' + theclass).show();
        $(this).parent().parent().parent().removeClass('x-large-graph');
        $(this).parent().parent().parent().addClass('standard-graph');
        $('.inner.mini').hide();
        $(this).parent().parent().find('.inner.max').show();
        $('.' + theclass).show();
        $('.fa-compress').hide();
        $('.fa-bar-chart-o').hide();
        $('.fa-table').hide();
        $('.fa-expand').show();
        $(this).parent().parent().find('.mini-graph').empty();
        $(this).parent().parent().find('.mini-graph-2').empty();
        $(this).parent().parent().find('.mini-graph').hide();
        $(this).parent().parent().find('.mini-graph-2').hide();
    });

    $('.fa-expand.full-screen').click(function() {
        theclass = $(this).parent().parent().parent().attr('class');
        $('.' + theclass).hide();
        $(this).parent().parent().find('.inner').hide();
        $('.inner.mini.full-screen').show();
        $('.fa-compress.full-screen').show();
        $('.fa-bar-chart-o').show();
        $('.fa-table').show();
        $(this).parent().find('.fa-table').addClass('selected');
        $(this).parent().find('.fa-bar-chart-o').removeClass('selected');
        $('.fa-expand.full-screen').hide();
        $(this).parent().parent().parent().show();
        $(this).parent().parent().parent().removeClass('standard-graph');
        $(this).parent().parent().parent().addClass('xx-large-graph');
        $(this).parent().find('#limit').text('(All)');
        $('.activities').hide();
        $('.guide').hide();

        //var base_url = '<?php echo base_url(); ?>';
        //var function_url_array = ['guidelines_policy/distribution/region/county/all'];
        //var container_array = ['distribution_county_fullscreen'];
        //loadGraphSection(base_url, function_url_array, container_array);
    });
    $('.fa-compress.full-screen').click(function() {
        $('.' + theclass).show();
        $(this).parent().parent().parent().removeClass('xx-large-graph');
        $(this).parent().parent().parent().addClass('standard-graph');
        $('.inner.mini.full-screen').hide();
        $(this).parent().parent().find('.inner.max').show();
        $('.' + theclass).show();
        $('.fa-compress.full-screen').hide();
        $('.fa-bar-chart-o').hide();
        $('.fa-table').hide();
        $('.fa-expand.full-screen').show();
        $(this).parent().parent().find('.mini-graph').empty();
        $(this).parent().parent().find('.mini-graph-2').empty();
        $(this).parent().parent().find('.mini-graph').hide();
        $(this).parent().parent().find('.mini-graph-2').hide();
        $(this).parent().find('#limit').text('(Top 10)');
        $('.activities').show();
        $('.guide').show();
    });

    $('.fa-bar-chart-o').click(function() {
        $(this).parent().parent().find('.mini-graph').empty();
        $(this).parent().parent().find('.mini-graph-2').empty();
        $(this).parent().find('.fa-bar-chart-o').addClass('selected');
        $(this).parent().find('.fa-table').removeClass('selected');
        $(this).parent().parent().find('.mini').hide();
        $(this).parent().parent().find('.mini-graph').show();
        $(this).parent().parent().find('.mini-graph-2').show();
    });
    $('.fa-table').click(function() {
        $(this).parent().find('.fa-bar-chart-o').removeClass('selected');
        $(this).parent().find('.fa-table').addClass('selected');
        $(this).parent().parent().find('.mini-graph').hide();
        $(this).parent().parent().find('.mini-graph-2').hide();
        $(this).parent().parent().find('.mini').show();
    });
    $('.fa-search').click(function() {
        showSearch();
    });
    $('.search-close').click(function() {
        hideSearch();
    });
    $(document).on('keydown', null, 'ctrl+z', showSearch);
    $(document).on('keydown', null, 'ctrl+x', hideSearch);
});

function getHCWData(base_url, function_url) {
    var facilityTable, hcwTable;
    $.ajax({
        url: base_url + function_url,
        beforeSend: function(xhr) {
            xhr.overrideMimeType("text/plain; charset=x-user-defined");
        },
        success: function(data) {
            $('#hcw_list').empty();
            $('#facility_list').empty();
            var obj = $.parseJSON(data);
            $('#facility_total_existing').text(obj['facility_data']['facility_number_existing']);
            $('#facility_total_trained_hcw').text(obj['facility_data']['facility_number_trained']);
            $('#hcw_total_trained').text(obj['participant_data']['participant_number_trained']);

            $('#facility_total_trained_public_hcw').text(obj['participant_data']['public']);
            $('#facility_total_trained_private_hcw').text(obj['participant_data']['private']);

            facilityTable = '<table class="dataTable"><thead><th>Facility MFL Code<i class="fa"></i></th> <th>Facility Name<i class="fa"></i></th></thead><tbody> ';
            $.each(obj['facility_data']['facility_list'], function(k, v) {
                facilityTable = facilityTable + '<tr><td>' + v['mfl_code'] + '</td><td>' + v['fac_name'] + '</td></tr>';
            });
            facilityTable = facilityTable + '</tbody></table>';

            $('#facility_list').append(facilityTable);
            $('#hcw_total_existing').text(obj['participant_data']['participant_number_existing']);
            $('#hcw_total_trained').text(obj['participant_data']['participant_number_trained']);

            hcwTable = '<table class="dataTable"><thead><th>Participant Name<i class="fa"></i></th> <th>Facility Name<i class="fa"></i></th><th>Cadre<i class="fa"></i></th></thead><tbody> ';
            $.each(obj['participant_data']['participant_list'], function(k, v) {
                hcwTable = hcwTable + '<tr><td>' + v['names_of_participant'] + '</td><td>' + v['fac_name'] + '</td><td>' + v['cadre'] + '</td></tr>';
            });
            hcwTable = hcwTable + '</tbody></table>';

            $('#hcw_list').append(hcwTable);
            $('.dataTable').dataTable({
                "sPaginationType": "full_numbers"
            });

            $('.dataTables_filter label input').addClass('form-control');
            $('.dataTables_length label select').addClass('form-control');
            $('#DataTables_Table_0_paginate a').addClass('btn btn-xs btn-default');
            $('#DataTables_Table_0_paginate span a').addClass('btn btn-xs btn-default');
        }
    });
}

$('th.sorting_asc i').addClass('fa-chevron-up');
$('th.sorting_desc i').addClass('fa-chevron-down');

function getTOTData(base_url, function_url) {
    var facilityTable, hcwTable;
    $.ajax({
        url: base_url + function_url,
        beforeSend: function(xhr) {
            xhr.overrideMimeType("text/plain; charset=x-user-defined");
        },
        success: function(data) {

            var obj = $.parseJSON(data);
            $('#tot_total_trained').text(obj['participant_data']['participant_number_trained']);

        }
    });
}

function showSearch() {
    //$('.fa-search').parent().parent().addClass('active');
    left = $('.main').css('left');
    if (left == '0px') {
        $('.main').animate({
            left: '100%'
        }, 1000);
        $('.search').animate({
            left: '+=100%'
        }, 1000);

        $('.search-close').show();
        $('.fa-search').parent().parent().hide();
        $('.tt-input').focus();
    }
}

function hideSearch() {
    left = $('.search').css('left');
    if (left == '0px') {
        $('.fa-search').parent().parent().show();
        $('.search-close').hide();

        $('.search').animate({
            left: '-=100%'
        }, 1000);
        $('.main').animate({
            left: '-=100%'
        }, 1000);
        $('.tt-input').blur();
    }
}

function loadGraph(base_url, function_url, container) {
    $('#' + container).load(base_url + function_url);
}
/**
 * [loadGraphSection loops through an array of container IDs to plot the graphs]
 * @param  {[array]} containerArray [description]
 * @param  {[string]} base_url       [description]
 * @param  {[string]} function_url   [description]
 * @param  {[string]} container      [description]
 * @return {[none]}                [description]
 */
function loadGraphSection(base_url, function_url_array, container_array) {
    //alert('Stuff');
    count = 0;
    $.each(container_array, function(index, value) {
        //alert (base_url+function_url_array[count]+'  '+ value);
        loadGraph(base_url, function_url_array[count], value);
        count++;
    });
}

function loadGraphs(base_url, function_url) {
    $.ajax({
        url: base_url + function_url,
        beforeSend: function(xhr) {
            xhr.overrideMimeType("text/plain; charset=x-user-defined");
        },
        success: function(data) {
            obj = jQuery.parseJSON(data);
            $("#chart_category").val(obj['cat']);
            $('#graph').empty();
            $('#graph').append('<div style="width:100%" id="' + obj['chart_container'] + '"></div>');
            runGraph(obj['chart_container'], obj['chart_type'], obj['chart_size'], obj['chart_title'], obj['chart_stacking'], obj['chart_categories'], obj['chart_series']);

        }
    });
}

function runGraph(chart_container, chart_type, chart_title, chart_series) {
    $("#" + chart_container).chart_type({

        dataSource: dataSource,
        commonSeriesSettings: {
            label: {
                visible: true,
                connector: {
                    visible: true
                },
                customizeText: function(value) {
                    return value.argumentText;
                }
            }
            //...
        },
        title: {
            text: chart_title,
            verticalAlignment: 'bottom',
            font: {
                color: '#3276b1',
                family: 'SourceSansPro-Regular',
                opacity: 0.75,
                size: 16,
                weight: 200
            }
        },
        series: chart_series,
        tooltip: {
            enabled: true,
            customizeText: function(value) {
                return value.argumentText + ' : ' + value.percentText;
            }
        },
        legend: {
            visible: false
        }
    });
}



function pageHandler(base_url,activity) {
    var activityID;

    $("." + activity + "_manual_update").click(function() {
        $('#' + activity + '_manual_update').modal('show');
        activityID = $(this).attr('id');
        $('#' + activity + '_manual_update').delay(2000).queue(function(nxt) {
            $('#activity_id_man').val(activityID);
            nxt();
        });
    });


    $('.' + activity + '_activity_source').click(function() {
        $('#source_data').empty();
        $('#source_data').append('<div class="la-anim-1-mini"></div>');
        $('#source_data > .la-anim-1-mini').addClass('la-animate');
        $('#activity_name').empty();
        activityID = $(this).attr('id');
        $('#' + activity + '_files_modal').modal('show');
        $('#' + activity + '_files_modal').delay(2000).queue(function(nxt) {
            $('#source_data').load(base_url + 'imci/load_activity_source/' + activityID);
            $('#activity_name').load(base_url + 'imci/load_activity_name/' + activityID);

            nxt();
        });
        $('#' + activity + '_files_modal').delay(4000).queue(function(nxt) {
            $(".dataTable").dataTable();

            nxt();
        });
    });


    $("." + activity + "_activity_upload").click(function() {
        $('#' + activity + '_upload_activity').modal('show');
        activityID = $(this).attr('id');
        $('#upload_button').delay(2000).queue(function(nxt) {
            $('#activity_id').val(activityID);

            nxt();
        });

    });


    $("#" + activity + "_uploadActivityBtn").click(function() {
        $('#' + activity + '_upload_form').submit();
    });



    $(".add").click(function() {
        //  when add is clicked this function
        $('.datepicker').datepicker('remove');

        $table = $('#activity_table');
        var cloned_object = $table.find('tr:last').clone(true);

        var id = cloned_object.attr("id");
        var next_id = parseInt(id) + 1;


        cloned_object.attr("id", next_id);
        cloned_object.find("input").val("");
        cloned_object.find(":input").css('border-color', '#ccc');
        //cat_name;
        //  cat_name.attr("text",'');
        //cloned_object.find(".participant").attr("name",'participant['+next_id+']');

        cloned_object.insertAfter('#activity_table tr:last');
        $('.remove').show();

        $('.datepicker').datepicker({
            format: 'dd-m-yyyy',
            autoclose: true
        });

        return false;
    });

    $('.remove').click(function() {
        id = $(this).parent().parent().attr("id");
        if (id !== 0) {
            $(this).parent().parent().remove();
        } else {
            alert('This is the first row');
        }


    });

    //On Change



    $('.datepicker').datepicker({
        format: 'dd-m-yyyy',
        autoclose: true
    });

    $('#export_csv').click(function() {
        link = $(this).attr('data-link');
        window.open(link + activityID);
    });

    $('#export_pdf').click(function() {
        link = $(this).attr('data-link');
        window.open(link + activityID);
    });

    $('.modal-title > a#export_pdf').click(function() {
        link = $(this).attr('data-link');
    });

    $('.facilityoption').change(function() {
        val = $(this).val();
        text = $(this).find('option:selected').text();
        //alert(text);
        row = $(this).parent().parent().attr("id");
        $(this).closest('tr').find('.mfl_code').val(val);
        $(this).closest('tr').find('.facilityname').val(text);

    });


    function validate_combo(combo) {
        tr_id = $(combo).parent().parent().attr('id');
        value = $('tr#' + tr_id + ' td ' + combo).prop("selectedIndex");
        if (value === 0) {
            $(combo).css('border-color', 'red');
        } else {
            $(combo).css('border-color', '#ccc');
        }


        //return value;
    }

    function validate_text(field) {
        tr_id = $(field).parent().parent().attr('id');
        alert('tr#' + tr_id + ' td ' + field);
        value = $('tr#' + tr_id + ' td ' + field).val();
        //message = $(field).attr('data-msg');

        if (value === "") {
            $(field).attr.css('border-color', 'red');
            $(field).tooltip('show');
        } else {
            $(field).css('border-color', '#ccc');
            $(field).tooltip('hide');
        }


    }
    $('.fa-bar-chart-o').click(function() {
        var activity_name = 'Train an expanded pool of HCWs';
        activity_name = encodeURIComponent(activity_name);
        var base_url = '<?php echo base_url(); ?>';
        var function_url_array = ['imci/imci_frequency/' + activity_name, 'imci/imci_training_county', 'imci/imci_cadre'];
        var container_array = ['training_frequency', 'training_coverage', 'training_cadre'];
        loadGraphSection(base_url, function_url_array, container_array);
    });



    function validate_email(field) {

    }

    function validate_mobile(field) {

    }

    
}