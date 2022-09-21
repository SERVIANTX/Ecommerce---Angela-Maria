<?php

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	class TemplateController{

		/*=====================================================
			TODO: Traemos la Vista Principal de la plantilla
		======================================================*/

		public function index(){

			include "views/template.php";
		}

		/*=====================================================
			TODO: Ruta Principal o Dominio del sitio
		======================================================*/

		static public function path(){

			if(!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])){

				return "https://localhost/Proyecto_modular/angelamaria/"; // Pruebas Facebook
				//return "https://e-angelamaria.me/";

			}else{

				return "http://angelamaria.com/";
				//return "http://e-angelamaria.me/";
			}

		}

		/*================================================================
            TODO: Ruta para las imagenes del sistema
        ================================================================*/

        static public function srcImg(){

            return "http://server.angelamaria.com/";
			//return "https://server.e-angelamaria.me/";

        }

		/*=====================================================
			TODO: Ahorro en oferta
		======================================================*/

		static public function savingValue($price, $offer, $type){

			// Cuando la oferta es con descuento

			if($type == "Discount"){

				$save = $offer*$price/100;
				return number_format($save,2);

			}

			// Cuando la oferta es con precio fijo

			if($type == "Fixed"){

				$save = $price - $offer;
				return number_format($save,2);

			}

		}

		/*=====================================================
			TODO: Precio final de oferta
		======================================================*/

		static public function offerPrice($price, $offer, $type){

			// Cuando la oferta es con descuento

			if($type == "Discount"){

				$offerPrice = $price - ($offer*$price/100);
				return number_format($offerPrice,2);

			}

			// Cuando la oferta es con precio fijo

			if($type == "Fixed"){

				return number_format($offer,2);

			}

		}

		/*=====================================================
			TODO: Promediar reseñas
		======================================================*/

		static public function averageReviews($reviews){

			$totalReviews = 0;

			if($reviews != null){

				foreach ($reviews as $key => $value) {

					$totalReviews += $value["review"];
				}

				return round($totalReviews/count($reviews));

			}else{

				return 0;
			}

		}

		/*=====================================================
			TODO: Descuento de la oferta
		======================================================*/

		static public function offerDiscount($price, $offer, $type){

			// Cuando la oferta es con descuento

			if($type == "Discount"){

				return $offer;

			}

			// Cuando la oferta es con precio fijo

			if($type == "Fixed"){

				$offerDiscount = $offer*100/$price;
				return round($offerDiscount);

			}

		}

		/*=====================================================
			TODO: Función para mayúscula inicial
		======================================================*/

		static public function capitalize($value){

			$text = str_replace("_", " ", $value);

			return ucwords($text);
		}

		/*=====================================================
			TODO: Función para enviar correos electrónicos
		======================================================*/

		static public function sendEmail($name, $subject, $email, $message){

			date_default_timezone_set("America/Lima");

			$mail = new PHPMailer(true);


            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';  // Host de conexión SMTP
            $mail->SMTPAuth = true;
            $mail->Username = 'angelamariasac.jauja@gmail.com';                 // Usuario SMTP
            $mail->Password = 'pvzcdnlzvkhzwbjq';                         // Password SMTP
            $mail->SMTPSecure = 'tls';                            // Activar seguridad TLS
            $mail->Port = 587;                                    // Puerto SMTP

            //$mail->Charset = "UTF-8";

            //$mail->isMail();

            $mail->setFrom("info@angelamaria.social", "Angela Maria - Support");

			$mail->Subject = "Hola ".$name." - ".$subject;

			$mail->addAddress($email);

			$mail->msgHTML($message);

			$send = $mail->Send();

			if(!$send){

				return $mail->ErrorInfo;

			}else{

				return "ok";

			}

		}

		/*=====================================================
			TODO: Función para almacenar imágenes
		======================================================*/

		static public function saveImage($image, $folder, $path, $width, $height, $name){

			if(isset($image["tmp_name"]) && !empty($image["tmp_name"])){

				/*=========================================================================
					TODO: Configuramos la ruta del directorio donde se guardará la imagen
				==========================================================================*/

				$directory = strtolower("views/".$folder."/".$path);

				/*=========================================================================
					TODO: Preguntamos primero si no existe el directorio, para crearlo
				==========================================================================*/

				if(!file_exists($directory)){

					mkdir($directory, 0755);

				}

				/*=========================================================================
					TODO: Eliminar todos los archivos que existan en ese directorio
				==========================================================================*/

				if($folder != "img/products" && $folder != "img/stores"){

					$files = glob($directory."/*");

					foreach ($files as $file) {

						unlink($file);
					}

				}

				/*=========================================================================
					TODO: Capturar ancho y alto original de la imagen
				==========================================================================*/

				list($lastWidth, $lastHeight) = getimagesize($image["tmp_name"]);

				/*=========================================================================
					TODO: De acuerdo al tipo de imagen aplicamos las funciones por defecto
				==========================================================================*/

				if($image["type"] == "image/jpeg"){

					//definimos nombre del archivo
					$newName  = $name.'.jpg';

					//definimos el destino donde queremos guardar el archivo
					$folderPath = $directory.'/'.$newName;

					if(isset($image["mode"]) && $image["mode"] == "base64"){

						file_put_contents($folderPath, file_get_contents($image["tmp_name"]));

					}else{

						//Crear una copia de la imagen
						$start = imagecreatefromjpeg($image["tmp_name"]);

						//Instrucciones para aplicar a la imagen definitiva
						$end = imagecreatetruecolor($width, $height);

						imagecopyresized($end, $start, 0, 0, 0, 0, $width, $height, $lastWidth, $lastHeight);

						imagejpeg($end, $folderPath);

					}

				}

				if($image["type"] == "image/png"){

					//definimos nombre del archivo
					$newName  = $name.'.png';

					//definimos el destino donde queremos guardar el archivo
					$folderPath = $directory.'/'.$newName;

					if(isset($image["mode"]) && $image["mode"] == "base64"){

						file_put_contents($folderPath, file_get_contents($image["tmp_name"]));

					}else{

						//Crear una copia de la imagen
						$start = imagecreatefrompng($image["tmp_name"]);

						//Instrucciones para aplicar a la imagen definitiva
						$end = imagecreatetruecolor($width, $height);

						imagealphablending($end, FALSE);

						imagesavealpha($end, TRUE);

						imagecopyresampled($end, $start, 0, 0, 0, 0, $width, $height, $lastWidth, $lastHeight);

						imagepng($end, $folderPath);

					}

				}

				return $newName;

			}else{

				return "error";

			}

		}

		static public function requestFile($fields){

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://server.angelamaria.com/views/img/index.php',
                // CURLOPT_URL => 'https://server.e-angelamaria.me/views/img/index.php',
                /* CURLOPT_URL => 'https://server2.joseraulraul3.repl.co/views/img/index.php', */
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $fields,
                CURLOPT_HTTPHEADER => array(
                    'Authorization: YJEntU7gJwbnqeukvXxnRgNzA3jg9Q'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            return $response;

        }

		/*=====================================================
			TODO: Función Limpiar HTML
		======================================================*/

		static public function htmlClean($code){

			$search = array('/\>[^\S ]+/s','/[^\S ]+\</s','/(\s)+/s');

			$replace = array('>','<','\\1');

			$code = preg_replace($search, $replace, $code);

			$code = str_replace("> <", "><", $code);

			return $code;

		}

	}

?>
