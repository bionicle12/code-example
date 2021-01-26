<?php

	namespace models;

	use PDO;

	class Prices extends Database
	{

		const TABLE = 'prices';

		private $price;
		private $position;
		private $type;

		public function __construct()
		{
			parent::__construct();
		}

		public function save()
		{
			$sql = "INSERT INTO " . self::TABLE . " (`crm_id`, `price`, `name`, `position`, `type`) 
					VALUES (:crm_id, :price, :name, :position, :type)";

			$stmt = $this->core->dbh->prepare( $sql );

			$stmt->bindParam( ':crm_id', $this->crm_id, PDO::PARAM_INT );
			$stmt->bindParam( ':name', $this->name, PDO::PARAM_STR );

			$stmt->bindParam( ':price', $this->price, PDO::PARAM_INT );
			$stmt->bindParam( ':position', $this->position, PDO::PARAM_INT );
			$stmt->bindParam( ':type', $this->type, PDO::PARAM_STR );

			$stmt->execute();
		}

		public function setPrice( $arg )
		{
			$this->price = $arg;
		}

		public function setPosition( $arg )
		{
			$this->position = $arg;
		}

		public function setType( $arg )
		{
			$this->type = $arg;
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
