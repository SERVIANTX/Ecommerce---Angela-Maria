<div class="ps-my-account">

    <div class="container">

        <!--=====================================================
            TODO: Validar veracidad del correo electrónico
        ======================================================-->

        <?php

            if(isset($urlParams[2])){

                $verify = base64_decode($urlParams[2]);

                /*=====================================================
                    TODO: Validamos que el usuario si exista
                ======================================================*/

                $url = CurlController::api()."customers?linkTo=email_customer&equalTo=".$verify."&select=id_customer,displayname_customer,email_customer";
                $method = "GET";
                $fields = array();
                $header = array();

                $item = CurlController::request($url, $method, $fields, $header);

                if(!empty($item)){

                    if($item->status == 200){

                        /*=====================================================
                            TODO: Actualizar el campo de verificación
                        ======================================================*/

                        $url = CurlController::api()."customers?id=".$item->results[0]->id_customer."&nameId=id_customer&token=no&except=verification_customer";
                        $method = "PUT";
                        $fields =  "verification_customer=1";
                        $header = array();

                        $verificationUser = CurlController::request($url, $method, $fields, $header);

                        if($verificationUser->status == 200){

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

                            $name = $item->results[0]->displayname_customer;
                            $subject = "bienvenid@ al minimarket Angela Maria";
                            $email = $item->results[0]->email_customer;
                            $message = file_get_contents('views/mails/welcome.html');
                            $message = str_replace("amDisplayname", $item->results[0]->displayname_customer, $message);
                            $message = str_replace("amUrl", TemplateController::path(), $message);
                            $message = str_replace("amWhatsapp", $UrlWhatsapp->value_extrasetting, $message);
                            $message = str_replace("amFacebook", $UrlFacebook->value_extrasetting, $message);
                            $message = str_replace("amInstagram", $UrlInstagram->value_extrasetting, $message);

                            $sendEmail = TemplateController::sendEmail($name, $subject, $email, $message);

                            if($sendEmail == "ok"){

                                echo '<div class="alert alert-success text-center">Su cuenta ha sido verificada con éxito, ahora puede iniciar sesión.</div>';

                            }
                        }
                    }

                }else{

                    echo '<div class="alert alert-danger text-center">No se pudo verificar la cuenta, el correo electrónico no existe.</div>';

                }


            }

        ?>

        <form class="ps-form--account ps-tab-root needs-validation" novalidate method="post">

            <ul class="ps-tab-list">

                <li class="active">
                    <p><a href="<?php echo $path ?>account&login">Iniciar Sesión</a></p>
                </li>

                <li class="">
                    <p><a href="<?php echo $path ?>account&enrollment">Registro</a></p>
                </li>

            </ul>

            <div class="ps-tabs">

                <!--=====================================================
                    TODO: Login Form
                ======================================================-->

                <div class="ps-tab active" id="sign-in">

                    <div class="ps-form__content">

                        <h5>Inicie sesión en su cuenta</h5>

                        <div class="form-group">

                            <input class="form-control" type="email" placeholder="Email address"
                                pattern="[^0-9][.a-zA-Z0-9_]+([.][.a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}"
                                onchange="validateJS(event,'email')" name="loginEmail" required>

                            <div class="valid-feedback">Válido.</div>
                            <div class="invalid-feedback">Por favor complete este campo correctamente.</div>

                        </div>

                        <div class="form-group form-forgot">

                            <input class="form-control" type="password" placeholder="Password"
                                pattern="[#\\=\\$\\;\\*\\_\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-Z]{1,}"
                                onchange="validateJS(event, 'password')" name="loginPassword" required>

                            <div class="valid-feedback">Válido.</div>
                            <div class="invalid-feedback">Por favor complete este campo correctamente.</div>

                        </div>

                        <div class="form-group">

                            <a href="#resetPassword" data-toggle="modal">Olvidé mi contraseña</a>

                        </div>

                        <div class="form-group">

                            <div class="ps-checkbox">

                                <input class="form-control" type="checkbox" id="remember-me" name="remember-me"
                                    onchange="remember(event)">

                                <label for="remember-me">Acuérdate de mí</label>

                            </div>

                        </div>

                        <?php

                            $login = new UsersController();
                            $login -> login();

                        ?>

                        <div class="form-group submtit">

                            <button type="submit" class="ps-btn ps-btn--fullwidth">Login</button>

                        </div>

                    </div>

                    <div class="ps-form__footer">

                        <p>Iniciar sesión con:</p>

                        <ul class="ps-list--social">

                            <li>
                                <a class="facebook" href="<?php echo $path ?>account&enrollment&facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            </li>
                            <li>
                                <a class="google" href="<?php echo $path ?>account&enrollment&google">
                                    <i class="fab fa-google"></i>
                                </a>
                            </li>

                        </ul>

                    </div>

                </div><!-- End Login Form -->

            </div>

        </form>

    </div>

</div>


<!--=====================================================
    TODO: Ventana modal para recuperar contraseña
======================================================-->

<!-- The Modal -->
<div class="modal" id="resetPassword">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Reset Password</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">

                <form method="post" class="ps-form--account ps-tab-root needs-validation" novalidate>

                    <div class="form-group">

                        <input class="form-control" type="email" placeholder="Email address"
                            pattern="[^0-9][.a-zA-Z0-9_]+([.][.a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}"
                            onchange="validateJS(event,'email')" name="resetPassword" required>

                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill in this field correctly.</div>

                    </div>

                    <?php

                        $reset = new UsersController();
                        $reset -> resetPassword();

                    ?>

                    <div class="form-group submtit">

                        <button type="submit" class="ps-btn ps-btn--fullwidth">Submit</button>

                    </div>


                </form>


            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>