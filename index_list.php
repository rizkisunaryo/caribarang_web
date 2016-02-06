<?php
include_once 'inc/constants.php';

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

$reqJsonStr = json_encode($reqJson);
?>

<table id="result"></table>

<script type="text/javascript">
	$.ajax({
		url: '<?php echo API_SERVER_URI; ?>/api/search',
		type: 'POST',
		dataType: 'json',
		success: function(data) {
			var html = '';
			$.each(data.hits.hits, function(i,e) {
				var v = e._source;
				html+='<tr>\n' + 
							'	<td>'+v.Price+'</td>\n' + 
							'	<td><img src="'+v.ImageUri+'" width="100" /></td>\n' + 
							'	<td><a href="'+v.Uri+'">'+v.Name+'</a></td>\n' + 
							'</tr>';
			});
			$('#result').html(html);
		}.bind(this),
		error: function(xhr, status, err) {
			
		}.bind(this),
		data: '<?php echo $reqJsonStr; ?>'
	});
</script>