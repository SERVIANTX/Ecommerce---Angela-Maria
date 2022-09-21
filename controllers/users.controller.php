<?php

	use Firebase\JWT\JWT;

	class UsersController{

		/*=====================================================
			TODO: Registro de usuarios
		======================================================*/

		public function register(){

			if(isset($_POST["regEmail"])){

				/*=====================================================
					TODO: Validamos la sintaxis de los campos
				======================================================*/

				if( preg_match( '/^[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["regFirstName"] ) &&
					preg_match( '/^[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["regLastName"] ) &&
					preg_match( '/^[^0-9][.a-zA-Z0-9_]+([.][.a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["regEmail"] ) &&
					preg_match( '/^[#\\=\\$\\;\\*\\_\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-Z]{1,}$/', $_POST["regPassword"] )
				){

					$displayname = TemplateController::capitalize(strtolower($_POST["regFirstName"]))." ".TemplateController::capitalize(strtolower($_POST["regLastName"]));
					$username = strtolower(explode("@",$_POST["regEmail"])[0]);
					$email =  strtolower($_POST["regEmail"]);

					$url = CurlController::api()."customers?register=true&suffix=customer";
					$method = "POST";
					$fields = array(

						"displayname_customer" => $displayname,
						"username_customer" => $username,
						"email_customer" => $email,
						"password_customer" => $_POST["regPassword"],
						"method_customer" => "direct",
						"status_customer" => "1",
						"date_created_customer" => date("Y-m-d")

					);

					$header = array(

						"Content-Type" =>"application/x-www-form-urlencoded"

					);

					$register = CurlController::request($url, $method, $fields, $header);

					if($register->status == 200){


						/*=============================================
                            TODO: facebook
                        =============================================*/

                        $url = "extrasettings?select=id_extrasetting,value_extrasetting&linkTo=type_extrasetting&equalTo=facebook";
                        $method = "GET";
                        $fields = array();

                        $response = CurlController::request2($url, $method, $fields);

                        if($response->status == 200){

                            $UrlFacebook = $response->results[0];

                        }else{

                            $UrlFacebook = "https://www.facebook.com/";
                        }

                        /*=============================================
                            TODO: instagram
                        =============================================*/

                        $url = "extrasettings?select=id_extrasetting,value_extrasetting&linkTo=type_extrasetting&equalTo=instagram";
                        $method = "GET";
                        $fields = array();

                        $response = CurlController::request2($url, $method, $fields);

                        if($response->status == 200){

                            $UrlInstagram = $response->results[0];

                        }else{

                            $UrlInstagram = "https://www.instagram.com/";
                        }

                        /*=============================================
                            TODO: whatsapp
                        =============================================*/

                        $url = "extrasettings?select=id_extrasetting,value_extrasetting&linkTo=type_extrasetting&equalTo=whatsapp";
                        $method = "GET";
                        $fields = array();

                        $response = CurlController::request2($url, $method, $fields);

                        if($response->status == 200){

                            $UrlWhatsapp = $response->results[0];

                        }else{

                            $UrlWhatsapp = "https://web.whatsapp.com/";
                        }

						$name = $displayname;
						$subject = "Verifica tu cuenta";
						$email = $email;
						$message = file_get_contents('views/mails/confirmation-email.html');
						$message = str_replace("amDisplayname", $displayname, $message);
						$message = str_replace("amUrl", TemplateController::path()."account&login&".base64_encode($email), $message);
						$message = str_replace("amWhatsapp", $UrlWhatsapp->value_extrasetting, $message);
                        $message = str_replace("amFacebook", $UrlFacebook->value_extrasetting, $message);
                        $message = str_replace("amInstagram", $UrlInstagram->value_extrasetting, $message);

						$sendEmail = TemplateController::sendEmail($name, $subject, $email, $message);

						if($sendEmail == "ok"){

							echo '<div class="alert alert-success">Usuario registrado con éxito, confirme su cuenta en su correo electrónico (revise el spam)</div>

									<script>

										fncFormatInputs()

									</script>';

						}else{

							echo '<div class="alert alert-danger">'.$sendEmail.'</div>

									<script>

										fncFormatInputs()

									</script>';

						}

					}

				}else{

					echo '<div class="alert alert-danger">Error en la sintaxis de los campos</div>

							<script>

								fncFormatInputs()

							</script>';

				}

			}

		}

		/*=====================================================
			TODO: Login de usuarios
		======================================================*/

		public function login(){

			if(isset($_POST["loginEmail"])){

				/*=====================================================
					TODO: Validamos la sintaxis de los campos
				======================================================*/

				if(	preg_match( '/^[^0-9][.a-zA-Z0-9_]+([.][.a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["loginEmail"] ) &&
					preg_match( '/^[#\\=\\$\\;\\*\\_\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-Z]{1,}$/', $_POST["loginPassword"] )
				){

					echo '<script>

							fncSweetAlert("loading", "", "");

						</script>';

					$url = CurlController::api()."customers?login=true&suffix=customer";
					$method = "POST";
					$fields = array(

						"email_customer" => $_POST["loginEmail"],
						"password_customer" => $_POST["loginPassword"],

					);

					$header = array(

						"Content-Type" =>"application/x-www-form-urlencoded"

					);

					$login = CurlController::request($url, $method, $fields, $header);

					if($login->status == 200){

						if($login->results[0]->verification_customer == 1){

							/* $_SESSION["user"] = $login->results[0];

							echo '<script>

									fncFormatInputs();

									localStorage.setItem("token_customer", "'.$_SESSION["user"]->token_customer.'");

									window.location = "'.TemplateController::path().'account&wishlist";

								</script>
							'; */

							if($login->results[0]->method_customer == "direct"){

								$_SESSION["user"] = $login->results[0];

								echo '<script>

										fncFormatInputs();

										localStorage.setItem("token_customer", "'.$_SESSION["user"]->token_customer.'");

										window.location = "'.TemplateController::path().'account&wishlist";

									</script>';

							}else{

								echo '<div class="alert alert-danger">El usuario está vinculado con GOOGLE o FACEBOOK. Por favor, utilice el login social.</div>


										<script>

											fncSweetAlert("close", "", "");
											fncFormatInputs()

										</script>';

							}

						}else{

							echo '<div class="alert alert-danger">Su cuenta no ha sido verificada todavía, por favor, compruebe su bandeja de entrada de correo electrónico.</div>


									<script>

										fncSweetAlert("close", "", "");
										fncFormatInputs()

									</script>';

						}

					}else{

						echo '<div class="alert alert-danger">'.$login->results.'</div>

								<script>

									fncSweetAlert("close", "", "");
									fncFormatInputs()

								</script>';

					}

				}else{

					echo '<div class="alert alert-danger">Error en la sintaxis de los campos.</div>

							<script>

								fncSweetAlert("close", "", "");
								fncFormatInputs()

							</script>';

				}

			}
		}

		/*=====================================================
			TODO: Conexión con facebook y google
		======================================================*/

		static public function socialConnect($url, $type){

			/*=====================================================
				TODO: Conexión con facebook
			======================================================*/

			if($type == "facebook"){

				$fb = new \Facebook\Facebook([
					'app_id' => '740212024061427',
					'app_secret' => '25ffae963e8fb5d2213ccb8292169068',
					'default_graph_version' => 'v2.10',
					//'default_access_token' => '{access-token}', // optional
				]);

				/*============================================================
					TODO: Creamos la redireccion hacia la API de Facebook
				=============================================================*/

				$handler = $fb->getRedirectLoginHelper();

				/*=====================================================
					TODO: Solicitar datos relacionados al email
				======================================================*/

				$data = ["email"];

				/*===============================================================
					TODO: Activamos la URL de Facebook con los dos parámetros:
							- Url de regreso y los datos que solicitamos
				================================================================*/

				$fullUrl = $handler->getLoginUrl($url, $data);

				/*=====================================================
					TODO: Redireccionamos nuestro sitio hacia Facebook
				======================================================*/

				if(!isset($_GET["code"])){

					echo '<script>

						window.location = "'.$fullUrl.'";

					</script>';

				}

				/*=====================================================
					TODO: Recibimos la respuesta de Facebook
				======================================================*/

				if(isset($_GET["code"])){

					/*=====================================================
						TODO: Solicitamos el access Token de Facebook
					======================================================*/

					try {

						$accessToken = $handler->getAccessToken();

					}catch(\Facebook\Exceptions\FacebookResponseException $e){

						echo "Response Exception: " . $e->getMessage();
						exit();

					}catch(\Facebook\Exceptions\FacebookSDKException $e){

						echo "SDK Exception: " . $e->getMessage();
						exit();

					}


					/*====================================================================================================================
						TODO: Solicitamos la data completa del usuario con el access Token y la guardamos en una variable de Sesión
					=====================================================================================================================*/

					$oAuth2Client = $fb->getOAuth2Client();

					if(!$accessToken->isLongLived())
						$accessToken = $oAuth2Client->getLongLivedAccesToken($accessToken);
						$response = $fb->get("/me?fields=id, first_name, last_name, email, picture.type(large)", $accessToken);
						$userData = $response->getGraphNode()->asArray();

					if(!isset($userData["email"])){

						echo '<div class="container-fluid" style="background:#f1f1f1">
								<div class="container alert alert-danger mb-0">
									Error: Debe permitir el uso de su correo electrónico para el registro, por favor, inténtelo de nuevo
								</div>
							</div>';

						return;

					}


					$displayname = $userData["first_name"]." ".$userData["last_name"];
					$username = explode("@",$userData["email"])[0];
					$email =  $userData["email"];

					/*====================================================================
						TODO: Preguntamos primero si el usuario está registrado
					=====================================================================*/

					$url = CurlController::api()."customers?linkTo=email_customer&equalTo=".$email."&select=*";
					$method = "GET";
					$fields = array();
					$header = array();

					$user = CurlController::request($url, $method, $fields, $header);

					if($user->status == 200){

						if($user->results[0]->method_customer == "facebook"){

							$_SESSION["user"] = $user->results[0];

							/*=====================================================
								TODO: Creación de JWT
							======================================================*/

							$time = time();
							$key = "azscdvfbgnhmjkl1q2w3e4r5t6y7u8i9o";

							$token = array(

								"iat" => $time,  // Tiempo que inició el token
								"exp" => $time + (60*60*24), // Tiempo que expirará el token (+1 dia)
								'data' => [
									"id" =>  $user->results[0]->id_customer,
									"email" =>  $user->results[0]->email_customer
								]
							);

							$jwt = JWT::encode($token, $key);

							$_SESSION["user"]->token_customer = $jwt;
							$_SESSION["user"]->token_exp_customer = $token["exp"];

							/*=====================================================
								TODO: Actualizar Token en BD
							======================================================*/

							$url = CurlController::api()."customers?id=".$_SESSION["user"]->id_customer."&nameId=id_customer&token=no&except=token_customer";
							$method = "PUT";
							$fields =  "token_customer=".$_SESSION["user"]->token_customer;
							$header = array();

							$updateTokenUser = CurlController::request($url, $method, $fields, $header);

							/*===========================================================
								TODO: Actualizar fecha de expiración del Token en BD
							============================================================*/

							$url = CurlController::api()."customers?id=".$_SESSION["user"]->id_customer."&nameId=id_customer&token=no&except=token_exp_customer";
							$method = "PUT";
							$fields =  "token_exp_customer=".$_SESSION["user"]->token_exp_customer;
							$header = array();

							$updateTokenExpUser = CurlController::request($url, $method, $fields, $header);

							echo '<script>

									localStorage.setItem("token_customer", "'.$_SESSION["user"]->token_customer.'");

									window.location = "'.TemplateController::path().'account&wishlist";

								</script>';

						}else{

							echo '<div class="container-fluid" style="background:#f1f1f1">
									<div class="container alert alert-danger mb-0">
										Error: Este usuario está registrado con el método de '.$user->results[0]->method_customer .'.
									</div>
								</div>';
						}

					}else{

						/*=========================================================
							TODO: Registramos el usuario con los datos de facebook
						==========================================================*/

						$url = CurlController::api()."customers?register=true&suffix=customer";
						$method = "POST";
						$fields = array(

							"displayname_customer" => $displayname,
							"username_customer" => $username,
							"email_customer" => $email,
							"picture_customer" => $userData['picture']['url'],
							"method_customer" => "facebook",
							"verification_customer" => 1,
							"status_customer" => 1,
							"date_created_customer" => date("Y-m-d")

						);

						$header = array(

							"Content-Type" =>"application/x-www-form-urlencoded"

						);

						$register = CurlController::request($url, $method, $fields, $header);

						if($register->status == 200){

							$url = CurlController::api()."customers?linkTo=email_customer&equalTo=".$email."&select=*";
							$method = "GET";
							$fields = array();
							$header = array();

							$user = CurlController::request($url, $method, $fields, $header);

							if($user->status == 200){

								/*=============================================
									TODO: facebook
								=============================================*/

								$url = "extrasettings?select=id_extrasetting,value_extrasetting&linkTo=type_extrasetting&equalTo=facebook";
								$method = "GET";
								$fields = array();

								$response = CurlController::request2($url, $method, $fields);

								if($response->status == 200){

									$UrlFacebook = $response->results[0];

								}else{

									$UrlFacebook = "https://www.facebook.com/";
								}

								/*=============================================
									TODO: instagram
								=============================================*/

								$url = "extrasettings?select=id_extrasetting,value_extrasetting&linkTo=type_extrasetting&equalTo=instagram";
								$method = "GET";
								$fields = array();

								$response = CurlController::request2($url, $method, $fields);

								if($response->status == 200){

									$UrlInstagram = $response->results[0];

								}else{

									$UrlInstagram = "https://www.instagram.com/";
								}

								/*=============================================
									TODO: whatsapp
								=============================================*/

								$url = "extrasettings?select=id_extrasetting,value_extrasetting&linkTo=type_extrasetting&equalTo=whatsapp";
								$method = "GET";
								$fields = array();

								$response = CurlController::request2($url, $method, $fields);

								if($response->status == 200){

									$UrlWhatsapp = $response->results[0];

								}else{

									$UrlWhatsapp = "https://web.whatsapp.com/";
								}

								$name = $user->results[0]->displayname_customer;
								$subject = "bienvenid@ al minimarket Angela Maria";
								$email = $user->results[0]->email_customer;
								$message = file_get_contents('views/mails/welcome.html');
								$message = str_replace("amDisplayname", $user->results[0]->displayname_customer, $message);
								$message = str_replace("amUrl", TemplateController::path(), $message);
								$message = str_replace("amWhatsapp", $UrlWhatsapp->value_extrasetting, $message);
								$message = str_replace("amFacebook", $UrlFacebook->value_extrasetting, $message);
								$message = str_replace("amInstagram", $UrlInstagram->value_extrasetting, $message);

								$sendEmail = TemplateController::sendEmail($name, $subject, $email, $message);

								if($sendEmail == "ok"){

									$_SESSION["user"] = $user->results[0];

									echo '<script>

											localStorage.setItem("token_customer", "'.$_SESSION["user"]->token_customer.'");

											window.location = "'.TemplateController::path().'account&wishlist";

										</script>';

								}else{

									$_SESSION["user"] = $user->results[0];

									echo '<script>

											localStorage.setItem("token_customer", "'.$_SESSION["user"]->token_customer.'");

											window.location = "'.TemplateController::path().'account&wishlist";

										</script>';

								}

							}

						}

					}

				}

			}

			/*=====================================================
				TODO: Conexión con google
			======================================================*/

			if($type == "google"){

				$client = new Google\Client();
				$client->setAuthConfig('controllers/client_secret.json');
				$client->setScopes(['profile','email']);
				$redirect_uri = $url;
				$client->setRedirectUri($redirect_uri);
				$fullUrl = $client->createAuthUrl();

				/*=====================================================
					TODO: Redireccionamos nuestro sitio hacia Google
				======================================================*/

				if(!isset($_GET["code"])){

					echo '<script>

							window.location = "'.$fullUrl.'";

						</script>';

				}

				/*=====================================================
					TODO: Recibimos la respuesta de Google
				======================================================*/

				if(isset($_GET['code'])){

					$token = $client->authenticate($_GET["code"]);
					$_SESSION['id_token_google'] = $token;
					$client->setAccessToken($token);

					/*===========================================================
						TODO: RECIBIMOS LOS DATOS CIFRADOS DE GOOGLE EN UN ARRAY
					============================================================*/

					if($client->getAccessToken()){

						$userData = $client->verifyIdToken();

						$displayname = $userData["name"];
						$username = explode("@",$userData["email"])[0];
						$email =  $userData["email"];

						/*===========================================================
							TODO: Preguntamos primero si el usuario está registrado
						============================================================*/

						$url = CurlController::api()."customers?linkTo=email_customer&equalTo=".$email."&select=*";
						$method = "GET";
						$fields = array();
						$header = array();

						$user = CurlController::request($url, $method, $fields, $header);

						if($user->status == 200){

							if($user->results[0]->method_customer == "google"){

								$_SESSION["user"] = $user->results[0];

								/*===========================================================
									TODO: Creación de JWT
								============================================================*/

								$time = time();
								$key = "azscdvfbgnhmjkl1q2w3e4r5t6y7u8i9o";

								$token = array(

									"iat" => $time,  // Tiempo que inició el token
									"exp" => $time + (60*60*24), // Tiempo que expirará el token (+1 dia)
									'data' => [
										"id" =>  $user->results[0]->id_customer,
										"email" =>  $user->results[0]->email_customer
									]
								);

								$jwt = JWT::encode($token, $key);

								$_SESSION["user"]->token_customer = $jwt;
								$_SESSION["user"]->token_exp_customer = $token["exp"];

								/*===========================================================
									TODO: Actualizar Token en BD
								============================================================*/

								$url = CurlController::api()."customers?id=".$_SESSION["user"]->id_customer."&nameId=id_customer&token=no&except=token_customer";
								$method = "PUT";
								$fields =  "token_customer=".$_SESSION["user"]->token_customer;
								$header = array();

								$updateTokenUser = CurlController::request($url, $method, $fields, $header);

								/*===========================================================
									TODO: Actualizar fecha de expiración del Token en BD
								============================================================*/

								$url = CurlController::api()."customers?id=".$_SESSION["user"]->id_customer."&nameId=id_customer&token=no&except=token_exp_customer";
								$method = "PUT";
								$fields =  "token_exp_customer=".$_SESSION["user"]->token_exp_customer;
								$header = array();

								$updateTokenExpUser = CurlController::request($url, $method, $fields, $header);


								echo '<script>

										localStorage.setItem("token_customer", "'.$_SESSION["user"]->token_customer.'");

										window.location = "'.TemplateController::path().'account&wishlist";

									</script>';

							}else{

								echo '<div class="container-fluid" style="background:#f1f1f1">
										<div class="container alert alert-danger mb-0">
											Error: Este usuario está registrado con el método de '.$user->results[0]->method_customer .'.
										</div>
									</div>';
							}


						}else{

							/*===========================================================
								TODO: Registramos el usuario con los datos de facebook
							============================================================*/

							$url = CurlController::api()."customers?register=true&suffix=customer";
							$method = "POST";
							$fields = array(

								"displayname_customer" => $displayname,
								"username_customer" => $username,
								"email_customer" => $email,
								"picture_customer" => $userData['picture'],
								"method_customer" => "google",
								"verification_customer" => 1,
								"status_customer" => 1,
								"date_created_customer" => date("Y-m-d")

							);

							$header = array(

								"Content-Type" =>"application/x-www-form-urlencoded"

							);

							$register = CurlController::request($url, $method, $fields, $header);

							if($register->status == 200){

								$url = CurlController::api()."customers?linkTo=email_customer&equalTo=".$email."&select=*";
								$method = "GET";
								$fields = array();
								$header = array();

								$user = CurlController::request($url, $method, $fields, $header);

								if($user->status == 200){

									/*=============================================
										TODO: facebook
									=============================================*/

									$url = "extrasettings?select=id_extrasetting,value_extrasetting&linkTo=type_extrasetting&equalTo=facebook";
									$method = "GET";
									$fields = array();

									$response = CurlController::request2($url, $method, $fields);

									if($response->status == 200){

										$UrlFacebook = $response->results[0];

									}else{

										$UrlFacebook = "https://www.facebook.com/";
									}

									/*=============================================
										TODO: instagram
									=============================================*/

									$url = "extrasettings?select=id_extrasetting,value_extrasetting&linkTo=type_extrasetting&equalTo=instagram";
									$method = "GET";
									$fields = array();

									$response = CurlController::request2($url, $method, $fields);

									if($response->status == 200){

										$UrlInstagram = $response->results[0];

									}else{

										$UrlInstagram = "https://www.instagram.com/";
									}

									/*=============================================
										TODO: whatsapp
									=============================================*/

									$url = "extrasettings?select=id_extrasetting,value_extrasetting&linkTo=type_extrasetting&equalTo=whatsapp";
									$method = "GET";
									$fields = array();

									$response = CurlController::request2($url, $method, $fields);

									if($response->status == 200){

										$UrlWhatsapp = $response->results[0];

									}else{

										$UrlWhatsapp = "https://web.whatsapp.com/";
									}

									$name = $user->results[0]->displayname_customer;
									$subject = "bienvenid@ al minimarket Angela Maria";
									$email = $user->results[0]->email_customer;
									$message = file_get_contents('views/mails/welcome.html');
									$message = str_replace("amDisplayname", $user->results[0]->displayname_customer, $message);
									$message = str_replace("amUrl", TemplateController::path(), $message);
									$message = str_replace("amWhatsapp", $UrlWhatsapp->value_extrasetting, $message);
									$message = str_replace("amFacebook", $UrlFacebook->value_extrasetting, $message);
									$message = str_replace("amInstagram", $UrlInstagram->value_extrasetting, $message);

									$sendEmail = TemplateController::sendEmail($name, $subject, $email, $message);

									if($sendEmail == "ok"){

										$_SESSION["user"] = $user->results[0];

										echo '<script>

												localStorage.setItem("token_customer", "'.$_SESSION["user"]->token_customer.'");

												window.location = "'.TemplateController::path().'account&wishlist";

											</script>';

									}else{

										$_SESSION["user"] = $user->results[0];

										echo '<script>

												localStorage.setItem("token_customer", "'.$_SESSION["user"]->token_customer.'");

												window.location = "'.TemplateController::path().'account&wishlist";

											</script>';

									}

								}

							}

						}

					}

				}

			}

		}

		/*=====================================================
			TODO: Recuperar contraseña
		======================================================*/

		public function resetPassword(){

			if(isset($_POST["resetPassword"])){

				/*=====================================================
					TODO: Validamos la sintaxis de los campos
				======================================================*/

				if(preg_match( '/^[^0-9][.a-zA-Z0-9_]+([.][.a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["resetPassword"] )
				){

						/*===================================================================
							TODO: Preguntamos primero si el usuario está registrado
						====================================================================*/

						$url = CurlController::api()."customers?linkTo=email_customer&equalTo=".$_POST["resetPassword"]."&select=*";
						$method = "GET";
						$fields = array();
						$header = array();

						$user = CurlController::request($url, $method, $fields, $header);

						if($user->status == 200){

							if($user->results[0]->method_customer == "direct"){

								function genPassword($length){

									$password = "";
									$chain = "123456789abcdefghijklmnopqrstuvwxyz";

									$password = substr(str_shuffle($chain), 0, $length);

									return $password;

								}

								$newPassword = genPassword(11);

								$crypt = crypt($newPassword, '$2a$07$azybxcags23425sdg23sdfhsd$');

								/*===================================================================
									TODO: Actualizar contraseña en base de datos
								====================================================================*/

								$url = CurlController::api()."customers?id=".$user->results[0]->id_customer."&nameId=id_customer&token=no&except=password_customer";
								$method = "PUT";
								$fields =  "password_customer=".$crypt;
								$header = array();

								$updatePassword = CurlController::request($url, $method, $fields, $header);

								if($updatePassword->status == 200){

									/*=============================================
										TODO: facebook
									=============================================*/

									$url = "extrasettings?select=id_extrasetting,value_extrasetting&linkTo=type_extrasetting&equalTo=facebook";
									$method = "GET";
									$fields = array();

									$response = CurlController::request2($url, $method, $fields);

									if($response->status == 200){

										$UrlFacebook = $response->results[0];

									}else{

										$UrlFacebook = "https://www.facebook.com/";
									}

									/*=============================================
										TODO: instagram
									=============================================*/

									$url = "extrasettings?select=id_extrasetting,value_extrasetting&linkTo=type_extrasetting&equalTo=instagram";
									$method = "GET";
									$fields = array();

									$response = CurlController::request2($url, $method, $fields);

									if($response->status == 200){

										$UrlInstagram = $response->results[0];

									}else{

										$UrlInstagram = "https://www.instagram.com/";
									}

									/*=============================================
										TODO: whatsapp
									=============================================*/

									$url = "extrasettings?select=id_extrasetting,value_extrasetting&linkTo=type_extrasetting&equalTo=whatsapp";
									$method = "GET";
									$fields = array();

									$response = CurlController::request2($url, $method, $fields);

									if($response->status == 200){

										$UrlWhatsapp = $response->results[0];

									}else{

										$UrlWhatsapp = "https://web.whatsapp.com/";
									}

									/*===================================================================
										TODO: Enviamos nueva contraseña al correo electrónico
									====================================================================*/

									$name = $user->results[0]->displayname_customer;
									$subject = "Solicitar un nuevo password";
									$email = $user->results[0]->email_customer;
									$message = file_get_contents('views/mails/resetYourPassword.html');
									$message = str_replace("amDisplayname", $user->results[0]->displayname_customer, $message);
									$message = str_replace("amPassword", $newPassword, $message);
									$message = str_replace("amUrl", TemplateController::path()."account&login", $message);
									$message = str_replace("amWhatsapp", $UrlWhatsapp->value_extrasetting, $message);
									$message = str_replace("amFacebook", $UrlFacebook->value_extrasetting, $message);
									$message = str_replace("amInstagram", $UrlInstagram->value_extrasetting, $message);

									$sendEmail = TemplateController::sendEmail($name, $subject, $email, $message);

									if($sendEmail == "ok"){

										echo '<script>

												fncFormatInputs();

												fncNotie(1, "Su nueva contraseña ha sido enviada con éxito, por favor revise su bandeja de entrada de correo electrónico.");

											</script>';

									}else{

										echo '<script>

												fncFormatInputs();

												fncNotie(3, "'.$sendEmail.'");

											</script>';

									}

								}

							}else{

								echo '<script>

										fncFormatInputs();

										fncSweetAlert("error", "No se puede recuperar la contraseña porque te has registrado con '.$user->results[0]->method_customer.'", "")

									</script>';

							}

						}else{

							echo '<script>

									fncFormatInputs();

									fncSweetAlert("error", "Lo sentimos el correo que ingreso no existe en la base de datos", "")

								</script>
							';
						}

				}else{

					echo '<script>

							fncFormatInputs();

							fncNotie(3, "Error en la sintaxis de los campos");

						</script>';

				}

			}

		}

		/*=====================================================
			TODO: Cambiar contraseña
		======================================================*/

		public function changePassword(){

			if(isset($_POST["changePassword"])){

				/*=====================================================
					TODO: Validamos la sintaxis de los campos
				======================================================*/

				if(preg_match('/^[#\\=\\$\\;\\*\\_\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-Z]{1,}$/', $_POST["changePassword"])){

					/*=====================================================
						TODO: Encriptamos la contraseña
					======================================================*/

					$crypt = crypt($_POST["changePassword"], '$2a$07$azybxcags23425sdg23sdfhsd$');

					/*=====================================================
						TODO: Actualizar contraseña en base de datos
					======================================================*/

					$url = CurlController::api()."customers?id=".$_SESSION["user"]->id_customer."&nameId=id_customer&token=".$_SESSION["user"]->token_customer."&table=customers&suffix=customer";
					$method = "PUT";
					$fields =  "password_customer=".$crypt;
					$header = array();

					$updatePassword = CurlController::request($url, $method, $fields, $header);
					if($updatePassword->status == 200){

						/*=============================================================
							TODO: Enviamos nueva contraseña al correo electrónico
						==============================================================*/
						$name = $_SESSION["user"]->displayname_customer;
						$subject = "Change of password";
						$email = $_SESSION["user"]->email_customer;
						$message = "You have changed your password";
						$url = TemplateController::path()."account&login";

						$sendEmail = TemplateController::sendEmail($name, $subject, $email, $message, $url);

						if($sendEmail == "ok"){

							echo '<script>

									fncFormatInputs();

									fncNotie(1, "Su nueva contraseña ha sido enviada con éxito, por favor revise su bandeja de entrada de correo electrónico.");

								</script>
							';

						}else{

							echo '<script>

									fncFormatInputs();

									fncNotie(3, "'.$sendEmail.'");

								</script>
							';

						}

					}else{

						if($updatePassword->status == 303){

							echo '<script>

							fncFormatInputs();

							fncSweetAlert(
								"error",
								"'.$updatePassword->results.'",
								"'.TemplateController::path().'account&logout"
							);

						</script>';


						}else{

							echo '<script>

								fncFormatInputs();

								fncSweetAlert(
									"error",
									"La contraseña no se actualizó, intente nuevamente",
									""
								);

							</script>';

						}
					}

				}else{

					echo '<script>

						fncFormatInputs();

						fncSweetAlert(
							"error",
							"Error en la sintaxis de los campos",
							""
						);

					</script>';

				}


			}

		}

		/*=====================================================
			TODO: Cambiar foto de perfil
		======================================================*/

		public function changePicture(){

			/*=====================================================
				TODO: Validamos la sintaxis de los campos
			======================================================*/

			if(isset($_FILES['changePicture']["tmp_name"]) && !empty($_FILES['changePicture']["tmp_name"])){

				$fields = array(

					"file"=>$_FILES["changePicture"]["tmp_name"],
					"type"=>$_FILES["changePicture"]["type"],
					"folder"=>"customers/".$_SESSION["user"]->id_customer,
					"name"=>$_SESSION["user"]->id_customer,
					"width"=>300,
					"height"=>300
				);

					$saveImage = TemplateController::requestFile($fields);

				if($saveImage != "error"){

					/*=====================================================
						TODO: Actualizar fotografía en base de datos
					======================================================*/

					$url = CurlController::api()."customers?id=".$_SESSION["user"]->id_customer."&nameId=id_customer&token=".$_SESSION["user"]->token_customer."&table=customers&suffix=customer";
					$method = "PUT";
					$fields =  "picture_customer=".$saveImage;
					$header = array();

					$updatePicture = CurlController::request($url, $method, $fields, $header);
					var_dump($updatePicture);
					if($updatePicture->status == 200){

						$_SESSION["user"]->picture_customer = $saveImage;

						echo '<script>

							fncFormatInputs();

							fncSweetAlert(
								"success",
								"Tu nueva foto ha sido cambiada con éxito.",
								"'.$_SERVER["REQUEST_URI"].'"
							);

						</script>';

					}else{

						if($updatePicture->status == 303){

							echo '<script>

							fncFormatInputs();

							fncSweetAlert(
								"error",
								"'.$updatePicture->results.'",
								"'.TemplateController::path().'account&logout"
							);

						</script>';


						}else{

							echo '<script>

								fncFormatInputs();

								fncSweetAlert(
									"error",
									"Ocurrió un error al guardar la imagen, intente nuevamente",
									""
								);

							</script>';

						}
					}


				}else{

					echo '<script>

						fncFormatInputs();

						fncSweetAlert(
							"error",
							"Ocurrió un error al guardar la imagen, intente nuevamente",
							""
						);

					</script>';

				}

			}

		}

	}

?>
