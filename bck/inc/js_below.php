<script type="text/javascript">
	function popularSave(uri) {
		$.ajax({
			url: '<?php echo API_SERVER_URI; ?>/api/popular/save',
			type: 'POST',
			dataType: 'json',
			success: function(data) {
				// EMPTY
			}.bind(this),
			error: function(xhr, status, err) {
				// EMPTY
			}.bind(this),
			data: JSON.stringify({
				Uri: uri
			})
		});
	}
</script>