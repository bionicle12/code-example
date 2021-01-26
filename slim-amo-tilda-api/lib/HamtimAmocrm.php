<?php

	namespace lib;

	use stdClass;

	class HamtimAmocrm
	{
		protected $settings;
		protected $subdomain;
		public    $auth;

		function __construct( $login, $api, $subdomain )
		{
			$this->settings                    = new stdClass();
			$this->settings->amocrm            = new stdClass();
			$this->settings->amocrm->api       = $api;
			$this->settings->amocrm->login     = $login;
			$this->settings->amocrm->subdomain = $subdomain;
			$this->amocrm_auth();
		}

		function amocrm_auth()
		{
			if ( isset( $this->settings->amocrm ) ) {
				if ( $this->settings->amocrm->api && $this->settings->amocrm->login && $this->settings->amocrm->subdomain ) {
					$subdomain       = $this->settings->amocrm->subdomain;
					$this->subdomain = $subdomain;
					$user            = [
					  'USER_LOGIN' => $this->settings->amocrm->login,
					  'USER_HASH'  => $this->settings->amocrm->api
					];
				} else {
					return 'Нет данных для авторизации';
				}
			} else {
				return 'Нет данных для авторизации';
			}

			$link = 'https://' . $subdomain . '.amocrm.ru/private/api/auth.php?type=json';
			$curl = curl_init(); #Сохраняем дескриптор сеанса cURL
			#Устанавливаем необходимые опции для сеанса cURL
			curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0' );
			curl_setopt( $curl, CURLOPT_URL, $link );
			curl_setopt( $curl, CURLOPT_POST, true );
			curl_setopt( $curl, CURLOPT_POSTFIELDS, http_build_query( $user, null, '&', PHP_QUERY_RFC1738 ) );

		//	curl_setopt( $curl, CURLOPT_POSTFIELDS, json_encode( $user ) );
		//	curl_setopt( $curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json'] );

			curl_setopt( $curl, CURLOPT_HEADER, false );
			curl_setopt( $curl, CURLOPT_COOKIEFILE, __DIR__ . '/cookie.txt' );
			curl_setopt( $curl, CURLOPT_COOKIEJAR, __DIR__ . '/cookie.txt' );
			curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, 0 );
			curl_setopt( $curl, CURLOPT_SSL_VERIFYHOST, 0 );

			$out  = curl_exec( $curl ); #Инициируем запрос к API и сохраняем ответ в переменную
			$code = curl_getinfo( $curl, CURLINFO_HTTP_CODE ); #Получим HTTP-код ответа сервера
			curl_close( $curl ); #Заверашем сеанс cURL

			$auth = json_decode( $out );
			if ( $out ) {
				$this->auth = $auth->response->auth;
			}

			return $out;
		}

		function q( $path, $fields = [], $ifModifiedSince = false )
		{
			return $this->amocrm_query( $path, $fields, $ifModifiedSince );
		}

		function l( $l )
		{
			echo '<pre>';
			var_dump( $l );
			echo '</pre>';
		}

		function amocrm_query( $path, $fields = [], $ifModifiedSince = false )
		{
			$link = 'https://' . $this->subdomain . '.amocrm.ru' . $path;

			$curl = curl_init(); #Сохраняем дескриптор сеанса cURL
			#Устанавливаем необходимые опции для сеанса cURL
			curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0' );
			curl_setopt( $curl, CURLOPT_URL, $link );
			if ( $ifModifiedSince ) {
				$httpHeader = ['IF-MODIFIED-SINCE: ' . $ifModifiedSince];
			} else {
				$httpHeader = [];
			}
			if ( count( $fields ) ) {
				curl_setopt( $curl, CURLOPT_CUSTOMREQUEST, 'POST' );
				curl_setopt( $curl, CURLOPT_POSTFIELDS, json_encode( $fields ) );
				$httpHeader[] = 'Content-Type: application/json';
			}
			curl_setopt( $curl, CURLOPT_HTTPHEADER, $httpHeader );
			curl_setopt( $curl, CURLOPT_HEADER, false );
			curl_setopt( $curl, CURLOPT_COOKIEFILE, __DIR__ . '/cookie.txt' );
			curl_setopt( $curl, CURLOPT_COOKIEJAR, __DIR__ . '/cookie.txt' );
			curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, 0 );
			curl_setopt( $curl, CURLOPT_SSL_VERIFYHOST, 0 );

			$out  = curl_exec( $curl ); #Инициируем запрос к API и сохраняем ответ в переменную
			$code = curl_getinfo( $curl, CURLINFO_HTTP_CODE );
			//$this->l(curl_getinfo($curl));
			return json_decode( $out );
		}
	}