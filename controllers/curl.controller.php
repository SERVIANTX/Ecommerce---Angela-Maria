<?php

	class CurlController{

		/*=====================================================
			TODO: Ruta API
		======================================================*/

		static public function api(){
			return "http://api.angelamaria.com/";
			//return "https://api.e-angelamaria.me/";
		}

		/*=====================================================
			TODO: Peticiones a la API
		======================================================*/

		static public function request($url, $method, $fields, $header){

			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => $method,
				CURLOPT_POSTFIELDS => $fields,
				CURLOPT_HTTPHEADER => array(
					'Authorization: YJEntU7gJwbnqeukvXxnRgNzA3jg9Q'
				),
			));

			$response = curl_exec($curl);

			curl_close($curl);

			$response = json_decode($response);

			return $response;

		}

		/*=============================================
            TODO: Peticiones a la API
        =============================================*/

        static public function request2($url, $method, $fields){

			// $api = "https://api.e-angelamaria.me/";
			$api = "http://api.angelamaria.com/";
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $api.$url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => $method,
                    CURLOPT_POSTFIELDS => $fields,
                    CURLOPT_HTTPHEADER => array(
                    'Authorization: YJEntU7gJwbnqeukvXxnRgNzA3jg9Q'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            $response = json_decode($response);
            return $response;

        }

	}

?>