<link href="<?php echo base_url(). 'assets/gantti/styles/css/gantti-plain.css'?>"  type="text/css" rel="stylesheet" media="all">
<link href="<?php echo base_url(). 'assets/sass-assets/stylesheets/styles.css'?>"  type="text/css" rel="stylesheet" media="all">
<link href="<?php echo base_url(). 'assets/styles/bootstrap/datepicker.css'?>"  type="text/css" rel="stylesheet" media="all">
<link href="<?php echo base_url(). 'assets/styles/bootstrap/datepicker3.css'?>"  type="text/css" rel="stylesheet" media="all">
<link href="<?php echo base_url(). 'assets/styles/font-awesome/css/font-awesome.css'?>"  type="text/css" rel="stylesheet" media="all">
<link href="<?php echo base_url(). 'assets/styles/component.css'?>"  type="text/css" rel="stylesheet" media="all">
<link href="<?php echo base_url(). 'assets/styles/normalize.css'?>"  type="text/css" rel="stylesheet" media="all">
<link href="<?php echo base_url(). 'assets/styles/foundation/foundation-icons.css'?>"  type="text/css" rel="stylesheet" media="all">

<link href="<?php echo base_url(). 'assets/table-cloth/css/tablecloth.css'?>"  type="text/css" rel="stylesheet" media="all">
<link href="<?php echo base_url(). 'assets/table-cloth/css/prettify.css'?>"  type="text/css" rel="stylesheet" media="all">
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/0.10.0/lodash.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/scripts/jquery-1.10.2.min.js" ></script>
<script src="<?php echo base_url(). 'assets/scripts/bootstrap.js'?>" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/scripts/handlebars.js" ></script>

    <script type="text/javascript" src="<?php echo base_url(); ?>assets/scripts/typeahead.bundle.js" ></script>
<script src="<?php echo base_url(). 'assets/scripts/core.js'?>" type="text/javascript"></script>


<script type="text/javascript" src="<?php echo base_url(); ?>assets/chartjs/scripts/dx.chartjs.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/chartjs/scripts/knockout-2.2.1.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/scripts/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/scripts/classie.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/scripts/modernizr.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/scripts/run_animate.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/scripts/bootstrap/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/scripts/jquery.validate.js"></script>
<script src="<?php echo base_url().'assets/scripts/datatables/jquery.dataTables.min.js'?>"></script>
<script src="<?php echo base_url()?>assets/fusionmaps/FusionCharts.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/table-cloth/js/jquery.tablecloth.js" ></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/table-cloth/js/jquery.tablesorter.js" ></script>

 

<script>
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
					matches.push({
						value: str
					});
				}
			});
			cb(matches);
		};
	};
	var nbaTeams = new Bloodhound({
		datumTokenizer: Bloodhound.tokenizers.obj.whitespace('team'),
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		prefetch: 'data/nba.json'
	});
	var nhlTeams = new Bloodhound({
		datumTokenizer: Bloodhound.tokenizers.obj.whitespace('team'),
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		prefetch: 'data/nhl.json'
	});
	nbaTeams.initialize();
	nhlTeams.initialize();

	$('#multiple-datasets .typeahead').typeahead({
		highlight: true
	}, {
		name: 'nba-teams',
		displayKey: 'team',
		source: nbaTeams.ttAdapter(),
		templates: {
			header: '<h3 class="league-name">NBA Teams</h3>'
		}
	}, {
		name: 'nhl-teams',
		displayKey: 'team',
		source: nhlTeams.ttAdapter(),
		templates: {
			header: '<h3 class="league-name">NHL Teams</h3>'
		}
	});
</script>

	     
<title><?php echo $title ?></title>