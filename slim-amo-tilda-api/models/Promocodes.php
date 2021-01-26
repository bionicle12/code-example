<?php

	namespace models;

	use PDO;

	class Promocodes extends Database
	{
		const TABLE = 'promocodes';

		private $description;
		private $discount;
		private $used;
		private $limit;
		private $expired;

		public function __construct()
		{
			parent::__construct();
		}

		public function save()
		{
			$sql = "INSERT INTO " . self::TABLE . " (`crm_id`, `name`, `description`, `discount`, `used`, `limit`, `expired`) 
					VALUES (:crm_id, :name, :description, :discount, :used, :limit, :expired)";

			$stmt = $this->core->dbh->prepare( $sql );

			$stmt->bindParam( ':crm_id', $this->crm_id, PDO::PARAM_INT );
			$stmt->bindParam( ':name', $this->name, PDO::PARAM_STR );

			$stmt->bindParam( ':description', $this->description, PDO::PARAM_STR );
			$stmt->bindParam( ':discount', $this->discount, PDO::PARAM_STR );
			$stmt->bindParam( ':used', $this->used, PDO::PARAM_INT );
			$stmt->bindParam( ':limit', $this->limit, PDO::PARAM_INT );
			$stmt->bindParam( ':expired', $this->expired, PDO::PARAM_STR );

			$stmt->execute();
		}

		public function setDescription( $arg )
		{
			$this->description = $arg;
		}

		public function setDiscount( $arg )
		{
			$this->discount = $arg;
		}

		public function setUsed( $arg )
		{
			$this->used = $arg;
		}

		public function setLimit( $arg )
		{
			$this->limit = $arg;
		}

		public function setExpired( $arg )
		{
			$this->expired = $arg;
		}

		public function check( $code )
		{
			$sql  = "SELECT `name`, `discount`, `used`, `limit`, `expired` FROM " . self::TABLE . " WHERE `name`=:code";
			$stmt = $this->core->dbh->prepare( $sql );
			$stmt->bindParam( ':code', $code );

			if ( $stmt->execute() ) {
				$r = $stmt->fetchAll( PDO::FETCH_ASSOC );

				if ( count( $r ) ) {
					$is_wrong = false;

					$date_expired = strtotime( $r[0]['expired'] );
					date_default_timezone_set( 'Asia/Novosibirsk' );
					$date = strtotime( date( 'Y-m-d' ) );
					if ( $date > $date_expired ) {
						$is_wrong = true;
					}

					if ( !$is_wrong ) {
						$used  = (int)$r[0]['used'];
						$limit = (int)$r[0]['limit'];
						if ( $used >= $limit ) {
							$is_wrong = true;
						}
					}

					if ( $is_wrong ) {
						$r = [];
					}
				} else {
					$r = [];
				}

			} else {
				$r = [];
			}
			return $r;
		}

		public function updatePromocode( $code )
		{
			$sql  = "SELECT `crm_id`, `used` FROM " . self::TABLE . " WHERE `name`=:code";
			$stmt = $this->core->dbh->prepare( $sql );
			$stmt->bindParam( ':code', $code );

			if ( $stmt->execute() ) {
				$r = $stmt->fetchAll( PDO::FETCH_ASSOC );

				$used_updated = (int)$r[0]['used'] + 1;

				$sql  = "UPDATE " . self::TABLE . " SET used=? WHERE name=?";
				$stmt = $this->core->dbh->prepare( $sql );
				$stmt->execute( [
				  $used_updated,
				  $code
				] );

				return ['crm_id' => (int)$r[0]['crm_id'], 'used' => $used_updated];
			}
			return [];
		}

	}
