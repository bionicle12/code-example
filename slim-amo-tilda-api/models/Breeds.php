<?php

	namespace models;

	use PDO;

	class Breeds extends Database
	{

		const TABLE = 'breeds';

		private $type;

		public function __construct()
		{
			parent::__construct();
		}

		public function save()
		{
			$sql = "INSERT INTO " . self::TABLE . " (`crm_id`, `name`, `type`) 
					VALUES (:crm_id, :name, :type)";

			$stmt = $this->core->dbh->prepare( $sql );

			$stmt->bindParam( ':crm_id', $this->crm_id, PDO::PARAM_INT );
			$stmt->bindParam( ':name', $this->name, PDO::PARAM_STR );

			$stmt->bindParam( ':type', $this->type, PDO::PARAM_STR );

			$stmt->execute();
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
