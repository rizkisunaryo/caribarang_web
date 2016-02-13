<?php
	include_once 'inc/js_above.php';
	include_once 'inc/js_fb.php';
	include_once 'inc/css.php';
	include_once 'inc/db.php';
?>
	<style type="text/css">
		@media all and (min-width: 768px) {
		  	div.item-container {
			    width: 18.7%;
			}
		}
	</style>

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

						$sql = "SELECT category,subcategory,label FROM m_category WHERE is_deleted=0 ORDER BY category,subcategory ";
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
						// $conn->close();

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



		<!-- ==============
		SUGGESTIONS SECTION
		=============== -->
		<div class="row" id="suggestions-title" style="padding-left:10px;"></div>
		<div class="row" id="suggestions-row-1"></div>
		<script type="text/javascript">
			function fbLoginSuccessCallback() {
				$.ajax({
					url: '<?php echo API_SERVER_URI; ?>/api/suggestions/list',
					type: 'POST',
					dataType: 'json',
					success: function(data) {
						if (typeof data.Message !== 'undefined' && data.Message!=null && data.Message!="") {
							return;
						};
						if (data.hits.hits.length < 1) {
							return;
						};

						$('#suggestions-title').html('<hr><h3>SUGGESTIONS</h3>');
						var suggestionsRow1Html = '';
						$.each(data.hits.hits, function(i,e) {
							var v = e._source;
							var html = '<div class="item-container text-center">\n ' + 
										'	<span style="font-weight: bold;">'+v.Source+'</span><br>\n ' + 
										'	<div style="text-overflow:ellipsis; white-space: nowrap; overflow: hidden; width: 100%">\n ' + 
										'		<a onmousedown="popularSave(\''+v.Uri+'\')" href="'+v.Uri+'" target="_blank">'+v.Name+'</a>\n ' + 
										'	</div>\n ' + 
										'	<span style="font-size: 1.5em;">'+numberWithCommas(String(v.Price))+'</span><br>\n ' + 
										'	<div class="cropped-image-container">\n ' + 
										'		<a onmousedown="popularSave(\''+v.Uri+'\')" href="'+v.Uri+'" target="_blank">\n ' + 
										'			<img class="cropped-image" style="max-width:100%;" src="assets/img/no-image.png" id="suggestions-preload-image_'+i+'" />\n ' + 
										'		</a>\n ' + 
										'	</div>\n ' + 
										'</div>';
							if (i<=4) {
								suggestionsRow1Html += html;
							}

							var img = new Image();
							img.onload = function () {
							   $('#suggestions-preload-image_'+i).attr('src',v.ImageUri);
							}
							img.src = v.ImageUri;
						});
						$('#suggestions-row-1').html(suggestionsRow1Html);
					}.bind(this),
					error: function(xhr, status, err) {
						// EMPTY
					}.bind(this),
					data: JSON.stringify({
						Id: id,
						Token: token,
						LoginType: 'fb',
						Size: '5'
					})
				});
			}
		</script>



		<!-- ==========
		POPULAR SECTION
		=========== -->
		<?php

		$sql = "SELECT name,uri,image_uri,price,source FROM popular ORDER BY click_count DESC LIMIT 0,10 ";
		$result = $conn->query($sql);

		$i = 0;
	    while($row = $result->fetch_assoc()) {
	    	if ($i==0) {
	    	?>
	    		<div class="row" id="popular-title" style="padding-left:10px;"><hr><h3>POPULAR</h3></div>
	    	<?php
	    	}
	    	if ($i==0 || $i==5) {
	    	?>
	    		<div class="row">
	    	<?php
	    	}
	    	?>
	    			<div class="item-container text-center">
						<span style="font-weight: bold;"><?php echo $row['source']; ?></span><br>
						<div style="text-overflow:ellipsis; white-space: nowrap; overflow: hidden; width: 100%">
							<a onmousedown="popularSave('<?php echo $row['uri']; ?>')" href="<?php echo $row['uri']; ?>" target="_blank"><?php echo $row['name']; ?></a>
						</div>
						<span style="font-size: 1.5em;">
							<script type="text/javascript">
								document.write(numberWithCommas('<?php echo $row['price']; ?>'));
							</script>
						</span><br>
						<div class="cropped-image-container">
							<a onmousedown="popularSave('<?php echo $row['uri']; ?>')" href="<?php echo $row['uri']; ?>" target="_blank">
								<img class="cropped-image" style="max-width:100%;" src="assets/img/no-image.png" id="popular-preload-image_<?php echo $i; ?>" />
							</a>
						</div>
					</div>
					<script type="text/javascript">
						var img = new Image();
						img.onload = function () {
						   $('#popular-preload-image_<?php echo $i; ?>').attr('src','<?php echo $row['image_uri'] ?>');
						}
						img.src = '<?php echo $row['image_uri'] ?>';
					</script>
	    	<?php
	    	if ($i==4 || $i==9) {
	    	?>
	    		</div>
	    	<?php
	    	}
	    	$i++;
	    }
	    $conn->close();

		?>
		<!-- <div class="row" id="popular-title" style="padding-left:10px;"></div>
		<div class="row" id="popular-row-1"></div>
		<div class="row" id="popular-row-2"></div> -->
		<script type="text/javascript">
			// $.ajax({
			// 	url: '<?php echo API_SERVER_URI; ?>/api/search/list',
			// 	type: 'POST',
			// 	dataType: 'json',
			// 	success: function(data) {
			// 		$('#popular-title').html('<hr><h3>POPULAR</h3>');
			// 		var popularRow1Html = '';
			// 		var popularRow2Html = '';
			// 		$.each(data.hits.hits, function(i,e) {
			// 			var v = e._source;
			// 			var html = '<div class="item-container text-center">\n ' + 
			// 							'	<span style="font-weight: bold;">'+v.Source+'</span><br>\n ' + 
			// 							'	<div style="text-overflow:ellipsis; white-space: nowrap; overflow: hidden; width: 100%">\n ' + 
			// 							'		<a onmousedown="popularSave(\''+v.Uri+'\')" href="'+v.Uri+'" target="_blank">'+v.Name+'</a>\n ' + 
			// 							'	</div>\n ' + 
			// 							'	<span style="font-size: 1.5em;">'+numberWithCommas(String(v.Price))+'</span><br>\n ' + 
			// 							'	<div class="cropped-image-container">\n ' + 
			// 							'		<a onmousedown="popularSave(\''+v.Uri+'\')" href="'+v.Uri+'" target="_blank">\n ' + 
			// 							'			<img class="cropped-image" style="max-width:100%;" src="assets/img/no-image.png" id="popular-preload-image_'+i+'" />\n ' + 
			// 							'		</a>\n ' + 
			// 							'	</div>\n ' + 
			// 							'</div>';
			// 			if (i<=4) {
			// 				popularRow1Html += html;
			// 			} else if (i<=9) {
			// 				popularRow2Html += html;
			// 			};

			// 			var img = new Image();
			// 			img.onload = function () {
			// 			   $('#popular-preload-image_'+i).attr('src',v.ImageUri);
			// 			}
			// 			img.src = v.ImageUri;
			// 		});
			// 		$('#popular-row-1').html(popularRow1Html);
			// 		$('#popular-row-2').html(popularRow2Html);
			// 	}.bind(this),
			// 	error: function(xhr, status, err) {
			// 		// EMPTY
			// 	}.bind(this),
			// 	data: JSON.stringify({
			// 		Id: id,
			// 		Token: token,
			// 		LoginType: 'fb',
			// 		Size: '10'
			// 	})
			// });
		</script>
	</div>

	<?php
	include_once 'inc/js_below.php';
	?>

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