<html>
<head>
	<title>CARIBARANG</title>
	<script type="text/javascript" src="http://code.jquery.com/jquery-2.2.0.min.js"></script>
</head>
<body>
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
				url: 'http://localhost:2903/api/search',
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