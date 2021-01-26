<?php

	$app->get( '/checkout', function() use ( $app ) {
		$app->render( 'index.html' );
	} );

