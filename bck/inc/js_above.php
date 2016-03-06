<script type="text/javascript">
	// input for number only
	function isNumberKey(evt){
	    var charCode = (evt.which) ? evt.which : evt.keyCode
	    return !(charCode > 31 && (charCode < 48 || charCode > 57));
	}
	function numberWithCommas(x) {
	    //remove commas
	    retVal = x ? parseFloat(x.replace(/,/g, '')) : 0;
	    if (retVal==0) return '';

	    //apply formatting
	    return retVal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}
</script>