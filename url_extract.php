<?php
if(!empty($_POST["url"]) && filter_var($_POST["url"], FILTER_VALIDATE_URL)) {		
	include_once("simplehtmldom/simple_html_dom.php");		
	
	//extracting HTML content for the URL 
	$content = file_get_html($_POST["url"]); 
	
	//Parsing Title 
	foreach($content->find('title') as $element) {
		$title = $element->plaintext;
	}
	
	//Parsing Body Content
	foreach($content->find('body') as $element) {
		$body_content =  implode(' ', array_slice(explode(' ', trim($element->plaintext)), 0, 50));
	}

	$image_url = array();
	
	//Parse Site Images
	foreach($content->find('img') as $element){
		if(filter_var($element->src, FILTER_VALIDATE_URL)){
			list($width,$height) = getimagesize($element->src);
			if($width>150 || $height>150){
				$image_url[] =  $element->src;	
			}
		}
	}
	$image_div = "";
	if(!empty($image_url[0])) {
		$image_div = "<div class='image-extract'>" .
		"<input type='hidden' id='index' value='0'/>" .
		"<img id='image_url' src='" . $image_url[0] . "' />";
		if(count($image_url)>1) {
		$image_div .= "<div>" .
		"<input type='button' class='btnNav' id='prev-extract' onClick=navigateImage(" . json_encode($image_url) . ",'prev') disabled />" .
		"<input type='button' class='btnNav' id='next-extract' target='_blank' onClick=navigateImage(" . json_encode($image_url) . ",'next') />" .
		"</div>";
		}
		$image_div .="</div>";
		
	}
	
	$output = $image_div . "<div class='content-extract'>" .
	"<h3><a href='" . $_POST["url"] . "' target='_blank'>" . $title . "</a></h3>" .
	"<div>" . $body_content . "</div>".
	"</div>";
	echo $output;
}
?>