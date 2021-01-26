<?php

	namespace models;

	use PDO;

	class Contacts extends Database
	{
		const TABLE = 'contacts';

		private $phone;
		private $email;
		private $company;
		private $dogs;
		private $tests;

		public function __construct()
		{
			parent::__construct();
		}

		public function save()
		{
			$sql = "INSERT INTO " . self::TABLE . " (`crm_id`, `name`, `phone`, `email`, `company`, `dogs`, `tests`) 
					VALUES (:crm_id, :name, :phone, :email, :company, :dogs, :tests)";

			$stmt = $this->core->dbh->prepare( $sql );

			$stmt->bindParam( ':crm_id', $this->crm_id, PDO::PARAM_INT );
			$stmt->bindParam( ':name', $this->name, PDO::PARAM_STR );

			$stmt->bindParam( ':phone', $this->phone, PDO::PARAM_STR );
			$stmt->bindParam( ':email', $this->email, PDO::PARAM_STR );
			$stmt->bindParam( ':company', $this->company, PDO::PARAM_STR );
			$stmt->bindParam( ':dogs', $this->dogs, PDO::PARAM_INT );
			$stmt->bindParam( ':tests', $this->tests, PDO::PARAM_INT );

			$stmt->execute();
		}

		public function setPhone( $arg )
		{
			$this->phone = $arg;
		}

		public function setEmail( $arg )
		{
			$this->email = $arg;
		}

		public function setDogs( $arg )
		{
			$this->dogs = $arg;
		}

		public function setTests( $arg )
		{
			$this->tests = $arg;
		}

		public function setCompany( $arg )
		{
			$this->company = $arg;
		}

		public function updateContact( $object )
		{
			$sql  = "UPDATE " . self::TABLE . " SET dogs=?, tests=? WHERE crm_id=?";
			$stmt = $this->core->dbh->prepare( $sql );
			$stmt->execute( [
			  $object['dogs'],
			  $object['tests'],
			  $object['id']
			] );

			return true;
		}

		public function searchContact( $object )
		{
			$phone = Database::cleanPhoneNumber( $object['phone'] );
			$sql   = "SELECT * FROM " . self::TABLE . " WHERE `email`='{$object['email']}' OR `phone`='{$phone}'";
			$stmt  = $this->core->dbh->prepare( $sql );

			$r = [];

			if ( $stmt->execute() ) {
				$r = $stmt->fetchAll( PDO::FETCH_ASSOC );
				if ( count( $r ) ) {
					$r = [
					  'id'    => (int)$r[0]['crm_id'],
					  'dogs'  => (int)$r[0]['dogs'],
					  'tests' => (int)$r[0]['tests'],
					];
				} else {

					// Это лишь попытка.
					// try load last contacts from site
					$sql  = "SELECT COUNT(id) as offset FROM " . self::TABLE;
					$stmt = $this->core->dbh->prepare( $sql );
					if ( $stmt->execute() ) {
						$res = $stmt->fetchAll( PDO::FETCH_ASSOC );
						if ( count( $res ) ) {
							$contacts = ( new AmoConnector() )->getContactsLast( $res[0]['offset'] );

							$r = [];

							// search id
							foreach ( $contacts as $item ) {

								foreach ( $item->custom_fields as $field ) {

									if ( !isset( $field->code ) ) {
										continue;
									}

									if ( $field->code === "PHONE" ) {
										if ( Database::cleanPhoneNumber( $field->values[0]->value ) == $phone ) {
											$r['id'] = $item->id;
											break 2;
										}
									}

									if ( $field->code === "EMAIL" ) {
										if ( $field->values[0]->value == $object['email'] ) {
											$r['id'] = $item->id;
											break 2;
										}
									}

								}

							}

							// После находа id серчим, кол-во собак и тестов
							if ( isset( $r['id'] ) ) {

								foreach ( $contacts as $item ) {

									if ( $item->id !== $r['id'] ) {
										continue;
									}

									foreach ( $item->custom_fields as $field ) {
										if ( $field->name === "Число протестированных собак" ) {
											$r['dogs'] = $field->values[0]->value;
										}
										if ( $field->name === "Число проведенных тестов" ) {
											$r['tests'] = $field->values[0]->value;
										}
									}

								}

							}

						}

					}
					// конец ифов, омг
					// TODO что-нить поумнее сделать...

				}
			}

			return $r;
		}
	}
