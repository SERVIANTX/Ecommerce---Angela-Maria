<?php

use LDAP\Result;

    if(!isset($_SESSION["user"])){

        echo '<script>

                window.location = "'.$path.'";

            </script>';

        return;

    }else{

        $time = time();

        if($_SESSION["user"]->token_exp_customer < $time){

            echo '<script>

                    fncSweetAlert(
                        "error",
                        "Error: el token ha caducado, por favor, inicie sesión de nuevo.",
                        "'.$path.'account&logout"
                    );

                </script>';

            return;

        }
        else{

            $select = "displayname_customer,country_customer,city_customer,phone_customer,address_customer";

            $url = CurlController::api()."customers?select=".$select."&linkTo=id_customer&equalTo=".$_SESSION["user"]->id_customer;

            $method = "GET";
            $fields = array();
            $header = array();

            $response = CurlController::request($url, $method, $fields, $header);

            if($response->status != 200){
                echo '<script>

                window.location = "'.$path.'";

                </script>';
            }
            require_once ("controllers/profile.controller.php");
        }

    }


?>


<!--=====================================================
    TODO: My Account Content
======================================================-->

<div class="ps-vendor-dashboard pro">

    <div class="container">

        <div class="ps-section__header">

            <!--=====================================================
                TODO: Profile
            ======================================================-->

            <?php include "views/pages/account/profile/profile.php"; ?>

            <!--=====================================================
                TODO: Nav Account
            ======================================================-->

            <div class="ps-section__content">

                <ul class="ps-section__links">
                    <li><a href="<?php echo $path ?>account&wishlist">Mi lista de deseos</a></li>
                    <li><a href="<?php echo $path ?>account&my-shopping">Mis compras</a></li>
                    <li class="active"><a href="<?php echo $path ?>account&edit-information">Mi perfil</a></li>
                </ul>


            </div>


                <form class="ps-form--checkout needs-validation" novalidate method="post">

                <input type="hidden" id="idUser" name="idUser"  value="<?php echo $_SESSION["user"]->id_customer ?>">

                <div class="row">

                    <div class="col-xl-7 col-lg-8 col-sm-12">

                        <div class="ps-form__billing-info">

                            <!--=====================================================
                                TODO: Nombre completo del usuario
                            ======================================================-->

                            <div class="form-group">

                                <label>Nombres y Apellidos<sup>*</sup></label>

                                <div class="form-group__content">

                                    <input class="form-control" id="clientname" name="clientName"
                                        value="<?php echo $response->results[0]->displayname_customer ?>" type="text"
                                        required>

                                    <div class="valid-feedback">Campo Valido.</div>
                                    <div class="invalid-feedback">Por favor rellene este campo.</div>

                                </div>

                            </div>

                            <!--=====================================================
                                TODO: Pais del usuario
                            ======================================================-->

                            <div class="form-group">

                                <label>País<sup>*</sup></label>

                                <?php

                                    $data = file_get_contents("views/assets/json/countries.json");
                                    $countries = json_decode($data, true);

                                ?>

                                <div class="form-group__content">

                                    <select id="clientCountry" class="form-control select2" name="clientCountry"
                                        onchange="changeCountry(event)" required>

                                        <?php if ($response->results[0]->country_customer != null): ?>

                                        <option
                                            value="<?php echo $response->results[0]->country_customer ?>_<?php echo explode("_", $response->results[0]->phone_customer)[0] ?>">
                                            <?php echo $response->results[0]->country_customer ?></option>

                                        <?php else: ?>

                                        <option value>Seleccionar su País</option>

                                        <?php endif ?>

                                        <?php foreach ($countries as $key => $value): ?>

                                        <option value="<?php echo $value["name"] ?>_<?php echo $value["dial_code"] ?>">
                                            <?php echo $value["name"] ?></option>

                                        <?php endforeach ?>

                                    </select>

                                    <div class="valid-feedback">Campo Valido.</div>
                                    <div class="invalid-feedback">Por favor rellene este campo.</div>

                                </div>

                            </div>

                            <!--=====================================================
                                TODO: Ciudad del usuario
                            ======================================================-->

                            <div class="form-group">

                                <label>Ciudad<sup>*</sup></label>

                                <div class="form-group__content">

                                    <input id="clientCity" name="clientCity" class="form-control" type="text"
                                        pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}" onchange="validateJS(event, 'text')"
                                        value="<?php echo $response->results[0]->city_customer ?>" required>

                                    <div class="valid-feedback">Campo Valido.</div>
                                    <div class="invalid-feedback">Por favor rellene este campo.</div>

                                </div>

                            </div>

                            <!--=====================================================
                                TODO: Teléfono del usuario
                            ======================================================-->

                            <div class="form-group">

                                <label>Teléfono<sup>*</sup></label>

                                <div class="form-group__content input-group">

                                    <?php if ($response->results[0]->phone_customer != null): ?>

                                    <div class="input-group-append">
                                        <span
                                            class="input-group-text dialCode"><?php echo explode("_", $response->results[0]->phone_customer)[0] ?></span>
                                    </div>

                                    <?php

                                        $phone = explode("_",$response->results[0]->phone_customer)[1];

                                    ?>

                                    <?php else: ?>

                                    <div class="input-group-append">
                                        <span class="input-group-text dialCode">+00</span>
                                    </div>

                                    <?php

                                        $phone = "";

                                    ?>

                                    <?php endif ?>

                                    <input id="clientPhone" name="clientPhone" class="form-control" type="text"
                                        pattern="[-\\(\\)\\0-9 ]{1,}" onchange="validateJS(event, 'phone')"
                                        value="<?php echo $phone ?>" required>

                                    <div class="valid-feedback">Campo Valido.</div>
                                    <div class="invalid-feedback">Por favor rellene este campo.</div>

                                </div>

                            </div>

                            <!--=====================================================
                                TODO: Dirección del usuario
                            ======================================================-->

                            <div class="form-group">

                                <label>Dirección<sup>*</sup></label>

                                <div class="form-group__content">

                                    <input id="clientAddress" name="clientAddress" class="form-control" type="text"
                                        pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                                        onchange="validateJS(event, 'paragraphs')"
                                        value="<?php echo $response->results[0]->address_customer ?>" required>

                                    <div class="valid-feedback">Campo Valido.</div>
                                    <div class="invalid-feedback">Por favor rellene este campo.</div>

                                </div>

                            </div>

                            <!--=====================================================
                                        TODO: Boton para proceder al pago
                            ======================================================-->

                            <div class="form-group">

                                <div class="form-group__content">

                                    <button type="submit" class="ps-btn ps-btn--fullwidth"> Guardar cambios </button>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>
                </form>
        </div>

    </div>

</div>