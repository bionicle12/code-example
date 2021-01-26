<?php

	namespace models;

	use lib\HamtimAmocrm;

	class AmoConnector
	{
		protected $amo;

		private $login     = 'user';
		private $pass      = 'pass';
		private $subdomain = 'subdomain';

		const ID_PROMOCODES     = 9123;
		const ID_DISCOUNT_CARDS = 11721;
		const ID_GENETIC_PRICES = 11727;
		const ID_PRODUCTS       = 6141;

		const ID_PRICES = 11725;
		/*
		 * demo
		 const ID_PRICES         = 2479; */

		const MAX_PAGES = 10;

		function __construct()
		{
			$this->amo = new HamtimAmocrm( $this->login, $this->pass, $this->subdomain );
			if ( !$this->amo->auth ) {
				die( 'Нет соединения с amoCRM' );
			}
		}

		private function receiver( $path )
		{
			$arrays = [];
			for ( $i = 1; $i < self::MAX_PAGES; $i++ ) {
				$list = $this->amo->q( $path . '&page=' . $i );
				if ( !isset( $list->_embedded ) ) {
					break;
				}
				$arrays[] = $list->_embedded->items;
			}
			$result = [];
			array_walk_recursive( $arrays, function( $item, $key ) use ( &$result ) {
				$result[] = $item;
			} );
			return $result;
		}

		public function getPromocodes()
		{
			return $this->receiver( '/api/v2/catalog_elements?catalog_id=' . self::ID_PROMOCODES );
		}

		public function getDiscountCards()
		{
			return $this->receiver( '/api/v2/catalog_elements?catalog_id=' . self::ID_DISCOUNT_CARDS );
		}

		public function getPrices()
		{
			return $this->receiver( '/api/v2/catalog_elements?catalog_id=' . self::ID_PRICES );
		}

		public function getGeneticPrices()
		{
			return $this->receiver( '/api/v2/catalog_elements?catalog_id=' . self::ID_GENETIC_PRICES );
		}

		public function getProducts()
		{
			return $this->receiver( '/api/v2/catalog_elements?catalog_id=' . self::ID_PRODUCTS );
		}

		public function getContacts()
		{
			$arrays = [];
			$limit  = 500;
			for ( $i = 1; $i < self::MAX_PAGES; $i++ ) {
				$list = $this->amo->q( '/api/v2/contacts/?limit_rows=' . $limit . '&limit_offset=' . ( ( $i - 1 ) * $limit ) );
				if ( !isset( $list->_embedded ) ) {
					break;
				}
				$arrays[] = $list->_embedded->items;
			}
			$result = [];
			array_walk_recursive( $arrays, function( $item, $key ) use ( &$result ) {
				$result[] = $item;
			} );
			return $result;
		}

		public function getContactsLast( $offset )
		{
			$arrays = [];
			$limit  = 500;
			for ( $i = 1; $i < self::MAX_PAGES; $i++ ) {
				$list = $this->amo->q( '/api/v2/contacts/?limit_rows=' . $limit . '&limit_offset=' . $offset );
				if ( !isset( $list->_embedded ) ) {
					break;
				}
				$arrays[] = $list->_embedded->items;
			}
			$result = [];
			array_walk_recursive( $arrays, function( $item, $key ) use ( &$result ) {
				$result[] = $item;
			} );
			return $result;
		}

		// Send data to AmoCRM
		public function sendData( $path, $fields = [], $ifModifiedSince = false )
		{
			return $this->amo->q( $path, $fields, $ifModifiedSince );
		}

	}
