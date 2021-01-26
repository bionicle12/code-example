<?php

	namespace models;

	use DateTime;
	use lib\Config;
	use PDO;

	class Orders extends Database
	{

		const TABLE = 'orders';

		private $cart;
		private $img_url;

		public function __construct()
		{
			parent::__construct();
		}

		public function lastId()
		{
			return $this->core->dbh->lastInsertId();
		}

		public function save()
		{
			$sql = "INSERT INTO " . self::TABLE . " (`cart`, `img_url`) 
					VALUES (:cart, :img_url)";

			$stmt = $this->core->dbh->prepare( $sql );

			$stmt->bindParam( ':cart', $this->cart, PDO::PARAM_STR );
			$stmt->bindParam( ':img_url', $this->img_url, PDO::PARAM_STR );

			$stmt->execute();
		}

		public function create( $data, $files )
		{
			$this->cart    = json_encode( $data->order );
			$this->img_url = '';

			if ( count( $files ) > 0 ) {
				$this->img_url = $this->getImageUrl( $files );
				return $this->img_url;
			}
			return null;
		}

		private function fileName( $name )
		{
			$name = preg_replace( "/[^A-Za-z0-9.]/", '', $name );
			// оставляем 12 с конца
			if ( strlen( $name ) > 10 ) {
				$name = substr( $name, -10 );
			}

			$date = new DateTime();
			$name = $date->getTimestamp() . '_' . $name;

			return $name;
		}

		private function getImageUrl( $files )
		{
			$uploaddir = $_SERVER["DOCUMENT_ROOT"] . '/uploads/';
			$img_url   = '';

			$name    = $this->fileName( $files['file']['name'][0] );
			$img_url .= Config::read( 'path' ) . '/uploads/' . $name;

			$uploadfile = $uploaddir . basename( $name );
			move_uploaded_file( $files['file']['tmp_name'][0], $uploadfile );

			return $img_url;
		}

		public function getAll()
		{
			$sql  = "SELECT * FROM " . self::TABLE;
			$stmt = $this->core->dbh->prepare( $sql );

			if ( $stmt->execute() ) {
				$r = $stmt->fetchAll( PDO::FETCH_ASSOC );
			} else {
				$r = 0;
			}
			return $r;
		}

		public function updateOrder($object){
			$sql = "UPDATE " . self::TABLE . " SET crm_id=? WHERE id=?";
			$stmt = $this->core->dbh->prepare( $sql );
			$stmt->execute([
			  $object['crm_id'],
			  $object['id']
			]);

			return true;
		}

		public function getOrderById( $id )
		{
			$sql  = "SELECT * FROM " . self::TABLE . " WHERE `id`=" . (int)$id;
			$stmt = $this->core->dbh->prepare( $sql );

			if ( $stmt->execute() ) {
				$r = $stmt->fetchAll( PDO::FETCH_ASSOC );
			} else {
				$r = 0;
			}
			return $r;
		}

	}
