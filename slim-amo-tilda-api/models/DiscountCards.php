<?php

	namespace models;

	use PDO;

	class DiscountCards extends Database
	{

		const TABLE = 'discount_cards';

		private $number;
		private $discount;
		private $dogs;
		private $tests;

		public function __construct()
		{
			parent::__construct();
		}

		public function save()
		{
			$sql = "INSERT INTO " . self::TABLE . " (`crm_id`, `number`, `name`, `discount`, `dogs`, `tests`) 
					VALUES (:crm_id, :number, :name, :discount, :dogs, :tests)";

			$stmt = $this->core->dbh->prepare( $sql );

			$stmt->bindParam( ':crm_id', $this->crm_id, PDO::PARAM_INT );
			$stmt->bindParam( ':name', $this->name, PDO::PARAM_STR );

			$stmt->bindParam( ':number', $this->number, PDO::PARAM_STR );
			$stmt->bindParam( ':discount', $this->discount, PDO::PARAM_STR );
			$stmt->bindParam( ':dogs', $this->dogs, PDO::PARAM_INT );
			$stmt->bindParam( ':tests', $this->tests, PDO::PARAM_INT );

			$stmt->execute();
		}

		public function setNumber( $arg )
		{
			$this->number = $arg;
		}

		public function setDiscount( $arg )
		{
			$this->discount = $arg;
		}

		public function setDogs( $arg )
		{
			$this->dogs = $arg;
		}

		public function setTests( $arg )
		{
			$this->tests = $arg;
		}

		public function check( $code )
		{
			$sql  = "SELECT `name`, `discount` FROM " . self::TABLE . " WHERE `number`=:number";
			$stmt = $this->core->dbh->prepare( $sql );
			$stmt->bindParam( ':number', $code, PDO::PARAM_STR );

			if ( $stmt->execute() ) {
				$r = $stmt->fetchAll( PDO::FETCH_ASSOC );
			} else {
				$r = [];
			}
			return $r;
		}
	}
