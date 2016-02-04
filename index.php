<?php 
include_once 'constants.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>CARIBARANG</title>
	<meta charset="utf-8"> 
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" />
	<script type="text/javascript" src="http://code.jquery.com/jquery-2.2.0.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
		<div class="jumbotron">
			<h1>caribarang</h1>
		</div>

		<div class="row">
			<div class="col-sm-3"></div>
			<div class="col-sm-6">
				<form role="form">
				  	<div class="form-group">
				    	<label for="keyword">Kata kunci:</label>
				    	<input type="text" class="form-control" id="keyword">
				  	</div>
				  	<div class="form-group">
					    <label for="min-price">Harga minimum:</label>
				    	<input type="text" class="form-control" id="min-price">
				  	</div>
				  	<div class="form-group">
					    <label for="max-price">Harga maksimum:</label>
				    	<input type="text" class="form-control" id="max-price">
				  	</div>
				  	<button type="submit" class="btn btn-default">Cari</button>
				</form>
			</div>
			<div class="col-sm-3"></div>
		</div>

		 
	</div>



	<table>
		<tr>
			<td>Keyword</td>
			<td>:</td>
			<td><input type="text" id="form_keyword" /></td>
		</tr>
		<tr>
			<td>Min price</td>
			<td>:</td>
			<td><input type="text" id="form_min-price" /></td>
		</tr>
		<tr>
			<td>Max price</td>
			<td>:</td>
			<td><input type="text" id="form_max-price" /></td>
		</tr>
	</table>
	<button id="frm_search">SEARCH</button>
	<table id="result"></table>
	<script type="text/javascript">
		$('#frm_search').click(function() {
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
				data: JSON.stringify({
					Keyword: $('#form_keyword').val(),
					MinPrice: $('#form_min-price').val(),
					MaxPrice: $('#form_max-price').val()
				})
			});
		})
	</script>
</body>
</html>