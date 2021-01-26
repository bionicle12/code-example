<?php

	/* Все модели, для извлечения и записи данных в БД */

	use models\Breeds;
	use models\Contacts;
	use models\Database;
	use models\DiscountCards;
	use models\GeneticPrices;
	use models\Prices;
	use models\Products;
	use models\Promocodes;

	use models\AmoConnector;

	$app->get( '/contacts', function() use ( $app ) {
		$parser = new AmoConnector();

		$contacts = $parser->getContacts();

		Database::erase( Contacts::TABLE );
		foreach ( $contacts as $item ) {
			$row = new Contacts();
			$row->setCrmId( $item->id );
			$row->setName( $item->name );

			$row->setCompany( '' );

			foreach ( $item->custom_fields as $field ) {

				if ( isset( $field->code ) ) {

					if ( $field->code === "PHONE" ) {
						$row->setPhone( Database::cleanPhoneNumber( $field->values[0]->value ) );
						continue;
					}

					if ( $field->code === "EMAIL" ) {
						$row->setEmail( $field->values[0]->value );
						continue;
					}

				}

				if ( $field->name === "Число протестированных собак" ) {
					$row->setDogs( $field->values[0]->value );
					continue;
				}

				if ( $field->name === "Число проведенных тестов" ) {
					$row->setTests( $field->values[0]->value );
					continue;
				}

			}

			$row->save();
		}
		unset( $contacts );
	} );

	$app->get( '/parser', function() use ( $app ) {

		$parser = new AmoConnector();

		//============================
		$contacts = $parser->getContacts();

		Database::erase( Contacts::TABLE );
		foreach ( $contacts as $item ) {
			$row = new Contacts();
			$row->setCrmId( $item->id );
			$row->setName( $item->name );

			//$row->setCompany( '' );

			foreach ( $item->custom_fields as $field ) {

				if ( isset( $field->code ) ) {

					if ( $field->code === "PHONE" ) {
						$row->setPhone( Database::cleanPhoneNumber( $field->values[0]->value ) );
						continue;
					}

					if ( $field->code === "EMAIL" ) {
						$row->setEmail( $field->values[0]->value );
						continue;
					}

				}

				if ( $field->name === "Число протестированных собак" ) {
					$row->setDogs( $field->values[0]->value );
					continue;
				}

				if ( $field->name === "Число проведенных тестов" ) {
					$row->setTests( $field->values[0]->value );
					continue;
				}

			}

			$row->save();
		}
		unset( $contacts );

		//============================
		$promocodes = $parser->getPromocodes();

		Database::erase( Promocodes::TABLE );
		foreach ( $promocodes as $item ) {
			$row = new Promocodes();
			$row->setCrmId( $item->id );
			$row->setName( $item->name );

			foreach ( $item->custom_fields as $field ) {

				if ( $field->name === 'Краткое описание' ) {
					$row->setDescription( $field->values[0]->value );
					continue;
				}

				if ( $field->name === 'Скидка' ) {
					$row->setDiscount( $field->values[0]->value );
					continue;
				}

				if ( $field->name === 'Использовано' ) {
					$row->setUsed( $field->values[0]->value );
					continue;
				}

				if ( $field->name === 'Лимит' ) {
					$row->setLimit( $field->values[0]->value );
					continue;
				}

				if ( $field->name === 'Окончание' ) {
					$row->setExpired( $field->values[0]->value );
					continue;
				}

			}

			$row->save();
		}
		unset( $promocodes );

		//============================
		$discount_cards = $parser->getDiscountCards();
		Database::erase( DiscountCards::TABLE );
		foreach ( $discount_cards as $item ) {
			$row = new DiscountCards();
			$row->setCrmId( $item->id );
			$row->setName( $item->name );

			foreach ( $item->custom_fields as $field ) {

				if ( $field->name === 'Номер карты' ) {
					$row->setNumber( $field->values[0]->value );
					continue;
				}

				if ( $field->name === 'Скидка' ) {
					$row->setDiscount( $field->values[0]->value );
					continue;
				}

				if ( $field->name === 'Собак' ) {
					$row->setDogs( $field->values[0]->value );
					continue;
				}

				if ( $field->name === 'Тестов' ) {
					$row->setTests( $field->values[0]->value );
					continue;
				}

			}

			$row->save();
		}
		unset( $discount_cards );

		//============================
		$prices = $parser->getPrices();
		Database::erase( Prices::TABLE );
		foreach ( $prices as $item ) {
			$row = new Prices();
			$row->setCrmId( $item->id );
			$row->setName( $item->name );

			foreach ( $item->custom_fields as $field ) {

				if ( $field->name === 'Цена' ) {
					$row->setPrice( $field->values[0]->value );
					continue;
				}

				if ( $field->name === '№ товара' ) {
					$row->setPosition( $field->values[0]->value );
					continue;
				}

				if ( $field->name === 'Тип цены' ) {
					$row->setType( $field->values[0]->value );
					continue;
				}
			}

			$row->save();
		}
		unset( $prices );

		//============================
		$genetic_prices = $parser->getGeneticPrices();
		Database::erase( GeneticPrices::TABLE );
		foreach ( $genetic_prices as $item ) {
			$row = new GeneticPrices();
			$row->setCrmId( $item->id );
			$row->setName( $item->name );

			foreach ( $item->custom_fields as $field ) {

				if ( $field->name === 'Артикул' ) {
					$row->setSku( $field->values[0]->value );
					continue;
				}

				if ( $field->name === 'Количество' ) {
					$row->setCount( $field->values[0]->value );
					continue;
				}

				if ( $field->name === 'Цена' ) {
					$row->setPrice( $field->values[0]->value );
					continue;
				}

			}

			$row->save();
		}
		unset( $genetic_prices );

		//============================
		$products = $parser->getProducts();
		Database::erase( Products::TABLE );
		Database::erase( Breeds::TABLE );
		foreach ( $products as $item ) {
			$row = new Products();
			$row->setCrmId( $item->id );
			$row->setName( $item->name );

			foreach ( $item->custom_fields as $field ) {

				if ( $field->name === 'Артикул' ) {
					$row->setSku( $field->values[0]->value );
					continue;
				}

				if ( $field->name === 'Стоимость' ) {
					$row->setPrice( $field->values[0]->value );
					continue;
				}

				if ( $field->name === 'Группа' ) {
					$row->setGroup( $field->values[0]->value );
					continue;
				}

				if ( $field->name === 'Тип' ) {
					$row->setType( $field->values[0]->value );
					continue;
				}

				if ( $field->name === 'Название (латиница)' ) {
					$row->setNameLatin( $field->values[0]->value );
					continue;
				}

				if ( $field->name === 'Породы собак' ) {
					$row->setBreedDogs( $row->getBreeds( $field->values ) );
					continue;
				}

				if ( $field->name === 'Породы кошек' ) {
					$row->setBreedCats( $row->getBreeds( $field->values ) );
					continue;
				}

				if ( $field->name === 'Описание' ) {
					$row->setDescription( $field->values[0]->value );
					continue;
				}
			}

			// Создание таблицы Пород из двух последних продуктов
			if ( $item->name === 'ДЛЯ ПОРОД СОБАК' || $item->name === 'ДЛЯ ПОРОД КОШЕК' ) {

				$type = $item->name === 'ДЛЯ ПОРОД КОШЕК' ? 'cat' : 'dog';

				foreach ( $item->custom_fields as $field ) {

					if ( $field->name !== 'Породы собак' && $field->name !== 'Породы кошек' ) {
						continue;
					}

					foreach ( $field->values as $val ) {
						if ( $val->value === 'Все кошки' || $val->value === 'Все собаки' ) {
							continue;
						}

						$breed = new Breeds();
						$breed->setCrmId( $val->enum );
						$breed->setName( $val->value );
						$breed->setType( $type );
						$breed->save();
					}

				}
			}

			$row->save();
		}
		unset( $products );

		date_default_timezone_set( 'Asia/Novosibirsk' );
		$date_parse = date( 'd.m.Y H:i:s' );
		file_put_contents( 'log.txt', $date_parse . ' - Parse is End;', FILE_APPEND | LOCK_EX );

		//============================
		$app->contentType( 'application/json' );
		echo json_encode( 'Parse is End' );
	} );