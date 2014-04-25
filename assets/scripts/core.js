$(document).ready(function() {
    var theclass;
    $('.fa-expand').click(function() {
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
    $('.fa-compress').click(function() {
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
};

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
};

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
};

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
};

function loadGraph(base_url, function_url, container) {
    $('#' + container).load(base_url + function_url);
};
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
};