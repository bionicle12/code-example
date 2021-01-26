<?php

	namespace models;

	use lib\Core;
	use PDO;

	abstract class Database
	{
		protected $core;
		protected $crm_id;
		protected $name;

		protected function __construct()
		{
			$this->core = Core::getInstance();
		}

		public function setCrmId( $arg )
		{
			$this->crm_id = $arg;
		}

		public function setName( $arg )
		{
			$this->name = $arg;
		}

		public function getAllData( $table )
		{
			$sql  = "SELECT * FROM {$table};";
			$stmt = $this->core->dbh->prepare( $sql );
			//$stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

			if ( $stmt->execute() ) {
				$r = $stmt->fetchAll( PDO::FETCH_ASSOC );
			} else {
				$r = 0;
			}
			return $r;
		}

		public static function erase( $table )
		{
			$sql  = "TRUNCATE {$table};";
			$stmt = Core::getInstance()->dbh->prepare( $sql );
			$stmt->execute();
		}

		public static function cleanPhoneNumber( $number )
		{
			return preg_replace( '/[^0-9]/', '', $number );
		}

		abstract function save();
	}