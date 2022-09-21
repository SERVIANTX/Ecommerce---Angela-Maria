<?php

    class SubscribersController{

        /*=====================================================
            TODO: Registro de suscriptores
        ======================================================*/

        public function register(){

            if(isset($_POST["regEmailSubs"])){

                /*=====================================================
                    TODO: Validamos la sintaxis de los campos
                ======================================================*/

                if( preg_match( '/^[^0-9][.a-zA-Z0-9_]+([.][.a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["regEmailSubs"] ) ){

                    $email =  strtolower($_POST["regEmailSubs"]);

                    $url = CurlController::api()."subscribers?token=no&table=customers&suffix=customer&except=id_subscriber";
                    $method = "POST";
                    $fields = array(

                        "email_subscriber" => $email,
                        "date_created_subscriber" => date("Y-m-d")

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

                        $name = "";
                        $subject = "Estas subscrito";
                        $email = $email;
                        $message = file_get_contents('views/mails/subscriber.html');
                        $message = str_replace("amUrl", TemplateController::path(), $message);
                        $message = str_replace("amWhatsapp", $UrlWhatsapp->value_extrasetting, $message);
                        $message = str_replace("amFacebook", $UrlFacebook->value_extrasetting, $message);
                        $message = str_replace("amInstagram", $UrlInstagram->value_extrasetting, $message);

                        $sendEmail = TemplateController::sendEmail($name, $subject, $email, $message);

                        if($sendEmail == "ok"){

                            echo '<script>

                                        fncFormatInputs();
                                        fncSweetAlert("success", "Gracias por subscribirte", "")

                                    </script>';

                        }else{

                            echo '<script>

                                        fncFormatInputs()

                                    </script>';

                        }

                    }else{

                        echo '<script>

                                    fncFormatInputs();
                                    fncSweetAlert("error", "Lo siento no pudimos subscribirte al newsletter", "")

                                </script>';

                    }

                }else{

                    echo '<script>

                                fncFormatInputs();
                                fncSweetAlert("error", "Lo siento no pudimos subscribirte al newsletter", "")

                            </script>';

                }

            }

        }


    }


?>