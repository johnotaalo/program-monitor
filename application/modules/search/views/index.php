
    <style>
        #search-bar .query-title {
            background:#fff;
        margin: 0 20px 5px 20px;
        padding: 3px 0;
        border-bottom: 1px solid #ccc;
        }
    </style>
    
    <script type="text/javascript" src="<?php
echo base_url(); ?>assets/scripts/handlebars.js" ></script>
    <script type="text/javascript" src="<?php
echo base_url(); ?>assets/scripts/typeahead.bundle.js" ></script>
    <script type="text/javascript" src="<?php
echo base_url(); ?>assets/scripts/jquery.hotkeys.js" ></script>
    <script>
         $(document).ready(function(){
                    var substringMatcher = function(strs) {
            return function findMatches(q, cb) {
                var matches, substringRegex;
                // an array that will be populated with substring matches
                matches = [];
                // regex used to determine if a string contains the substring `q`
                substrRegex = new RegExp(q, 'i');
                // iterate through the pool of strings and for any string that
                // contains the substring `q`, add it to the `matches` array
                $.each(strs, function(i, str) {
                if (substrRegex.test(str)) {
                    // the typeahead jQuery plugin expects suggestions to a
                    // JavaScript object, refer to typeahead docs for more info
                    matches.push({ value: str });
                }
                });
                cb(matches);
            };
            };
            
            
        var facilities = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('facility'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: 'assets/data/facilities.json'
        });

        var districts = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('district'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: 'assets/data/districts.json'
        });

        var counties = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('county'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: 'assets/data/counties.json'
        });

        facilities.initialize();
        districts.initialize();
        counties.initialize();

        $('#search-bar .typeahead').typeahead({
        highlight: true
        },
        {
        name: 'facilities',
        displayKey: 'facility',
        source: facilities.ttAdapter(),
        templates: {
            header: '<h3 class="query-title">Facilities</h3>'
        }
        },
        {
        name: 'districts',
        displayKey: 'district',
        source: districts.ttAdapter(),
        templates: {
            header: '<h3 class="query-title">Districts</h3>'
        }
        },
         {
        name: 'counties',
        displayKey: 'county',
        source: counties.ttAdapter(),
        templates: {
            header: '<h3 class="query-title">Counties</h3>'
        }
        }).on('typeahead:selected',onSelected);


        function onSelected($e, datum) {
    $.each(datum, function( k, v ){
        v = encodeURIComponent(v);
        base_url = '<?php echo base_url(); ?>';
        function_url = 'search/get_data_hcw/'+k+'/'+v;
        getHCWData(base_url,function_url);
        function_url = 'search/get_data_tot/'+k+'/'+v;
        getTOTData(base_url,function_url);
    });

    

};
$('#facility_list').collapse('hide');
$('#hcw_list').collapse('hide');

/*$('.facility_list_show').click(function(){
        $('#facility_list').collapse('toggle');
        $('.hcw_list_show').parent().parent().css({'background':'whitesmoke','color':'#333333','font-weight':'normal'});
        $('.facility_list_show').parent().parent().css({'background':'#3276b1','color':'white','font-weight':'bold'});
    });

$('.hcw_list_show').click(function(){
        $('#hcw_list').collapse('toggle');
        $('.hcw_list_show').parent().parent().css({'background':'#3276b1','color':'white','font-weight':'bold'});
        $('.facility_list_show').parent().parent().css({'background':'whitesmoke','color':'#333333','font-weight':'normal'});
    });
*/
$('#hcw_list').on('show.bs.collapse', function () {
    $('.hcw_list_show').parent().parent().css({'background':'#3276b1','color':'white','font-weight':'bold'});
    $('#facility_list').collapse('hide');

})
$('#hcw_list').on('hide.bs.collapse', function () {
    $('.hcw_list_show').parent().parent().css({'background':'whitesmoke','color':'#333333','font-weight':'normal'});
  

})
$('#facility_list').on('show.bs.collapse', function () {
    $('#hcw_list').collapse('hide');
    $('.facility_list_show').parent().parent().css({'background':'#3276b1','color':'white','font-weight':'bold'});

})
$('#facility_list').on('hide.bs.collapse', function () {
    $('.facility_list_show').parent().parent().css({'background':'whitesmoke','color':'#333333','font-weight':'normal'});

})

        });
    </script>
<div class="row">
 <div id="search-bar">
  <input class="typeahead" type="text" placeholder="Type to Search">
</div>
</div>
   
<div class="row">
    <div class="search-section">
    
    <div class="outer">    
    
        <div class="inner">
        <div class="stat">
        <div class="icon"><i class="fa fa-hospital-o"></i></div>
            <div>
                <span id="facility_number_existing" class="text">Total Facilities Existing : </span>
                <span id="facility_total_existing" class="digit">0</span>
            </div>
        </div>
            <div class="stat">
              <div class="icon"><i class="fa fa-hospital-o"></i></div>
            <div>
            <span id="facility_number_trained_hcw" class="text">Total Facilities Trained (HCW): </span>
            <span id="facility_total_trained_hcw" class="digit">0</span>
            </div>
            </div>
            <div class="stat">
              <div class="icon"><i class="fa fa-hospital-o"></i></div>
            <div>
            <span id="facility_number_trained_public_hcw" class="text">Total Public Facilities Trained (HCW): </span>
            <span id="facility_total_trained_public_hcw" class="digit">0</span>
            </div>
            </div>
            <div class="stat">
              <div class="icon"><i class="fa fa-hospital-o"></i></div>
            <div>
            <span id="facility_number_trained_private_hcw" class="text">Total Private Facilities Trained (HCW): </span>
            <span id="facility_total_trained_private_hcw" class="digit">0</span>
            </div>
            </div>
            <div class="stat">
              <div class="icon"><i class="fa fa-user-md"></i></div>
           <div> <span id="hcw_number_trained" class="text">Total HCWs Trained : </span>
            <span id="hcw_total_trained" class="digit">0</span>
            </div>
            </div>
            
            <div class="stat">
              <div class="icon-alt"><i class="fa fa-user-md"></i></div>
           <div> <span id="tot_number_trained" class="text">Total TOTs Trained : </span>
            <span id="tot_total_trained" class="digit">0</span>
            </div>
            </div>

        <div class="panel-group" id="accordion">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a class="facility_list_show" data-toggle="collapse" data-parent="#accordion" href="#facility_list" data-toggle="tooltip" data-placement="bottom" title="Click Here for More">
          Facility List
        </a>
      </h4>
    </div>
    <div id="facility_list" class="panel-collapse collapse in" style="height:75%;overflow-x:auto">
      <div class="panel-body">
        </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a class="hcw_list_show" data-toggle="collapse" data-parent="#accordion" href="#hcw_list" data-toggle="tooltip" data-placement="bottom" title="Click Here for More">
          Participant List
        </a>
      </h4>
    </div>
    <div id="hcw_list" class="panel-collapse collapse in" style="height:70%;overflow-x:auto">
      <div class="panel-body">
        </div>
    </div>
  </div>
</div>
        </div>
    </div>
    
    </div>
    

</div>
