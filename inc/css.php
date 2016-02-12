<style type="text/css">

div.item-container {
	border-color: lightblue;
    border-radius: 5px;
    border-style: solid;
    border-width: 1px;
    margin:0 auto;
    margin-top: 15px;
    padding: 5px;
    width: 90%;
}

@media all and (min-width: 768px) {
  	div.item-container {
		border-color: lightblue;
	    border-radius: 5px;
	    border-style: solid;
	    border-width: 1px;
	    display: inline-block;
	    margin-bottom: 10px;
	    margin-right: 1%;
	    padding: 5px;
	    width: 19%;
	}
	div.cropped-image-container {
		width: 131px;
	    height: 131px;
	    overflow: hidden;
	    position: relative;
	}
	.cropped-image {
		position: absolute;
	    left: -1000%;
	    right: -1000%;
	    top: -1000%;
	    bottom: -1000%;
	    margin: auto;
	    min-height: 100%;
	    min-width: 100%;
	}
}

@media all and (min-width: 992px) {
	div.cropped-image-container {
		width: 172px;
	    height: 172px;
	    overflow: hidden;
	    position: relative;
	}
}

@media all and (min-width: 1200px) {
	div.cropped-image-container {
		width: 210px;
	    height: 210px;
	    overflow: hidden;
	    position: relative;
	}
}
</style>