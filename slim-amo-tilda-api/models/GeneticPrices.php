<?php

	namespace models;

	use PDO;

	class GeneticPrices extends Database
	{

		const TABLE = 'genetic_prices';

		private $sku;
		private $count;
		private $price;

		public function __construct()
		{
			parent::__construct();
		}

		public function save()
		{
			$sql = "INSERT INTO " . self::TABLE . " (`crm_id`, `sku`, `name`, `count`, `price`) 
					VALUES (:crm_id, :sku, :name, :count, :price)";

			$stmt = $this->core->dbh->prepare( $sql );

			$stmt->bindParam( ':crm_id', $this->crm_id, PDO::PARAM_INT );
			$stmt->bindParam( ':name', $this->name, PDO::PARAM_STR );

			$stmt->bindParam( ':sku', $this->sku, PDO::PARAM_INT );
			$stmt->bindParam( ':count', $this->count, PDO::PARAM_INT );
			$stmt->bindParam( ':price', $this->price, PDO::PARAM_INT );

			$stmt->execute();
		}

		public function setSku( $arg )
		{
			$this->sku = $arg;
		}

		public function setCount( $arg )
		{
			$this->count = $arg;
		}

		public function setPrice( $arg )
		{
			$this->price = $arg;
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
	}
