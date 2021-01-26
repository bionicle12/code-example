<?php

	use models\AmoConnector;
	use models\Breeds;
	use models\Contacts;
	use models\DiscountCards;
	use models\GeneticPrices;
	use models\Orders;
	use models\Prices;
	use models\Products;
	use models\Promocodes;

	$app->get( '/cart', function() use ( $app ) {
		$app->contentType( 'application/json' );
		echo json_encode( 'get cart data' );
	} );

	$app->post( '/cart', function() use ( $app ) {

		$order = new Orders();

		$orderData = json_decode( $app->request->post()['data'] );
		$fileLink  = $order->create( $orderData, $_FILES );

		$order->save();
		$last_id = $order->lastId();

		$order = $orderData->order;

		// Получение ID клиента из базы
		// @array [ id, dogs, tests ]
		$contact_id = ( new Contacts() )->searchContact( ['phone' => $order->phone, 'email' => $order->email] );

		// AmoConnector and send
		// removed

		$app->contentType( 'application/json' );
		echo json_encode( ['error' => false, 'message' => 'Заказ создан! #' . $last_id] );
	} );

	$app->get( '/cart/breeds', function() use ( $app ) {
		$result = ( new Breeds )->getAll();
		$app->contentType( 'application/json' );
		echo json_encode( $result );
	} );

	$app->post( '/cart/discount', function() use ( $app ) {
		$code = $app->request->post( 'code' );
		$data = ( new DiscountCards )->check( $code );

		if ( count( $data ) ) {
			$response = ['error' => false, 'message' => $data[0]];
		} else {
			$response = ['error' => true, 'message' => 'Неверный номер!'];
		}

		$app->contentType( 'application/json' );
		echo json_encode( $response );
	} );

	$app->get( '/cart/genetic_prices', function() use ( $app ) {
		$result = ( new GeneticPrices )->getAll();
		$app->contentType( 'application/json' );
		echo json_encode( $result );
	} );

	$app->get( '/cart/prices', function() use ( $app ) {
		$result = ( new Prices )->getAll();
		$app->contentType( 'application/json' );
		echo json_encode( $result );
	} );

	$app->get( '/cart/products', function() use ( $app ) {
		$result = ( new Products )->getAll();
		$app->contentType( 'application/json' );
		echo json_encode( $result );
	} );

	$app->post( '/cart/promocode', function() use ( $app ) {
		$code = $app->request->post( 'code' );
		$data = ( new Promocodes )->check( $code );

		if ( count( $data ) ) {
			$response = ['error' => false, 'message' => $data[0]];
		} else {
			$response = ['error' => true, 'message' => 'Неверный номер!'];
		}

		$app->contentType( 'application/json' );
		echo json_encode( $response );
	} );

