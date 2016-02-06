<?php
include_once 'inc/constants.php';
include_once 'inc/js_above.php';

$formCategory = '';
$formSubcategory = '';
if (strpos($_GET['form_category'], '___cat')) {
	$formCategory = trim($_GET['form_category']);
} else {
	$formSubcategory = trim($_GET['form_category']);
}
$formKeyword = trim($_GET['form_keyword']);
$formMinPrice = str_replace(',', '', $_GET['form_min-price']);
$formMaxPrice = str_replace(',', '', $_GET['form_max-price']);

$reqJson = array();
$reqJson['Category'] = $formCategory;
$reqJson['Subcategory'] = $formSubcategory;
$reqJson['Keyword'] = $formKeyword;
$reqJson['MinPrice'] = $formMinPrice;
$reqJson['MaxPrice'] = $formMaxPrice;
$reqJson['From'] = '0';
$reqJson['Size'] = '30';

$reqJsonStr = json_encode($reqJson);
?>

<div id="left-floating-title" style="position:fixed; left:20px;">
	<h1>caribarang</h1>
</div>
<div class="container"></div>

<script type="text/javascript">
	$.ajax({
		url: '<?php echo API_SERVER_URI; ?>/api/search',
		type: 'POST',
		dataType: 'json',
		success: function(data) {
			var html = '';
			$.each(data.hits.hits, function(i,e) {
				var v = e._source;
				html += '<div class="row">\n ' + 
						'	<div class="col-sm-3"></div>\n ' + 
						'	<div class="col-sm-6 text-center">\n ' + 
						'		<span style="font-weight:bold;">'+v.Source+'</span><br />\n ' + 
						'		<span><a href="'+v.Uri+'" target="_blank">'+v.Name+'</a></span><br />\n ' + 
						'		<span style="font-size:1.5em;">'+numberWithCommas(String(v.Price))+'</span>\n ' + 
						'		<a href="'+v.Uri+'" target="_blank"><img class="img-responsive" src="'+v.ImageUri+'" style="margin:0 auto;" width="90%" /></a> \n ' + 
						'		<hr style="border-color: black;" />\n ' + 
						'	</div>\n ' + 
						'	<div class="col-sm-3"></div>\n ' + 
						'</div>';
			});
			$('.container').html(html);
		}.bind(this),
		error: function(xhr, status, err) {
			
		}.bind(this),
		data: '<?php echo $reqJsonStr; ?>'
	});
</script>