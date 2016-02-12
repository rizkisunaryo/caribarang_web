<?php
include_once 'inc/constants.php';
include_once 'inc/js_above.php';
include_once 'inc/js_fb.php';

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

$curPage = isset($_GET['page']) ? intval($_GET['page']): 1;
$params=array(
		'form_category' => $_GET['form_category'],
		'form_keyword' => $_GET['form_keyword'],
		'form_min-price' => $_GET['form_min-price'],
		'form_max-price' => $_GET['form_max-price'],
	);
$params1=$params;
$params2=$params;
$params3=$params;
$params4=$params;
$params5=$params;

$liPage1 = '';
$liPage2 = '';
$liPage3 = '';
$liPage4 = '';
$liPage5 = '';
if ($curPage==1) {
	$params2['page'] = 2;
	$params3['page'] = 3;
	$params4['page'] = 4;
	$params5['page'] = 5;

	$liPage1 = '<li class="active"><a>1</a></li>';
	$liPage2 = '<li><a href=".?'.http_build_query($params2).'">2</a></li>';
	$liPage3 = '<li><a href=".?'.http_build_query($params3).'">3</a></li>';
	$liPage4 = '<li><a href=".?'.http_build_query($params4).'">4</a></li>';
	$liPage5 = '<li><a href=".?'.http_build_query($params5).'">5</a></li>';
} elseif ($curPage==2) {
	$params1['page'] = 1;
	$params3['page'] = 3;
	$params4['page'] = 4;
	$params5['page'] = 5;

	$liPage1 = '<li><a href=".?'.http_build_query($params1).'">1</a></li>';
	$liPage2 = '<li class="active"><a>2</a></li>';	
	$liPage3 = '<li><a href=".?'.http_build_query($params3).'">3</a></li>';
	$liPage4 = '<li><a href=".?'.http_build_query($params4).'">4</a></li>';
	$liPage5 = '<li><a href=".?'.http_build_query($params5).'">5</a></li>';
} else {
	$params1['page'] = $curPage-2;
	$params2['page'] = $curPage-1;
	$params4['page'] = $curPage+1;
	$params5['page'] = $curPage+2;

	$liPage1 = '<li><a href=".?'.http_build_query($params1).'">'.($curPage-2).'</a></li>';
	$liPage2 = '<li><a href=".?'.http_build_query($params2).'">'.($curPage-1).'</a></li>';
	$liPage3 = '<li class="active"><a>'.$curPage.'</a></li>';
	$liPage4 = '<li><a href=".?'.http_build_query($params4).'">'.($curPage+1).'</a></li>';
	$liPage5 = '<li><a href=".?'.http_build_query($params5).'">'.($curPage+2).'</a></li>';
}

$reqJson = array();
$reqJson['Category'] = $formCategory;
$reqJson['Subcategory'] = $formSubcategory;
$reqJson['Keyword'] = $formKeyword;
$reqJson['MinPrice'] = $formMinPrice;
$reqJson['MaxPrice'] = $formMaxPrice;
$reqJson['From'] = strval(($curPage-1)*10);
$reqJson['Size'] = '10';
$reqJsonStr = json_encode($reqJson);
?>

<?php
include_once 'inc/css.php';
?>

<div class="container">
	<div class="row text-center">
		<div class="col-sm-3"></div>
		<div class="col-sm-6 text-center" style="margin-bottom:20px;">
			<h1>CariBarang</h1>
		</div>
		<div class="col-sm-3">
		</div>
	</div>
	<div class="row" style="margin-bottom:10px;">
		<div class="col-sm-12">
			<div class="text-left" style="float:left;">
				<!-- <button type="button" class="btn btn-warning">SEARCH</button> -->
				<a href=".">HOME</a> | <a href="#" data-toggle="modal" data-target="#myModal">SEARCH</a>
				<!-- Modal -->
				<div class="modal fade" id="myModal" role="dialog">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">CariBarang</h4>
							</div>
							<div class="modal-body">
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

									    	$selected = '';
									    	if ($value==$_GET['form_category']) {
									    		$selected = ' selected="selected" ';
									    	} 
									        // echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
									    ?>

									    <option value="<?php echo $value; ?>" <?php echo $selected; ?>><?php echo $label; ?></option>

									    <?php
									    }						
										$conn->close();

										?>
									</select><br />
								    <input type="text" class="form-control" id="form_keyword" name="form_keyword" placeholder="Kata kunci" value="<?php echo $_GET['form_keyword']; ?>"><br />
								    <input type="tel" class="form-control" id="form_min-price" name="form_min-price" placeholder="Harga minimum" onkeypress="return isNumberKey(event);" onkeyup="this.value=numberWithCommas(this.value);" value="<?php echo $_GET['form_min-price']; ?>"><br />
								    <input type="tel" class="form-control" id="form_max-price" name="form_max-price" placeholder="Harga maximum" onkeypress="return isNumberKey(event);" onkeyup="this.value=numberWithCommas(this.value);" value="<?php echo $_GET['form_max-price']; ?>"><br />
								    <div class="text-right">
								    	<button type="submit" class="btn btn-default">C A R I</button>
								    </div>
								</form>
							</div>
							<!-- <div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">SEARCH</button>
							</div> -->
						</div>
					</div>
				</div>
			</div>
			<div class="text-right" style="float:right;">
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
		</div>
	</div>
	<div class="row" id="result-row-1"></div>
	<div class="row" id="result-row-2"></div>
	<div class="row">
		<div class="col-sm-4"></div>
		<div class="col-sm-4 text-center">
			<ul class="pagination">
				<li><a href=".?<?php echo http_build_query($params); ?>">&lt;&lt;</a></li>
				<?php echo $liPage1.$liPage2.$liPage3.$liPage4.$liPage5; ?>
			</ul>
		</div>
	</div>
</div>

<?php
include_once 'inc/js_below.php';
?>

<script type="text/javascript">
	$.ajax({
		url: '<?php echo API_SERVER_URI; ?>/api/search/list',
		type: 'POST',
		dataType: 'json',
		success: function(data) {
			var resultRow1Html = '';
			var resultRow2Html = '';
			$.each(data.hits.hits, function(i,e) {
				var v = e._source;
				var html = '<div class="item-container text-center">\n ' + 
							'	<span style="font-weight: bold;">'+v.Source+'</span><br>\n ' + 
							'	<div style="text-overflow:ellipsis; white-space: nowrap; overflow: hidden; width: 100%"><a onmousedown="popularSave(\''+v.Uri+'\')" href="'+v.Uri+'" target="_blank">'+v.Name+'</a></div>\n ' + 
							'	<span style="font-size: 1.5em;">'+numberWithCommas(String(v.Price))+'</span><br>\n ' + 
							'	<a onmousedown="popularSave(\''+v.Uri+'\')" href="'+v.Uri+'" target="_blank"><img style="max-width:100%;" src="assets/img/no-image.png" id="preload-image_'+i+'"></a>\n ' + 
							'</div>';
				if (i<=4) {
					resultRow1Html += html;
				} else if (i<=9) {
					resultRow2Html += html;
				}

				var img = new Image();
				img.onload = function () {
				   $('#preload-image_'+i).attr('src',v.ImageUri);
				}
				img.src = v.ImageUri;
			});
			$('#result-row-1').html(resultRow1Html);
			$('#result-row-2').html(resultRow2Html);
		}.bind(this),
		error: function(xhr, status, err) {
			
		}.bind(this),
		data: '<?php echo $reqJsonStr; ?>'
	});
</script>