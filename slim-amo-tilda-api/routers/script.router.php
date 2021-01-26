<?php

	$app->get( '/script', function() use ( $app ) {

		$checkoutCode = file_get_contents('../public_html/js/checkout.js', FILE_USE_INCLUDE_PATH);

		$app->contentType( 'application/x-javascript' );
		echo $checkoutCode;
	} );

	$app->get( '/script/fias', function() use ( $app ) {

		$fiasCode = file_get_contents('../public_html/js/jquery.fias.min.js', FILE_USE_INCLUDE_PATH);

		$app->contentType( 'application/x-javascript' );
		echo $fiasCode;
	} );

	$app->get( '/style/fias', function() use ( $app ) {

		$fiasCode = file_get_contents('../public_html/js/jquery.fias.css', FILE_USE_INCLUDE_PATH);

		$app->contentType( 'text/css' );
		echo $fiasCode;
	} );