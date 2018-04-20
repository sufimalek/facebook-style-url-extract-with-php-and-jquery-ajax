<html>
<head>
<title>Facebook Style URL Extract with PHP and jQuery AJAX</title>
<style>
body{width:610;}
#url {width: 100%;padding: 10px;border: 1px solid #F0F0F0;}
#output{display:none;border: 1px solid #F0F0F0;overflow:hidden;padding:10px;}
.image-extract{max-width:580px;text-align:center;}
.btnNav{width:26px;height:26px;border:0;cursor:pointer;margin-top:10px}
#prev-extract {background:url('previous.jpg');}
#next-extract {background:url('next.jpg');}
#prev-extract:disabled {opacity:0.5;}
#next-extract:disabled {opacity:0.5;}
</style>
<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
<script type="text/javascript">
function extractURL() {
	var val=document.getElementById("url").value;
	if(val!="" && val.indexOf("://")>-1) {
			  
		$.ajax({
			url: "url_extract.php",
			data:'url='+$('#url').val(),
			type: "POST",
			beforeSend:function(data){   
				$("#url").css("background","#FFF url(LoaderIcon.gif) no-repeat right center");
			},
			success: function(responseData){  
				$("#output").html(responseData); 
				$("#output").slideDown(); 
				$("#url").removeAttr("onkeyup");
				$("#url").css("background","");
			}
		});
	}
}
function navigateImage(urlAry,nav) {
	var urlArrayLength = urlAry.length;
	var index = $('#index').val();
	$('#prev-extract').prop('disabled',false);
	$('#next-extract').prop('disabled',false);
	if(nav=='prev') {
		if(index!=0) {
			var prev_index = (parseInt(index)-1);
			$('#index').val(prev_index);
			$(".image-extract img").attr('src', urlAry[prev_index]);
			if(prev_index==0) $('#prev-extract').prop('disabled',true);
		}
	}
	if(nav=='next') {
		if(index<urlArrayLength-1) {
			var next_index = (parseInt(index)+1);
			$('#index').val(next_index);
			$(".image-extract img").attr('src', urlAry[next_index]);
			if(next_index>=urlArrayLength-1) $('#next-extract').prop('disabled',true);
		}
	}
}
</script>
<body>
<div id="frm-extract">
    <textarea id="url" placeholder="Enter the URL" onKeyup="extractURL()"></textarea>
    <div id="output"></div>
</div>
</body>
</html>