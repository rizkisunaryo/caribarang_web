<?php
	include_once 'inc/js_above.php';
	include_once 'inc/js_fb.php';
?>

	<div class="container">
		<div class="jumbotron">
			<h1>CariBarang</h1>
			<p style="color:blue;">Mau belanja online? Cari aja di sini!</p>
		</div>

		<div class="row text-right" style="margin-right:5px; margin-bottom:20px;">
			<div id="fb-login-div" style="display:none;">
				<div id="fb-root"></div>
				<div class="fb-login-button" data-max-rows="1" data-size="large" data-show-faces="false" data-auto-logout-link="false" onlogin="checkLoginState();"></div>
			</div>
			<div id="user-drop-down" style="margin-top:-9px; cursor:pointer; float:right; display:none;">
				<ul class="nav nav-pills left">
					<li class="dropdown active span8">
						<a class="dropdown-toggle" id="inp_impact" data-toggle="dropdown">
							<span id="user-full-name"></span>&nbsp;<span class="caret"></span>
						</a>
						<ul ID="divNewNotifications" class="dropdown-menu" style="cursor:pointer;">
							<li><a onclick="logoutFB();">Log Out</a></li> 
						</ul>
					</li>
				</ul>
			</div>
		</div>
		<script type="text/javascript">
			$('.dropdown-toggle').dropdown();
			$('#divNewNotifications li').on('click', function() {
		    	$('#user-full-name').html($(this).find('a').html());
		    });
		</script>

		<div class="row">
			<div class="col-sm-3"></div>
			<div class="col-sm-6">
				<form role="form" method="GET" id="form">
					<select class="form-control" id="form_category" name="form_category">
						<option value="">=== Kategori ===</option>
						<?php

						$sql = "SELECT category,subcategory,label FROM category WHERE is_deleted=0 ORDER BY category,subcategory ";
						$result = $conn->query($sql);

						
					    while($row = $result->fetch_assoc()) {
					    	$value = $row['subcategory'];
					    	$label = $row['label'];
					    	if ($value=='') {
					    		$value = $row['category'];
					    	} else {
					    		$label = '&nbsp;&nbsp;&nbsp;' . $label;
					    	}
					        // echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
					    ?>

					    <option value="<?php echo $value; ?>"><?php echo $label; ?></option>

					    <?php
					    }						
						$conn->close();

						?>
					</select><br />
				    <input type="text" class="form-control" id="form_keyword" name="form_keyword" placeholder="Kata kunci"><br />
				    <input type="tel" class="form-control" id="form_min-price" name="form_min-price" placeholder="Harga minimum" onkeypress="return isNumberKey(event);" onkeyup="this.value=numberWithCommas(this.value);"><br />
				    <input type="tel" class="form-control" id="form_max-price" name="form_max-price" placeholder="Harga maximum" onkeypress="return isNumberKey(event);" onkeyup="this.value=numberWithCommas(this.value);"><br />
				  	<button type="submit" class="btn btn-default">C A R I</button>
				</form>
			</div>
			<div class="col-sm-3"></div>
		</div>		 
	</div>

	<script type="text/javascript">
		$('#form').submit(function() {
			var keyword = $('#form_keyword').val().trim();
			if (id.trim()=='' || token.trim()=='' || keyword=='') return true;

			$.ajax({
				url: '<?php echo API_SERVER_URI; ?>/api/search/save',
				type: 'POST',
				dataType: 'json',
				success: function(data) {
					// EMPTY
				}.bind(this),
				error: function(xhr, status, err) {
					// EMPTY
				}.bind(this),
				data: JSON.stringify({
					Id: id,
					Token: token,
					LoginType: 'fb',
					Keyword: $('#form_keyword').val().trim()
				})
			});
		})
	</script>