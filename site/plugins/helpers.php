<?php

function buildImage($imageSource) {
	$imageSizes = [
		'2400' => 2400,
		'1600' => 1600,
		'1200' => 1200,
		'800' => 800,
		'400' => 400
	];
	$image = new StdClass();
	if (!$imageSource) return $image;
	$image->srcset = [];
	$image->url = (string)$imageSource->url();
	$image->meta = $imageSource->meta()->toArray();
	array_push($image->srcset, array(
		'label' => 'original',
		'width' => $imageSource->width(),
		'height' => $imageSource->height(),
		'url' => $imageSource->url(),
		'isOriginal' => true,
	));
	// consoleLog(gettype($imageSource->width()));
	foreach ($imageSizes as $label => $width) {
		if ($imageSource->width() > $width) {
			$thumbnail = [
				'label' => $label,
				'width' => $width,
				'url' => thumb($imageSource, array('width' => $width), false)];
			array_push($image->srcset, $thumbnail);
		}
	}
	$image->isCover = $imageSource === $imageSource->page()->cover();
	return $image;
}

function smellsLikeNum($input) {
	if (gettype($input) !== 'string') return false;
	preg_match('/^[0-9,]+(.[0-9]+)?$/', $input, $output);
	// print_r($output);
	return (count($output) > 0);
}

function smellsLikeYaml($input) {
	if (gettype($input) !== 'string') return false;
	if (strlen($input) === 0) return false;
	$yamlArray = '/^-[\n\r\s]+[a-z]*:/';
	preg_match($yamlArray, $input, $output);
	return (count($output) > 0);
};

function smellsLikeBool($input) {
	if ($input === 'true' || $input === 'false') return true;
	return false;
}


 ?>
