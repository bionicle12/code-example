<?php

	namespace models;

	use PDO;

	class Products extends Database
	{

		const TABLE = 'products';

		private $sku;
		private $name_latin;
		private $group;
		private $type;
		private $breed_dogs;
		private $breed_cats;
		private $price;
		private $description;

		public function __construct()
		{
			parent::__construct();
		}

		public function save()
		{
			$sql = "INSERT INTO " . self::TABLE . " (`crm_id`, `sku`, `name`, `name_latin`, `group`, `type`, `breed_dogs`, `breed_cats`, `price`, `description`) 
					VALUES (:crm_id, :sku, :name, :name_latin, :group, :type, :breed_dogs, :breed_cats, :price, :description)";

			$stmt = $this->core->dbh->prepare( $sql );

			$stmt->bindParam( ':crm_id', $this->crm_id, PDO::PARAM_INT );
			$stmt->bindParam( ':name', $this->name, PDO::PARAM_STR );

			$stmt->bindParam( ':sku', $this->sku, PDO::PARAM_STR );
			$stmt->bindParam( ':name_latin', $this->name_latin, PDO::PARAM_STR );
			$stmt->bindParam( ':group', $this->group, PDO::PARAM_STR );
			$stmt->bindParam( ':type', $this->type, PDO::PARAM_STR );
			$stmt->bindParam( ':breed_dogs', $this->breed_dogs, PDO::PARAM_STR );
			$stmt->bindParam( ':breed_cats', $this->breed_cats, PDO::PARAM_STR );
			$stmt->bindParam( ':price', $this->price, PDO::PARAM_INT );
			$stmt->bindParam( ':description', $this->description, PDO::PARAM_STR );

			$stmt->execute();
		}

		public function setSku( $arg )
		{
			$this->sku = $arg;
		}

		public function setNameLatin( $arg )
		{
			$this->name_latin = $arg;
		}

		public function setGroup( $arg )
		{
			$this->group = $arg;
		}

		public function setType( $arg )
		{
			$this->type = $arg;
		}

		public function setBreedDogs( $arg )
		{
			$this->breed_dogs = $arg;
		}

		public function setBreedCats( $arg )
		{
			$this->breed_cats = $arg;
		}

		public function setPrice( $arg )
		{
			$this->price = $arg;
		}

		public function setDescription( $arg )
		{
			$this->description = $arg;
		}

		public function getBreeds( $fields )
		{
			$breeds = $fields[0]->value;
			if ( count( $fields ) > 1 ) {
				foreach ( $fields as $key => $value ) {
					if ( $key === 0 ) {
						continue;
					}
					$breeds .= ',' . $value->value;
				}
			}
			return $breeds;
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
