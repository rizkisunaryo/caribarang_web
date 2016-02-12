<?php
	include_once 'inc/js_above.php';
	include_once 'inc/js_fb.php';
	include_once 'inc/css.php';
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



		<div class="row"><hr><h3>SUGGESTIONS</h3></div>

		<div class="row" id="result-row-1">
			<div class="item-container text-center">
			 	<span style="font-weight: bold;">Kaskus</span><br>
			 	<div style="text-overflow:ellipsis; white-space: nowrap; overflow: hidden; width: 100%"><a onmousedown="popularSave('http://fjb.kaskus.co.id/post/56aa87dcd89b09c8458b4572#post56aa87dcd89b09c8458b4572')" href="http://fjb.kaskus.co.id/post/56aa87dcd89b09c8458b4572#post56aa87dcd89b09c8458b4572" target="_blank">HP TERMURAH SEJAGAD RAYA!! surabaya sidoarjo . samsung iphone oppo asus</a></div>
			 	<span style="font-size: 1.5em;">123</span><br>
			 	<a onmousedown="popularSave('http://fjb.kaskus.co.id/post/56aa87dcd89b09c8458b4572#post56aa87dcd89b09c8458b4572')" href="http://fjb.kaskus.co.id/post/56aa87dcd89b09c8458b4572#post56aa87dcd89b09c8458b4572" target="_blank"><img style="max-width:100%;" src="assets/img/no-image.png" id="preload-image_0"></a>
			</div>
			<div class="item-container text-center">
			 	<span style="font-weight: bold;">bukalapak</span><br>
			 	<div style="text-overflow:ellipsis; white-space: nowrap; overflow: hidden; width: 100%"><a onmousedown="popularSave('http://www.bukalapak.com/p/handphone/hp-smartphone/vddr4-jual-nokia-105-mulus-gan')" href="http://www.bukalapak.com/p/handphone/hp-smartphone/vddr4-jual-nokia-105-mulus-gan" target="_blank">nokia 105 mulus gan</a></div>
			 	<span style="font-size: 1.5em;">200</span><br>
			 	<a onmousedown="popularSave('http://www.bukalapak.com/p/handphone/hp-smartphone/vddr4-jual-nokia-105-mulus-gan')" href="http://www.bukalapak.com/p/handphone/hp-smartphone/vddr4-jual-nokia-105-mulus-gan" target="_blank"><img style="max-width:100%;" src="https://s2.bukalapak.com/img/1/4/3/4/9/0/3/5/2/medium/20160130_130856_scaled.jpg" id="preload-image_1"></a>
			</div>
			<div class="item-container text-center">
			 	<span style="font-weight: bold;">bukalapak</span><br>
			 	<div style="text-overflow:ellipsis; white-space: nowrap; overflow: hidden; width: 100%"><a onmousedown="popularSave('http://www.bukalapak.com/p/handphone/hp-smartphone/vsyia-jual-lumia-625h-minus')" href="http://www.bukalapak.com/p/handphone/hp-smartphone/vsyia-jual-lumia-625h-minus" target="_blank">Lumia 625H Minus</a></div>
			 	<span style="font-size: 1.5em;">400</span><br>
			 	<a onmousedown="popularSave('http://www.bukalapak.com/p/handphone/hp-smartphone/vsyia-jual-lumia-625h-minus')" href="http://www.bukalapak.com/p/handphone/hp-smartphone/vsyia-jual-lumia-625h-minus" target="_blank"><img style="max-width:100%;" src="https://s4.bukalapak.com/img/1/4/5/3/0/9/9/5/4/medium/IMG_20160101_145036_HDR_scaled.jpg" id="preload-image_2"></a>
			</div>
			<div class="item-container text-center">
			 	<span style="font-weight: bold;">bukalapak</span><br>
			 	<div style="text-overflow:ellipsis; white-space: nowrap; overflow: hidden; width: 100%"><a onmousedown="popularSave('http://www.bukalapak.com/p/handphone/hp-smartphone/uwubk-jual-bluboo-fire-x-2-3g-fingerpint-id-smartpone-metal-5-0-android-5-1-mtk6580-quad-core-1-2ghz-1gb-ram-8gb-rom-dual-camera-2-5d-screen')" href="http://www.bukalapak.com/p/handphone/hp-smartphone/uwubk-jual-bluboo-fire-x-2-3g-fingerpint-id-smartpone-metal-5-0-android-5-1-mtk6580-quad-core-1-2ghz-1gb-ram-8gb-rom-dual-camera-2-5d-screen" target="_blank">BLUBOO FIRE X 2 3G FINGERPINT ID Smartpone Metal 5.0" Android 5.1 MTK6580 Quad Core 1.2GHz 1GB RAM 8GB ROM Dual Camera 2.5D Screen</a></div>
			 	<span style="font-size: 1.5em;">500</span><br>
			 	<a onmousedown="popularSave('http://www.bukalapak.com/p/handphone/hp-smartphone/uwubk-jual-bluboo-fire-x-2-3g-fingerpint-id-smartpone-metal-5-0-android-5-1-mtk6580-quad-core-1-2ghz-1gb-ram-8gb-rom-dual-camera-2-5d-screen')" href="http://www.bukalapak.com/p/handphone/hp-smartphone/uwubk-jual-bluboo-fire-x-2-3g-fingerpint-id-smartpone-metal-5-0-android-5-1-mtk6580-quad-core-1-2ghz-1gb-ram-8gb-rom-dual-camera-2-5d-screen" target="_blank"><img style="max-width:100%;" src="https://s3.bukalapak.com/img/1/4/2/1/7/5/5/2/8/medium/IMG_20160128_201224.JPG" id="preload-image_3"></a>
			</div>
			<div class="item-container text-center">
			 	<span style="font-weight: bold;">bukalapak</span><br>
			 	<div style="text-overflow:ellipsis; white-space: nowrap; overflow: hidden; width: 100%"><a onmousedown="popularSave('http://www.bukalapak.com/p/handphone/hp-smartphone/vgnls-jual-lenovo-a369i')" href="http://www.bukalapak.com/p/handphone/hp-smartphone/vgnls-jual-lenovo-a369i" target="_blank">LENOVO a369i</a></div>
			 	<span style="font-size: 1.5em;">500</span><br>
				<a onmousedown="popularSave('http://www.bukalapak.com/p/handphone/hp-smartphone/vgnls-jual-lenovo-a369i')" href="http://www.bukalapak.com/p/handphone/hp-smartphone/vgnls-jual-lenovo-a369i" target="_blank"><img style="max-width:100%;" src="https://www.bukalapak.com/img/1/4/3/8/8/3/5/4/4/medium/20160131_165513_scaled.jpg" id="preload-image_4"></a>
			</div>
		</div>



		<div class="row"><hr><h3>POPULAR</h3></div>

		<div class="row" id="result-row-1">
			<div class="item-container text-center">
			 	<span style="font-weight: bold;">Kaskus</span><br>
			 	<div style="text-overflow:ellipsis; white-space: nowrap; overflow: hidden; width: 100%"><a onmousedown="popularSave('http://fjb.kaskus.co.id/post/56aa87dcd89b09c8458b4572#post56aa87dcd89b09c8458b4572')" href="http://fjb.kaskus.co.id/post/56aa87dcd89b09c8458b4572#post56aa87dcd89b09c8458b4572" target="_blank">HP TERMURAH SEJAGAD RAYA!! surabaya sidoarjo . samsung iphone oppo asus</a></div>
			 	<span style="font-size: 1.5em;">123</span><br>
			 	<a onmousedown="popularSave('http://fjb.kaskus.co.id/post/56aa87dcd89b09c8458b4572#post56aa87dcd89b09c8458b4572')" href="http://fjb.kaskus.co.id/post/56aa87dcd89b09c8458b4572#post56aa87dcd89b09c8458b4572" target="_blank"><img style="max-width:100%;" src="assets/img/no-image.png" id="preload-image_0"></a>
			</div>
			<div class="item-container text-center">
			 	<span style="font-weight: bold;">bukalapak</span><br>
			 	<div style="text-overflow:ellipsis; white-space: nowrap; overflow: hidden; width: 100%"><a onmousedown="popularSave('http://www.bukalapak.com/p/handphone/hp-smartphone/vddr4-jual-nokia-105-mulus-gan')" href="http://www.bukalapak.com/p/handphone/hp-smartphone/vddr4-jual-nokia-105-mulus-gan" target="_blank">nokia 105 mulus gan</a></div>
			 	<span style="font-size: 1.5em;">200</span><br>
			 	<a onmousedown="popularSave('http://www.bukalapak.com/p/handphone/hp-smartphone/vddr4-jual-nokia-105-mulus-gan')" href="http://www.bukalapak.com/p/handphone/hp-smartphone/vddr4-jual-nokia-105-mulus-gan" target="_blank"><img style="max-width:100%;" src="https://s2.bukalapak.com/img/1/4/3/4/9/0/3/5/2/medium/20160130_130856_scaled.jpg" id="preload-image_1"></a>
			</div>
			<div class="item-container text-center">
			 	<span style="font-weight: bold;">bukalapak</span><br>
			 	<div style="text-overflow:ellipsis; white-space: nowrap; overflow: hidden; width: 100%"><a onmousedown="popularSave('http://www.bukalapak.com/p/handphone/hp-smartphone/vsyia-jual-lumia-625h-minus')" href="http://www.bukalapak.com/p/handphone/hp-smartphone/vsyia-jual-lumia-625h-minus" target="_blank">Lumia 625H Minus</a></div>
			 	<span style="font-size: 1.5em;">400</span><br>
			 	<a onmousedown="popularSave('http://www.bukalapak.com/p/handphone/hp-smartphone/vsyia-jual-lumia-625h-minus')" href="http://www.bukalapak.com/p/handphone/hp-smartphone/vsyia-jual-lumia-625h-minus" target="_blank"><img style="max-width:100%;" src="https://s4.bukalapak.com/img/1/4/5/3/0/9/9/5/4/medium/IMG_20160101_145036_HDR_scaled.jpg" id="preload-image_2"></a>
			</div>
			<div class="item-container text-center">
			 	<span style="font-weight: bold;">bukalapak</span><br>
			 	<div style="text-overflow:ellipsis; white-space: nowrap; overflow: hidden; width: 100%"><a onmousedown="popularSave('http://www.bukalapak.com/p/handphone/hp-smartphone/uwubk-jual-bluboo-fire-x-2-3g-fingerpint-id-smartpone-metal-5-0-android-5-1-mtk6580-quad-core-1-2ghz-1gb-ram-8gb-rom-dual-camera-2-5d-screen')" href="http://www.bukalapak.com/p/handphone/hp-smartphone/uwubk-jual-bluboo-fire-x-2-3g-fingerpint-id-smartpone-metal-5-0-android-5-1-mtk6580-quad-core-1-2ghz-1gb-ram-8gb-rom-dual-camera-2-5d-screen" target="_blank">BLUBOO FIRE X 2 3G FINGERPINT ID Smartpone Metal 5.0" Android 5.1 MTK6580 Quad Core 1.2GHz 1GB RAM 8GB ROM Dual Camera 2.5D Screen</a></div>
			 	<span style="font-size: 1.5em;">500</span><br>
			 	<a onmousedown="popularSave('http://www.bukalapak.com/p/handphone/hp-smartphone/uwubk-jual-bluboo-fire-x-2-3g-fingerpint-id-smartpone-metal-5-0-android-5-1-mtk6580-quad-core-1-2ghz-1gb-ram-8gb-rom-dual-camera-2-5d-screen')" href="http://www.bukalapak.com/p/handphone/hp-smartphone/uwubk-jual-bluboo-fire-x-2-3g-fingerpint-id-smartpone-metal-5-0-android-5-1-mtk6580-quad-core-1-2ghz-1gb-ram-8gb-rom-dual-camera-2-5d-screen" target="_blank"><img style="max-width:100%;" src="https://s3.bukalapak.com/img/1/4/2/1/7/5/5/2/8/medium/IMG_20160128_201224.JPG" id="preload-image_3"></a>
			</div>
			<div class="item-container text-center">
			 	<span style="font-weight: bold;">bukalapak</span><br>
			 	<div style="text-overflow:ellipsis; white-space: nowrap; overflow: hidden; width: 100%"><a onmousedown="popularSave('http://www.bukalapak.com/p/handphone/hp-smartphone/vgnls-jual-lenovo-a369i')" href="http://www.bukalapak.com/p/handphone/hp-smartphone/vgnls-jual-lenovo-a369i" target="_blank">LENOVO a369i</a></div>
			 	<span style="font-size: 1.5em;">500</span><br>
				<a onmousedown="popularSave('http://www.bukalapak.com/p/handphone/hp-smartphone/vgnls-jual-lenovo-a369i')" href="http://www.bukalapak.com/p/handphone/hp-smartphone/vgnls-jual-lenovo-a369i" target="_blank"><img style="max-width:100%;" src="https://www.bukalapak.com/img/1/4/3/8/8/3/5/4/4/medium/20160131_165513_scaled.jpg" id="preload-image_4"></a>
			</div>
		</div>

		<div class="row" id="result-row-1">
			<div class="item-container text-center">
			 	<span style="font-weight: bold;">Kaskus</span><br>
			 	<div style="text-overflow:ellipsis; white-space: nowrap; overflow: hidden; width: 100%"><a onmousedown="popularSave('http://fjb.kaskus.co.id/post/56aa87dcd89b09c8458b4572#post56aa87dcd89b09c8458b4572')" href="http://fjb.kaskus.co.id/post/56aa87dcd89b09c8458b4572#post56aa87dcd89b09c8458b4572" target="_blank">HP TERMURAH SEJAGAD RAYA!! surabaya sidoarjo . samsung iphone oppo asus</a></div>
			 	<span style="font-size: 1.5em;">123</span><br>
			 	<a onmousedown="popularSave('http://fjb.kaskus.co.id/post/56aa87dcd89b09c8458b4572#post56aa87dcd89b09c8458b4572')" href="http://fjb.kaskus.co.id/post/56aa87dcd89b09c8458b4572#post56aa87dcd89b09c8458b4572" target="_blank"><img style="max-width:100%;" src="assets/img/no-image.png" id="preload-image_0"></a>
			</div>
			<div class="item-container text-center">
			 	<span style="font-weight: bold;">bukalapak</span><br>
			 	<div style="text-overflow:ellipsis; white-space: nowrap; overflow: hidden; width: 100%"><a onmousedown="popularSave('http://www.bukalapak.com/p/handphone/hp-smartphone/vddr4-jual-nokia-105-mulus-gan')" href="http://www.bukalapak.com/p/handphone/hp-smartphone/vddr4-jual-nokia-105-mulus-gan" target="_blank">nokia 105 mulus gan</a></div>
			 	<span style="font-size: 1.5em;">200</span><br>
			 	<a onmousedown="popularSave('http://www.bukalapak.com/p/handphone/hp-smartphone/vddr4-jual-nokia-105-mulus-gan')" href="http://www.bukalapak.com/p/handphone/hp-smartphone/vddr4-jual-nokia-105-mulus-gan" target="_blank"><img style="max-width:100%;" src="https://s2.bukalapak.com/img/1/4/3/4/9/0/3/5/2/medium/20160130_130856_scaled.jpg" id="preload-image_1"></a>
			</div>
			<div class="item-container text-center">
			 	<span style="font-weight: bold;">bukalapak</span><br>
			 	<div style="text-overflow:ellipsis; white-space: nowrap; overflow: hidden; width: 100%"><a onmousedown="popularSave('http://www.bukalapak.com/p/handphone/hp-smartphone/vsyia-jual-lumia-625h-minus')" href="http://www.bukalapak.com/p/handphone/hp-smartphone/vsyia-jual-lumia-625h-minus" target="_blank">Lumia 625H Minus</a></div>
			 	<span style="font-size: 1.5em;">400</span><br>
			 	<a onmousedown="popularSave('http://www.bukalapak.com/p/handphone/hp-smartphone/vsyia-jual-lumia-625h-minus')" href="http://www.bukalapak.com/p/handphone/hp-smartphone/vsyia-jual-lumia-625h-minus" target="_blank"><img style="max-width:100%;" src="https://s4.bukalapak.com/img/1/4/5/3/0/9/9/5/4/medium/IMG_20160101_145036_HDR_scaled.jpg" id="preload-image_2"></a>
			</div>
			<div class="item-container text-center">
			 	<span style="font-weight: bold;">bukalapak</span><br>
			 	<div style="text-overflow:ellipsis; white-space: nowrap; overflow: hidden; width: 100%"><a onmousedown="popularSave('http://www.bukalapak.com/p/handphone/hp-smartphone/uwubk-jual-bluboo-fire-x-2-3g-fingerpint-id-smartpone-metal-5-0-android-5-1-mtk6580-quad-core-1-2ghz-1gb-ram-8gb-rom-dual-camera-2-5d-screen')" href="http://www.bukalapak.com/p/handphone/hp-smartphone/uwubk-jual-bluboo-fire-x-2-3g-fingerpint-id-smartpone-metal-5-0-android-5-1-mtk6580-quad-core-1-2ghz-1gb-ram-8gb-rom-dual-camera-2-5d-screen" target="_blank">BLUBOO FIRE X 2 3G FINGERPINT ID Smartpone Metal 5.0" Android 5.1 MTK6580 Quad Core 1.2GHz 1GB RAM 8GB ROM Dual Camera 2.5D Screen</a></div>
			 	<span style="font-size: 1.5em;">500</span><br>
			 	<a onmousedown="popularSave('http://www.bukalapak.com/p/handphone/hp-smartphone/uwubk-jual-bluboo-fire-x-2-3g-fingerpint-id-smartpone-metal-5-0-android-5-1-mtk6580-quad-core-1-2ghz-1gb-ram-8gb-rom-dual-camera-2-5d-screen')" href="http://www.bukalapak.com/p/handphone/hp-smartphone/uwubk-jual-bluboo-fire-x-2-3g-fingerpint-id-smartpone-metal-5-0-android-5-1-mtk6580-quad-core-1-2ghz-1gb-ram-8gb-rom-dual-camera-2-5d-screen" target="_blank"><img style="max-width:100%;" src="https://s3.bukalapak.com/img/1/4/2/1/7/5/5/2/8/medium/IMG_20160128_201224.JPG" id="preload-image_3"></a>
			</div>
			<div class="item-container text-center">
			 	<span style="font-weight: bold;">bukalapak</span><br>
			 	<div style="text-overflow:ellipsis; white-space: nowrap; overflow: hidden; width: 100%"><a onmousedown="popularSave('http://www.bukalapak.com/p/handphone/hp-smartphone/vgnls-jual-lenovo-a369i')" href="http://www.bukalapak.com/p/handphone/hp-smartphone/vgnls-jual-lenovo-a369i" target="_blank">LENOVO a369i</a></div>
			 	<span style="font-size: 1.5em;">500</span><br>
				<a onmousedown="popularSave('http://www.bukalapak.com/p/handphone/hp-smartphone/vgnls-jual-lenovo-a369i')" href="http://www.bukalapak.com/p/handphone/hp-smartphone/vgnls-jual-lenovo-a369i" target="_blank"><img style="max-width:100%;" src="https://www.bukalapak.com/img/1/4/3/8/8/3/5/4/4/medium/20160131_165513_scaled.jpg" id="preload-image_4"></a>
			</div>
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