<?php
	include_once 'inc/js_above.php';
?>

	<div class="container">
		<div class="jumbotron">
			<h1>caribarang</h1>
			<p style="color:blue;">Mau belanja online? Cari aja di sini!</p>
		</div>

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