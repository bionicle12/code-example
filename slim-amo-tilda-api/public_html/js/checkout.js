(function ( w, d, $ ) {
	'use strict';
	
	console.log( 'load' );
	
	var apiHost = '';
	if ( location.host === 'host.ru' ) {
		apiHost = 'https://api.host.tk';
	}
	
	w.data = {};
	w.data.Discount = null;
	w.data.Promocode = null;
	
	/* global */
	function is_ok_form() {
		var has_error = 0;
		
		$( 'input.required:visible' ).each( function ( i, el ) {
			if ( !$( el ).val().length ) {
				has_error = 1;
				$( el ).addClass( 'error-input' );
			}
		} );
		
		if ( has_error ) {
			alert( 'Необходимо заполнить все обязательные поля!' );
		}
		
		return !has_error;
	}
	
	function dataLoad() {
		$.get( apiHost + '/cart/breeds', function ( result ) {
			w.data.Breeds = result;
		} );
		$.get( apiHost + '/cart/prices', function ( result ) {
			w.data.Prices = result;
		} );
		$.get( apiHost + '/cart/genetic_prices', function ( result ) {
			w.data.GeneticPrices = result;
		} );
		$.get( apiHost + '/cart/products', function ( result ) {
			w.data.Products = result;
		} );
	}
	
	$( d ).ready( function () {
		console.log( 'document ready' );
		
		dataLoad();
		
		$( '#phone' ).mask( '+7 (999) 999-9999' );
		
		$( '.order_block_form input[type="text"], .order_block_form input[type="number"]' ).on( 'blur', inputLabelPosition );
		
		$( '.t-checkbox_pitomnik' ).on( 'click', function () {
			if ( $( '#pitomnik' ).prop( 'checked' ) ) {
				$( '.for-pitomnik-block' ).fadeIn( 'fast' );
			} else {
				$( '.for-pitomnik-block' ).fadeOut( 'fast' );
			}
			recalcPometCardsContent();
			finalRecalc();
		} );
		
		$( '.t-checkbox_nomiddlename' ).on( 'click', function () {
			if ( $( '#nomiddlename' ).prop( 'checked' ) ) {
				$( '#middlename' ).addClass( 'success-input' ).val( 'Отсутствует' );
			} else {
				$( '#middlename' ).removeClass( 'success-input' ).val( '' );
			}
		} );
		
		$( '.t-checkbox_replayfio' ).on( 'click', function () {
			if ( $( '#replayfio' ).prop( 'checked' ) ) {
				$( '#replayblock > div' ).fadeOut( 'fast' );
			} else {
				$( '#replayblock > div' ).fadeIn( 'fast' );
			}
		} );
		
		$( 'input[type="radio"]' ).on( 'click', function () {
			if ( this.dataset.point === '1' ) {
				$( '.for-biomaterial-block' ).fadeIn( 'fast' );
			} else {
				$( '.for-biomaterial-block' ).fadeOut( 'fast' );
			}
		} );
		
		window.checkout_blocked = false;
		
		$( '#orderForm' ).on( 'submit', function ( e ) {
			e.preventDefault();
			
			if ( !is_ok_form() || window.checkout_blocked ) {
				console.log( 'Ошибочка' );
				return false;
			}
			
			// Ручной сбор массива корректно
			var data = {};
			data.order = {};
			data.order.price = {};
			
			// Prepare data
			function prepareArray( param ) {
				var num = parseInt( param.petNum, 10 );
				
				if ( data.order[param.petKey] === undefined ) {
					data.order[param.petKey] = {};
				}
				
				if ( data.order[param.petKey][num] === undefined ) {
					data.order[param.petKey][num] = {};
				}
				
				if ( data.order[param.petKey][num]['test1'] === undefined ) {
					data.order[param.petKey][num]['test1'] = {};
				}
				
				if ( data.order[param.petKey][num]['test2'] === undefined ) {
					data.order[param.petKey][num]['test2'] = {};
				}
				
				if ( data.order[param.petKey][num]['price'] === undefined ) {
					data.order[param.petKey][num]['price'] = {};
				}
			}
			
			// Сбор общих данных
			$( this ).find( 'input:visible' ).each( function ( i, el ) {
				
				if ( el.name.search( 'cat' ) === -1 && el.name.search( 'dog' ) === -1 ) {
					
					if ( el.type === 'text' || el.type === 'number' ) {
						data.order[el.id] = $( el ).val();
					} else if ( el.type === 'checkbox' ) {
						data.order[el.id] = $( el ).prop( 'checked' );
					} else if ( el.type === 'radio' && $( el ).prop( 'checked' ) ) {
						var key = el.name.replace( 'order[', '' ).replace( ']', '' );
						data.order[key] = $( el ).val();
					}
					
				}
				
			} );
			
			// Сбор питомцев во вложенный массив массивов
			$( '.pet-row' ).each( function ( i, el ) {
				
				var param = {}, num = 0;
				
				$( el ).find( '.t-input-block input' ).each( function ( i2, input ) {
					
					param = getInputParams( input );
					prepareArray( param );
					num = parseInt( param.petNum, 10 );
					
					if ( i2 === 0 ) {
						data.order[param.petKey][num]['breed_id'] = parseInt( input.dataset.breedId, 10 );
					}
					
					if ( input.type === 'text' || input.type === 'number' ) {
						data.order[param.petKey][num][param.property] = $( input ).val();
					} else if ( input.type === 'checkbox' && $( input ).prop( 'checked' ) ) {
						data.order[param.petKey][num][param.property] = $( input ).prop( 'checked' );
						
						if ( param.property === 'test3' ) {
							data.order[param.petKey][num][param.property + '_price'] = $( '#' + param.petKey + '_' + param.petNum + '_test3price > span' ).text();
						}
						
					}
					
				} );
				
				$( el ).find( 'table' ).each( function ( i2, table ) {
					
					var testType = table.dataset.testType;
					
					$( table ).find( 'tbody > tr input' ).each( function ( i3, input ) {
						
						data.order[param.petKey][num][testType][i3] = input.dataset.testId + '::' + $( input ).val() + '::' + $( input ).closest( 'tr' ).find( '._calc_card > span' ).text();
						
					} );
					
				} );
				
				// Стоимость по питомцу
				data.order[param.petKey][num]['price']['pre'] = parseFloat( $( el ).find( '.price-block:eq(0) > span' ).text(), 10 );
				data.order[param.petKey][num]['price']['post'] = parseFloat( $( el ).find( '.price-block:eq(1) > span' ).text(), 10 );
				
			} );
			
			data.order['comment'] = $( this ).find( '#comment' ).val();
			data.order['discount_size'] = getDiscountSize();
			
			// Итого
			data.order['price']['pre'] = parseFloat( $( '#total_price_pre > span' ).text(), 10 );
			data.order['price']['post'] = parseFloat( $( '#total_price_post > span' ).text(), 10 );
			
			var sendData = new FormData();
			
			$( this ).find( '#file' ).each( function ( i, val ) {
				sendData.append( 'file[]', val.files[0] );
			} );
			
			sendData.append( 'data', JSON.stringify( data ) );
			
			window.checkout_blocked = true;
			
			$.ajax( {
				crossDomain: true,
				url: apiHost + '/cart',
				data: sendData,
				processData: false,
				contentType: false,
				type: 'POST',
				success: function ( data ) {
					if ( data.error ) {
						alert( data.message );
					} else {
						location.href = 'https://host.ru/order_sent';
					}
					window.checkout_blocked = false;
				}
			} );
			
			return false;
		} );
		
	} );
	
	/*
	 * Возвращает petKey и petNum
	 * */
	
	function getInputParams( input ) {
		var object = {};
		
		object.petKey = input.name.replace( 'order[', '' ).split( '[' )[0];
		object.petNum = input.name.split( object.petKey + '[' )[1].split( ']' )[0];
		object.property = input.name.split( object.petNum + '][' )[1].replace( ']]', '' );
		
		return object;
	}
	
	/*
	 При изменении цен где-либо
	 * */
	
	function finalRecalc() {
		console.log( 'final recalc' );
		var prices;
		var finalSummPre = 0;
		var finalSummPost = 0;
		
		$( '.pet-row' ).each( function ( i, el ) {
			var cardSumm = 0;
			var cardSummPost = 0;
			var thirdCost = 0;
			var thirdCostPre = 0;
			var petCount = 1;
			var priceArray = [];
			var type = $( el ).closest( '.add-block-start' )[0].id.split( 'add_' )[1];
			prices = getPriceByType( type );
			
			var isPometCard = $( el ).find( 'input:eq(0)' )[0].id.search( '_pomet_' ) !== -1;
			if ( isPometCard && $( el ).find( '._petcount' ).val().length ) {
				petCount = $( el ).find( '._petcount' ).val();
			}
			
			$( el ).find( '._calc_card > span' ).each( function ( i1, price ) {
				var priceValue = parseFloat( $( price ).text(), 10 );
				
				if ( priceValue === 0 ) {
					return true;
				}
				
				if ( !$( price ).closest( '._calc_card' ).hasClass( '_third_test' ) ) {
					priceArray.push( priceValue );
					cardSumm += priceValue;
				} else {
					
					if ( $( price ).closest( '._calc_card' )[0].id.search( 'cat' ) !== -1 ) {
						thirdCostPre += (priceValue * petCount);
					} else {
						thirdCostPre += (3400 * petCount);
					}
					
					thirdCost += (priceValue * petCount);
				}
				
			} );
			
			finalSummPre += (cardSumm + thirdCostPre);
			
			if ( !isPometCard ) {
				priceArray.sort( function ( a, b ) {return b - a} );
				$( priceArray ).each( function ( i1, price ) {
					if ( i1 === 0 ) {
						cardSummPost += price;
					} else if ( i1 <= prices.length ) {
						cardSummPost += parseFloat( prices[i1 - 1].price, 10 );
					} else {
						cardSummPost += parseFloat( prices[prices.length - 1].price, 10 );
					}
				} );
				cardSumm += thirdCostPre; //thirdCost;
				cardSummPost += thirdCost;
			} else {
				cardSumm += thirdCostPre; //thirdCost;
				cardSummPost += (cardSumm - thirdCostPre + thirdCost);
			}
			
			cardSummPost = getSummWithDiscount( cardSummPost );
			
			finalSummPost += cardSummPost;
			
			$( el ).find( '._card_calc_pre > span' ).text( cardSumm.toFixed( 2 ) );
			$( el ).find( '._card_calc_post > span' ).text( cardSummPost.toFixed( 2 ) );
		} );
		
		$( '#total_price_pre > span' ).text( finalSummPre.toFixed( 2 ) );
		$( '#total_price_post > span' ).text( finalSummPost.toFixed( 2 ) );
	}
	
	function getPriceByType( type ) {
		var prices = [];
		var priceList = window.data.Prices;
		var length = priceList.length;
		
		for ( var i = 0; i < length; i++ ) {
			if ( priceList[i].type === type ) {
				prices.push( priceList[i] );
			}
		}
		
		// sort by keys
		prices.sort( function ( a, b ) {
			var keyA = a.position;
			var keyB = b.position;
			
			// Compare the 2 dates
			if ( keyA < keyB ) {
				return -1;
			}
			if ( keyA > keyB ) {
				return 1;
			}
			return 0;
		} );
		
		return prices;
	}
	
	function getDiscountSize() {
		var allDiscounts = [];
		
		if ( w.data.Discount !== null ) {
			allDiscounts.push( parseInt( w.data.Discount.discount, 10 ) );
		}
		
		if ( w.data.Promocode !== null ) {
			allDiscounts.push( parseInt( w.data.Promocode.discount, 10 ) );
		}
		
		if ( $( '#pitomnik' ).prop( 'checked' ) ) {
			allDiscounts.push( 5 );
		}
		
		if ( allDiscounts.length ) {
			allDiscounts.sort( function ( a, b ) {return b - a} );
			return allDiscounts[0];
		}
		return 0;
	}
	
	function getSummWithDiscount( cardSummPost ) {
		var allDiscounts = [];
		
		if ( w.data.Discount !== null ) {
			allDiscounts.push( parseInt( w.data.Discount.discount, 10 ) );
		}
		
		if ( w.data.Promocode !== null ) {
			allDiscounts.push( parseInt( w.data.Promocode.discount, 10 ) );
		}
		
		if ( $( '#pitomnik' ).prop( 'checked' ) ) {
			allDiscounts.push( 5 );
		}
		
		if ( allDiscounts.length ) {
			allDiscounts.sort( function ( a, b ) {return b - a} );
			return cardSummPost - ((cardSummPost / 100) * allDiscounts[0]);
		}
		return cardSummPost;
	}
	
	function petCountListener() {
		var selector = '._petcount';
		$( selector ).off( 'change', petCountChanger );
		$( selector ).on( 'change', petCountChanger );
	}
	
	function oneSexListener() {
		var selector = '._onesex';
		$( selector ).off( 'change', recalcPometCardsContent );
		$( selector ).on( 'change', recalcPometCardsContent );
	}
	
	function petCountChanger( e ) {
		recalcPometCardsContent();
		thirdTestLogicRun( '.' + $( e.target ).closest( '.pet-row' ).find( '._third_test' )[0].dataset.searchClass );
	}
	
	function getPriceForPomet( oneSex, petCount, type ) {
		var price;
		var prices = getPriceByType( type );
		var isPitomnik = $( '#pitomnik' ).prop( 'checked' );
		
		if ( !isPitomnik ) {
			if ( !oneSex ) {
				price = parseInt( prices[0].price, 10 ) * parseInt( petCount, 10 ); // id1
			} else {
				price = parseInt( prices[1].price, 10 ) * parseInt( petCount, 10 ); // id2
			}
		} else {
			if ( !oneSex ) {
				price = parseInt( prices[2].price, 10 ) * parseInt( petCount, 10 );
			} else {
				price = parseInt( prices[3].price, 10 ) * parseInt( petCount, 10 );
			}
		}
		
		return price;
	}
	
	function recalcPometCardsContent() {
		
		$( '.pet-row' ).each( function ( i, el ) {
			if ( $( el ).find( 'input:eq(0)' )[0].id.search( '_pomet_' ) === -1 ) {
				return;
			}
			
			if ( !$( el ).find( 'table tbody tr' ).length ) {
				return;
			}
			
			var oneSex = $( el ).find( '._onesex' ).prop( 'checked' );
			var petCount = $( el ).find( '._petcount' ).val();
			if ( !petCount.length || (parseInt( petCount, 10 ) < 1) ) {
				$( el ).find( '._petcount' ).val( 1 );
				petCount = 1;
			}
			
			var type = $( el ).closest( '.add-block-start' )[0].id.split( 'add_' )[1];
			var price = getPriceForPomet( oneSex, petCount, type );
			
			$( el ).find( 'table tbody tr' ).each( function ( i1, row ) {
				$( row ).find( 'input' )[0].dataset.price = price;
				$( row ).find( '._calc_card > span' ).text( price );
			} );
			
		} );
		
		finalRecalc();
	}
	
	function thirdTestListener() {
		var selector = '._third_test';
		$( selector ).off( 'change', thirdTestChanger );
		$( selector ).on( 'change', thirdTestChanger );
	}
	
	function thirdCheckboxParentClass( e ) {
		// add class to parents
		if ( $( e.target ).prop( 'checked' ) ) {
			$( e.target ).closest( '.t-input-block' ).addClass( 'is-checked' );
		} else {
			$( e.target ).closest( '.t-input-block' ).removeClass( 'is-checked' );
		}
	}
	
	function thirdCheckboxCheckFourBlock( e ) {
		
		if ( e.target.id.search( 'dog' ) === -1 ) {
			return;
		}
		
		if ( $( e.target ).prop( 'checked' ) ) {
			$( e.target ).closest( '.t-input-block' ).next().fadeIn();
		} else {
			$( e.target ).closest( '.t-input-block' ).next().fadeOut();
		}
		
	}
	
	function getCountCheckedPetsForPomet( searchClass ) {
		var count = 0;
		
		$( searchClass + ':checked' ).each( function ( i, el ) {
			var petCount = $( el ).closest( '.pet-row' ).find( '._petcount' ).val();
			if ( !petCount.length ) {
				$( el ).closest( '.pet-row' ).find( '._petcount' ).val( 1 );
				$( el ).closest( '.pet-row' ).find( '._petcount' ).addClass( 'success-input' );
				petCount = 1;
			}
			count += parseInt( petCount, 10 );
		} );
		
		return count;
	}
	
	function thirdTestLogicRun( searchClass ) {
		var genPrice = w.data.GeneticPrices;
		var price, prePrice, afterPrice, countBreakpoint, pometsCountChecked;
		var countChecked = $( searchClass + ':checked' ).length;
		
		var dogChecked = $( '._third_test_dog:checked' ).length;
		var dogsPometChecked = $( '._third_test_dogs_pomet:checked' ).length;
		
		if ( !countChecked && !dogChecked && !dogsPometChecked ) {
			price = 0;
			$( searchClass + '_price > span' ).text( 0 );
			$( '.is-checked ' + searchClass + '_price > span' ).text( price );
		} else {
			
			if ( searchClass.search( 'cat' ) !== -1 ) {
				price = 1050;
				price = parseFloat( price ).toFixed( 2 );
				$( searchClass + '_price > span' ).text( 0 );
				$( '.is-checked ' + searchClass + '_price > span' ).text( price );
			} else {
				
				countChecked = dogChecked;
				if ( dogsPometChecked ) {
					pometsCountChecked = getCountCheckedPetsForPomet( '._third_test_dogs_pomet' );
					countChecked += pometsCountChecked;
				}
				
				// Цена от 5 будет 2100*4 + 1000 + 1000 ...
				countBreakpoint = 4;
				if ( countChecked <= countBreakpoint ) {
					price = genPrice[countChecked - 1].price;
				} else {
					prePrice = countBreakpoint * parseInt( genPrice[countBreakpoint - 1].price, 10 );
					afterPrice = (countChecked - countBreakpoint) * parseInt( genPrice[genPrice.length - 1].price, 10 );
					price = (prePrice + afterPrice) / countChecked;
				}
				
				price = parseFloat( price ).toFixed( 2 );
				$( '._third_test_dog_price > span' ).text( 0 );
				$( '._third_test_dogs_pomet_price > span' ).text( 0 );
				$( '.is-checked ._third_test_dog_price > span' ).text( price );
				$( '.is-checked ._third_test_dogs_pomet_price > span' ).text( price );
			}
			
		}
		
		finalRecalc();
	}
	
	function thirdTestChanger( e ) {
		thirdCheckboxParentClass( e );
		thirdCheckboxCheckFourBlock( e );
		thirdTestLogicRun( '.' + e.target.dataset.searchClass );
	}
	
	function getSortedProducts() {
		var output = {};
		output.dogs = {};
		output.dogs.test1 = [];
		output.dogs.test2 = [];
		
		output.cats = {};
		output.cats.test1 = [];
		output.cats.test2 = [];
		
		$( w.data.Products ).each( function ( i, el ) {
			if ( el.name === "ДЛЯ ПОРОД КОШЕК" || el.name === "ДЛЯ ПОРОД СОБАК" ) {
				return;
			}
			
			if ( el.group === 'Собаки' ) {
				
				if ( el.type === 'Заболевания' ) {
					output.dogs.test1.push( el );
				} else {
					output.dogs.test2.push( el );
				}
				
			} else {
				
				if ( el.type === 'Заболевания' ) {
					output.cats.test1.push( el );
				} else {
					output.cats.test2.push( el );
				}
				
			}
			
		} );
		
		return output;
	}
	
	function getSortedBreeds() {
		var output = {};
		output.dogs = [];
		output.cats = [];
		
		$( w.data.Breeds ).each( function ( i, el ) {
			
			if ( el.type === 'dog' ) {
				output.dogs.push( el );
			} else {
				output.cats.push( el );
			}
			
		} );
		
		return output;
	}
	
	function isInBreedList( breed ) {
		var breedIsFind = false;
		$( w.data.Breeds ).each( function ( i, el ) {
			if ( el.name === breed ) {
				breedIsFind = true;
				return false;
			}
		} );
		
		return breedIsFind;
	}
	
	function initInputTests() {
		var selector = '._init_test';
		var products = getSortedProducts();
		
		$( selector ).each( function ( i, el ) {
			
			var key1, key2, searchText, breedsWithoutBracket, searchedBreedWithoutBrackets;
			
			if ( el.dataset.petType.search( 'dog' ) !== -1 ) {
				key1 = 'dogs';
				searchText = 'собаки';
			} else {
				key1 = 'cats';
				searchText = 'кошки';
			}
			key2 = el.dataset.testType;
			
			// Method = Все или по породе.
			var userBreed = $( el ).closest( '.pet-row' ).find( '._breed' ).val().trim();
			
			var needCheckBreedComparsion = false;
			if ( isInBreedList( userBreed ) ) {
				needCheckBreedComparsion = true;
			}
			
			// Перебор исключаемых уже
			var usedTests = [];
			$( el ).closest( '.pet-row' ).find( 'input:disabled' ).each( function ( i, el ) {
				usedTests.push( el.dataset.testId );
			} );
			
			var autocompleteTags = [];
			$( products[key1][key2] ).each( function ( i1, el1 ) {
				
				if ( !needCheckBreedComparsion ) {
					
					if ( !usedTests.includes( el1.id ) ) {
						autocompleteTags.push( {
							id: el1.id,
							label: el1.name + ' (' + el1.name_latin + ')',
							value: el1.name + ' (' + el1.name_latin + ')',
							price: el1.price
						} );
					}
					
				} else {
					if ( el1['breed_' + key1] !== null ) {
						
						breedsWithoutBracket = el1['breed_' + key1].replace( /\(/g, '' ).replace( /\)/g, '' );
						searchedBreedWithoutBrackets = userBreed.replace( /\(/g, '' ).replace( /\)/g, '' );
						
						if ( breedsWithoutBracket.search( 'Все ' + searchText ) !== -1
						  || breedsWithoutBracket.search( searchedBreedWithoutBrackets ) !== -1 ) {
							
							if ( !usedTests.includes( el1.id ) ) {
								autocompleteTags.push( {
									id: el1.id,
									label: el1.name + ' (' + el1.name_latin + ')',
									value: el1.name + ' (' + el1.name_latin + ')',
									price: el1.price
								} );
							}
							
						}
					}
				}
				
			} );
			
			console.log( autocompleteTags.length );
			
			$( el ).autocomplete( {
				minLength: 0,
				source: autocompleteTags,
				select: function ( event, ui ) {
					if ( event.target.id.search( '_pomet_' ) === -1 ) {
						$( event.target ).closest( 'td' ).next( '.test-price' ).find( 'span' ).text( ui.item.price );
						event.target.dataset.price = ui.item.price;
					} else {
						
						var oneSex = $( event.target ).closest( '.pet-row' ).find( '._onesex' ).prop( 'checked' );
						var petCount = $( event.target ).closest( '.pet-row' ).find( '._petcount' ).val();
						if ( !petCount.length ) {
							$( event.target ).closest( '.pet-row' ).find( '._petcount' ).val( 1 );
							petCount = 1;
						}
						
						var type = $( event.target ).closest( '.add-block-start' )[0].id.split( 'add_' )[1];
						var price = getPriceForPomet( oneSex, petCount, type );
						
						$( event.target ).closest( 'td' ).next( '.test-price' ).find( 'span' ).text( price );
						event.target.dataset.price = price;
					}
					
					event.target.dataset.testId = ui.item.id;
					$( event.target ).prop( 'disabled', true );
					
					finalRecalc();
				}
			} );
		} );
		
	}
	
	function breedInit() {
		var selector = '._breed';
		var breeds = getSortedBreeds();
		
		$( selector ).each( function ( i, el ) {
			
			var key;
			
			if ( el.dataset.petType.search( 'dog' ) !== -1 ) {
				key = 'dogs';
			} else {
				key = 'cats';
			}
			
			var autocompleteTags = [];
			$( breeds[key] ).each( function ( i1, el1 ) {
				autocompleteTags.push( {
					label: el1.name,
					value: el1.name,
					id: el1.id
				} );
			} );
			
			$( el ).autocomplete( {
				minLength: 0,
				source: autocompleteTags,
				select: function ( event, ui ) {
					event.target.dataset.isselect = 1;
					if ( event.target.dataset.breedId !== ui.item.id ) {
						resetBreedTests( event.target );
					}
					event.target.dataset.breedId = ui.item.id;
					event.target.dataset.breedName = ui.item.value;
				},
				open: function ( event, ui ) {
					event.target.dataset.isselect = 0;
				},
				change: function ( event, ui ) {
					if ( $( event.target ).val() !== event.target.dataset.breedName ) {
						resetBreedTests( event.target );
					}
				}
			} );
			
		} );
		
	}
	
	function resetBreedTests( el ) {
		var $petCard = $( el ).closest( '.pet-row' );
		$petCard.find( 'tbody tr' ).remove();
		$petCard.find( 'table' ).addClass( 'hidden' );
		finalRecalc();
	}
	
	function restartInputBlurEvent() {
		var selector = '.order_block_form input[type="text"], .order_block_form input[type="number"]';
		$( selector ).off( 'blur', inputLabelPosition );
		$( selector ).on( 'blur', inputLabelPosition );
		
		$( selector ).off( 'focus', openSearchMenuForEmptyInput );
		$( selector ).on( 'focus', openSearchMenuForEmptyInput );
	}
	
	function inputLabelPosition( e ) {
		
		if ( $( e.target ).val() != '' ) {
			
			if ( $( e.target ).hasClass( 'error-input' ) ) {
				$( e.target ).removeClass( 'error-input' );
			}
			$( e.target ).addClass( 'success-input' );
			
		} else {
			
			$( e.target ).removeClass( 'success-input' );
			if ( $( e.target ).hasClass( 'required' ) ) {
				$( e.target ).addClass( 'error-input' );
			}
			resetPriceForTest( e.target );
		}
		
	}
	
	function resetPriceForTest( el ) {
		if ( !el.classList.contains( '_init_test' ) ) {
			return;
		}
		el.dataset.price = 0;
		$( el ).closest( 'td' ).next( '.test-price > span' ).text( 0 );
	}
	
	function openSearchMenuForEmptyInput( e ) {
		if ( (!e.target.classList.contains( '_breed' )
		  && !e.target.classList.contains( '_init_test' ))
		  || $( e.target ).val().length > 0 ) {
			return;
		}
		$( e.target ).autocomplete( 'search', '' );
	}
	
	function checkDiscount() {
		var selector = '#discount_card';
		var $code = $( selector ).val();
		if ( !$code.length ) {
			alert( 'Необходимо указать номер карты!' );
			w.data.Discount = null;
			finalRecalc();
			return;
		}
		
		$.post( apiHost + '/cart/discount', {code: $code} )
		.done( function ( data ) {
			if ( data.error ) {
				
				$( selector ).removeClass( 'has-work-code' );
				$( selector ).addClass( 'error-input' );
				
				alert( data.message );
				$( selector ).val( '' );
				w.data.Discount = null;
				finalRecalc();
				return;
			}
			
			$( selector ).addClass( 'has-work-code' );
			$( selector ).removeClass( 'error-input' );
			
			alert( 'Ваша скидка: ' + data.message.discount );
			w.data.Discount = data.message;
			finalRecalc();
		} );
	}
	
	function checkPromocode() {
		var selector = '#promocode';
		var $code = $( selector ).val();
		if ( !$code.length ) {
			alert( 'Необходимо указать промокод!' );
			w.data.Promocode = null;
			finalRecalc();
			return;
		}
		
		$.post( apiHost + '/cart/promocode', {code: $code} )
		.done( function ( data ) {
			if ( data.error ) {
				
				$( selector ).removeClass( 'has-work-code' );
				$( selector ).addClass( 'error-input' );
				
				alert( data.message );
				$( selector ).val( '' );
				w.data.Promocode = null;
				finalRecalc();
				return;
			}
			
			$( selector ).addClass( 'has-work-code' );
			$( selector ).removeClass( 'error-input' );
			
			alert( 'Скидка по промокоду: ' + data.message.discount );
			w.data.Promocode = data.message;
			finalRecalc();
		} );
	}
	
	function checkCode( type ) {
		console.log( type );
		
		if ( type === 'discount' ) {
			return checkDiscount();
		} else if ( type === 'promocode' ) {
			return checkPromocode();
		}
	}
	
	w.checkCode = checkCode;
	
	function renumerateBlocks( $start ) {
		var typeBlock = $start[0].id.split( 'add_' )[1];
		$start.find( '.pet-row' ).each( function ( num, block ) {
			
			$( block ).find( '._recalc' ).each( function ( i, el ) {
				
				if ( el.tagName === 'INPUT' || el.tagName === 'SELECT' ) {
					var idWithoutType = el.id.split( typeBlock + '_' );
					var idSplitted = idWithoutType[1].split( '_' );
					el.id = typeBlock + '_' + num + '_' + idSplitted[1];
					
					var nameWithoutType = el.name.split( typeBlock );
					var nameStart = nameWithoutType[0];
					var nameEnd = nameWithoutType[1].split( /](.+)/ )[1];
					el.name = nameStart + typeBlock + '[' + num + ']' + nameEnd;
				} else if ( el.tagName === 'LABEL' ) {
					var forWithoutType = el.htmlFor.split( typeBlock + '_' )
					var forSplitted = forWithoutType[1].split( '_' );
					el.htmlFor = typeBlock + '_' + num + '_' + forSplitted[1];
				} else if ( el.tagName === 'TABLE' ) {
					el.dataset.petKey = num;
				} else if ( el.tagName === 'SPAN' ) {
					el.innerHTML = (parseInt( num ) + 1);
				} else if ( el.tagName === 'DIV' ) {
					var idDivWithoutType = el.id.split( typeBlock + '_' );
					var idDivSplitted = idDivWithoutType[1].split( '_' );
					el.id = typeBlock + '_' + num + '_' + idDivSplitted[1];
				}
				
			} );
			
		} );
	}
	
	function deleteCard( el ) {
		var $start = $( el ).closest( '.add-block-start' );
		var searchClass = $( el ).closest( '.pet-row' ).find( '._third_test' ).attr( 'data-search-class' );
		
		$( el ).closest( '.pet-row' ).remove();
		
		renumerateBlocks( $start );
		thirdTestLogicRun( '.' + searchClass );
	}
	
	w.deleteCard = deleteCard;
	
	function renumerateTableRows( $table ) {
		var testName = $table[0].dataset.testType;
		$table.find( 'tbody tr' ).each( function ( num, row ) {
			$( row ).find( '.test-number' ).text( (num + 1) );
			$( row ).find( '._recalc' ).each( function ( i, el ) {
				if ( el.tagName === 'INPUT' || el.tagName === 'SELECT' ) {
					var idStart = el.id.split( testName + 'n' )[0];
					el.id = idStart + testName + 'n' + num + el.tagName.toLowerCase();
				} else if ( el.tagName === 'LABEL' ) {
					var forStart = el.htmlFor.split( testName + 'n' )[0];
					el.htmlFor = forStart + testName + 'n' + num + el.tagName.toLowerCase();
				}
			} );
		} );
	}
	
	function deleteTr( el ) {
		var $table = $( el ).closest( 'table' );
		$( el ).closest( 'tr' ).remove();
		if ( !$table.find( 'tbody tr' ).length ) {
			$table.addClass( 'hidden' );
		} else {
			renumerateTableRows( $table );
		}
		finalRecalc();
	}
	
	w.deleteTr = deleteTr;
	
	function getSelectForTest( petId, petType, num, testName ) {
		var selectHtml = '<select class="hidden _recalc" name="order[' + petType + '[' + petId + '][' + testName + 'select[]]]" id="' + petType + '_' + petId + '_' + testName + 'n' + num + 'select">' +
		  '<option disabled selected>Выбор из списка</option>' +
		  '<option value="Тест 1">Тест 1</option>' +
		  '<option value="Тест 2">Тест 2</option>' +
		  '<option value="Секиа">Секиа</option>' +
		  '<option value="Яяццц">Яяццц</option>' +
		  '</select>';
		return selectHtml;
	}
	
	function getTableRow( $table ) {
		var petId = $table[0].dataset.petKey;
		var petType = $table[0].dataset.petType;
		var testName = $table[0].dataset.testType;
		var num = $table.find( 'input' ).length;
		
		var template = '<tr>' +
		  '<td class="text-center">Тест <span class="test-number">' + (parseInt( num ) + 1) + '</span></td>' +
		  '<td class="test-name p-relative">' +
		  '<input type="text" id="' + petType + '_' + petId + '_' + testName + 'n' + num + 'input" name="order[' + petType + '[' + petId + '][' + testName + 'input[]]]" class="t-input t-bordered _recalc _init_test" data-pet-type="' + petType + '" data-test-type="' + testName + '" data-price="0">' +
		  '<label for="' + petType + '_' + petId + '_' + testName + 'n' + num + 'input" class="_recalc">Введите название</label>' +
		  /* getSelectForTest( petId, petType, num, testName ) + */
		  '</td>' +
		  '<td class="text-center test-price _calc_card"><span>0</span> ₽</td>' +
		  '<td class="text-center delete-tr" onclick="deleteTr(this)">[x]</td>' +
		  '</tr>';
		return template;
	}
	
	function addTest( el ) {
		if ( !$( el ).closest( '.pet-row' ).find( 'input:eq(0)' ).val().length ) {
			alert( 'Для добавления теста требуется указать породу!' );
			return;
		}
		
		if ( $( el ).closest( '.pet-row' ).find( 'input:eq(0)' )[0].id.search( '_pomet_' ) !== -1
		  && !$( el ).closest( '.pet-row' ).find( '._petcount' ).val().length ) {
			alert( 'Укажите количество помета!' );
			return;
		}
		
		var $table = $( el ).prev();
		var trHtml = getTableRow( $table );
		$table.find( 'tbody' ).append( trHtml );
		if ( $table.hasClass( 'hidden' ) ) {
			$table.removeClass( 'hidden' );
		}
		restartInputBlurEvent();
		initInputTests();
	}
	
	w.addTest = addTest;
	
	function swipeCard( el, type ) {
		var $card = $( el ).closest( '.pet-row' );
		if ( type === 'hide' ) {
			$card.find( '.hint-hide' ).addClass( 'hidden' );
			$card.find( '.hint-show' ).removeClass( 'hidden' );
			$card.find( '.t-input-block' ).hide();
			$card.find( 'h4.test-name' ).hide();
			$card.find( '.btn-add-pet' ).hide();
			$card.find( '.last-block-sum' ).show();
		} else {
			$card.find( '.hint-show' ).addClass( 'hidden' );
			$card.find( '.hint-hide' ).removeClass( 'hidden' );
			$card.find( '.t-input-block' ).show();
			$card.find( 'h4.test-name' ).show();
			$card.find( '.btn-add-pet' ).show();
		}
	}
	
	w.swipeCard = swipeCard;
	
	function getCountBlocks( id ) {
		return $( '#add_' + id + ' .pet-row' ).length;
	}
	
	function getThirdTestName( id ) {
		var text = 'Оформление ДНК-паспорта';
		if ( id.search( 'cat' ) !== -1 ) {
			text = 'Тест на группу крови';
		}
		return text;
	}
	
	function getThirdTestName2( id ) {
		var text = 'Оформить ДНК-паспорт';
		if ( id.search( 'cat' ) !== -1 ) {
			text = 'Сделать тест на группу крови';
		}
		return text;
	}
	
	function getLastText( id ) {
		var text = 'собаку';
		if ( id === 'cat' ) {
			text = 'кошку';
		} else if ( id === 'dogs_pomet' || id === 'cats_pomet' ) {
			text = 'помет';
		}
		return text;
	}
	
	function getSecondBlock( id, num ) {
		var text = '<div class="t-input-block">' +
		  '<input type="text" id="' + id + '_' + num + '_name" name="order[' + id + '[' + num + '][name]]" class="t-input t-bordered _recalc">' +
		  '<label for="' + id + '_' + num + '_name" class="_recalc">Кличка</label>' +
		  '<div class="t-input-error"></div>' +
		  '</div>' +
		  '' +
		  '<div class="t-input-block">' +
		  '<input type="text" id="' + id + '_' + num + '_chip" name="order[' + id + '[' + num + '][chip]]" class="t-input t-bordered _recalc">' +
		  '<label for="' + id + '_' + num + '_chip" class="_recalc">Номер чипа / Клеймо</label>' +
		  '<div class="t-input-error"></div>' +
		  '</div>';
		
		var typePomet = 'щенков';
		if ( id === 'cats_pomet' ) {
			typePomet = 'котят';
		}
		
		if ( id === 'dogs_pomet' || id === 'cats_pomet' ) {
			text = '<div class="t-input-block">' +
			  '<input type="number" id="' + id + '_' + num + '_count" min="1" name="order[' + id + '[' + num + '][count]]" class="t-input t-bordered required _recalc _petcount">' +
			  '<label for="' + id + '_' + num + '_count" class="_recalc">Количество тестируемых ' + typePomet + ' <span class="red">*</span></label>' +
			  '<div class="t-input-error"></div>' +
			  '</div>' +
			  '' +
			  '<div class="t-input-block d-flex" style="margin-bottom:30px;padding-top:15px;">' +
			  '<div class="col-12 text-left">' +
			  '<label class="t-checkbox__control t-text t-text_xs default-label p-relative">' +
			  '<input type="checkbox" id="' + id + '_' + num + '_onesex" name="order[' + id + '[' + num + '][onesex]]" class="t-checkbox js-tilda-rule _recalc _onesex">' +
			  '<div class="t-checkbox__indicator"></div>' +
			  'Тестирование ' + typePomet + ' одного пола в разнополом помете' +
			  '</label>' +
			  '</div>' +
			  '</div>'
		}
		
		return text;
	}
	
	function getFourCheckbox( id, num ) {
		var text = '';
		
		if ( id.search( 'dog' ) !== -1 ) {
			text = '<div class="t-input-block d-flex _four_test" style="margin-bottom:0;padding-top:15px;display:none;">' +
			  '<div class="col-8 text-right" style="width:70.66%;">' +
			  '<label class="t-checkbox__control t-text t-text_xs default-label p-relative">' +
			  '<input type="checkbox" id="' + id + '_' + num + '_test4" name="order[' + id + '[' + num + '][test4]]" class="t-checkbox js-tilda-rule _recalc _four_test _four_test_' + id + '" data-search-class="_four_test_' + id + '">' +
			  '<div class="t-checkbox__indicator"></div>' +
			  'Тест на установление родства' +
			  '</label>' +
			  '</div>' +
			  '</div>';
		}
		
		return text;
	}
	
	function addPetBlock( id, typeName ) {
		var num = getCountBlocks( id );
		//var lastText = getLastText( id );
		
		if ( typeName === 'Собаки' ) {
			typeName = 'Помет собак';
		} else if ( typeName === 'Кошки' ) {
			typeName = 'Помет кошек';
		}
		
		var htmlPetBlock = '<div class="pet-row order_block_form">' +
		  '<h4>' + typeName + ' #<span class="pet-number _recalc">' + (parseInt( num ) + 1) + '</span></h4>' +
		  '<div class="hint-text hint-hide" onclick="swipeCard(this, \'hide\')">[свернуть]</div>' +
		  '<div class="hint-text hint-show hidden" onclick="swipeCard(this, \'show\')">[развернуть]</div>' +
		  '<div class="delete-cross" onclick="deleteCard(this)">[x]</div>' +
		  '' +
		  '<div class="t-input-block">' +
		  '<input type="text" id="' + id + '_' + num + '_breed" name="order[' + id + '[' + num + '][breed]]" class="t-input t-bordered required _recalc _breed" data-pet-type="' + id + '" data-isselect="0" data-breed-id="0" data-breed-name="">' +
		  '<label for="' + id + '_' + num + '_breed" class="_recalc">Порода <span class="red">*</span></label>' +
		  '<div class="t-input-error"></div>' +
		  '</div>' +
		  '' +
		  getSecondBlock( id, num ) +
		  '' +
		  '<h4 class="test-name">Тесты на наследственные заболевания</h4>' +
		  '<table class="test-table b-top hidden _recalc" data-test-type="test1" data-current-steps="0" data-pet-type="' + id + '" data-pet-key="' + num + '">' +
		  '<thead>' +
		  '<tr>' +
		  '<th>#</th>' +
		  '<th>Наименование теста</th>' +
		  '<th style="width:135px;">Стоимость</th>' +
		  '<th></th>' +
		  '</tr>' +
		  '</thead>' +
		  '<tbody></tbody>' +
		  '</table>' +
		  '<div class="t-btn t-btn-cell btn-add-pet" onclick="addTest(this);">' +
		  'Добавить тест' +
		  '</div>' +
		  '' +
		  '<h4 class="test-name">Тесты на окрасы и типы шерсти</h4>' +
		  '<table class="test-table b-top hidden _recalc" data-test-type="test2" data-current-steps="0" data-pet-type="' + id + '" data-pet-key="' + num + '">' +
		  '<thead>' +
		  '<tr>' +
		  '<th>#</th>' +
		  '<th>Наименование теста</th>' +
		  '<th style="width:135px;">Стоимость</th>' +
		  '<th></th>' +
		  '</tr>' +
		  '</thead>' +
		  '<tbody></tbody>' +
		  '</table>' +
		  '<div class="t-btn t-btn-cell btn-add-pet" onclick="addTest(this);">' +
		  'Добавить тест' +
		  '</div>' +
		  '' +
		  '<h4 class="test-name">' + getThirdTestName( id ) + '</h4>' +
		  '<div class="t-input-block d-flex" style="margin-bottom:0;padding-top:15px;">' +
		  '<div class="col-8 text-right">' +
		  '<label class="t-checkbox__control t-text t-text_xs default-label p-relative">' +
		  '<input type="checkbox" id="' + id + '_' + num + '_test3" name="order[' + id + '[' + num + '][test3]]" class="t-checkbox js-tilda-rule _recalc _third_test _third_test_' + id + '" data-search-class="_third_test_' + id + '">' +
		  '<div class="t-checkbox__indicator"></div>' +
		  '' + getThirdTestName2( id ) +
		  '</label>' +
		  '</div>' +
		  '<div class="col-4 text-center">' +
		  '<div id="' + id + '_' + num + '_test3price" class="label-checkbox-test _recalc _third_test _third_test_' + id + '_price _calc_card"><span>0</span> ₽</div>' +
		  '</div>' +
		  '</div>' +
		  '' + getFourCheckbox( id, num ) +
		  '<div class="t-input-block d-flex b-top last-block-sum" style="margin-top:30px;">' +
		  '<div class="col-4">' +
		  'Итого сумма за ' + getLastText( id ) +
		  '</div>' +
		  '<div class="col-4 text-center">' +
		  '<div class="t-text t-text_xs t-text-inform">Стоимость по всем тестам за ' + getLastText( id ) + ' <br>без учета скидок' +
		  '</div>' +
		  '<div id="' + id + '_' + num + '_pricepre" class="price-block _recalc _card_calc_pre"><span>0</span> ₽</div>' +
		  '</div>' +
		  '<div class="col-4 text-center">' +
		  '<div class="t-text t-text_xs t-text-inform">Стоимость по всем тестам за ' + getLastText( id ) + ' <br><strong>с учетом всех скидок</strong>' +
		  '</div>' +
		  '<div id="' + id + '_' + num + '_pricepost" class="price-block _recalc _card_calc_post"><span>0</span> ₽</div>' +
		  '</div>' +
		  '</div>' +
		  '' +
		  '</div>';
		
		$( '#add_' + id ).append( htmlPetBlock );
		restartInputBlurEvent();
		breedInit();
		thirdTestListener();
		petCountListener();
		oneSexListener();
	}
	
	w.addPetBlock = addPetBlock;
	
})( window, document, window.jQuery );

$( function () {
	var $zip = $( '#addr_zip' ),
	  $region = $( '#addr_region' ),
	  $district = $( '#addr_district' ),
	  $city = $( '#addr_city' ),
	  $street = $( '#addr_street' ),
	  $building = $( '#addr_building' );
	
	var $tooltip = $( '.tooltip' );
	
	$.fias.setDefault( {
		parentInput: '.js-form-address',
		verify: true,
		select: function ( obj ) {
			setLabel( $( this ), obj.type );
			$tooltip.hide();
		},
		check: function ( obj ) {
			var $input = $( this );
			
			if ( obj ) {
				setLabel( $input, obj.type );
				$tooltip.hide();
			} else {
				showError( $input, 'Введено неверно' );
			}
		},
		checkBefore: function () {
			var $input = $( this );
			
			if ( !$.trim( $input.val() ) ) {
				$tooltip.hide();
				return false;
			}
		},
		change: function ( obj ) {
			if ( obj && obj.parents ) {
				$.fias.setValues( obj.parents, '.js-form-address' );
				$( '#addr_region' ).addClass( 'success-input' ).removeClass( 'error-input' );
			}
			
			if ( obj && obj.zip ) {
				$( '#addr_zip' ).addClass( 'success-input' ).val( obj.zip ).removeClass( 'error-input' );
			}
		},
	} );
	
	$region.fias( 'type', $.fias.type.region );
	$district.fias( 'type', $.fias.type.district );
	$city.fias( 'type', $.fias.type.city );
	$street.fias( 'type', $.fias.type.street );
	$building.fias( 'type', $.fias.type.building );
	
	$district.fias( 'withParents', true );
	$city.fias( 'withParents', true );
	$street.fias( 'withParents', true );
	
	// Отключаем проверку введённых данных для строений
	$building.fias( 'verify', false );
	
	// Подключаем плагин для почтового индекса
	// $zip.fiasZip('.js-form-address');
	
	function setLabel( $input, text ) {
		text = text.charAt( 0 ).toUpperCase() + text.substr( 1 ).toLowerCase();
		$input.parent().find( 'label' ).html( text + ' <span class="red">*</span>' );
	}
	
	function showError( $input, message ) {
		$tooltip.find( 'span' ).text( message );
		
		var inputOffset = $input.offset(),
		  inputWidth = $input.outerWidth(),
		  inputHeight = $input.outerHeight();
		
		var tooltipHeight = $tooltip.outerHeight();
		
		$tooltip.css( {
			left: (inputOffset.left + inputWidth + 10) + 'px',
			top: (inputOffset.top + (inputHeight - tooltipHeight) / 2 - 1) + 'px'
		} );
		
		$tooltip.show();
	}
} );