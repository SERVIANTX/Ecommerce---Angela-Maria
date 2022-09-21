<?php

    if(!isset($_SESSION["user"])){

        echo '<script>

                fncSweetAlert(
                        "error",
                        "Por favor, inicie sesión.",
                        "'.$path.'account&login"
                    );

            </script>';

        return;

    }else{

        $time = time();

        if($_SESSION["user"]->token_exp_customer < $time){

            echo '<script>

                    fncSweetAlert(
                        "error",
                        "Error: El token ha caducado, por favor, inicie sesión de nuevo.",
                        "'.$path.'account&logout"
                    );

                </script>';

            return;

        }

    }

?>



<!--=====================================================
    TODO: Breadcrumb
======================================================-->

<div class="ps-breadcrumb">

    <div class="container">

        <ul class="breadcrumb">

            <li><a href="/">Home</a></li>

            <li><a href="<?php echo $path ?>shopping-cart">Carrito de compras</a></li>

            <li>Confirmar Información</li>

        </ul>

    </div>

</div>
<?php

    require_once "controllers/dataconfirmation.controller.php";

    $create = new InformationController();
    $create -> saveData();

?>
<!--=====================================================
    TODO: Checkout
======================================================-->

<div class="ps-checkout ps-section--shopping">

    <div class="container">

        <div class="ps-section__header">

            <h1>Confirmar Información</h1>

        </div>

        <div class="ps-section__content">

                <form class="ps-form--checkout needs-validation" novalidate method="post">

                <input type="hidden" id="idUser" name="idUser"  value="<?php echo $_SESSION["user"]->id_customer ?>">
                <input type="hidden" id="urlApi" value="<?php echo CurlController::api() ?>">
                <input type="hidden" id="url" value="<?php echo $path ?>">

                <div class="row">

                    <div class="col-xl-7 col-lg-8 col-sm-12">

                        <div class="ps-form__billing-info">

                            <h3 class="ps-form__heading">Detalles de facturación</h3>

                            <!--=====================================================
                                TODO: Nombre completo del usuario
                            ======================================================-->

                            <div class="form-group">

                                <label>Nombres y Apellidos<sup>*</sup></label>

                                <div class="form-group__content">

                                    <input class="form-control" id="clientOrder" name="clientOrder"
                                        value="<?php echo $_SESSION["user"]->displayname_customer ?>" type="text" readonly
                                        required>

                                    <div class="valid-feedback">Campo Valido.</div>
                                    <div class="invalid-feedback">Por favor rellene este campo.</div>

                                </div>

                            </div>

                            <!--=====================================================
                                TODO: Email del usuario
                            ======================================================-->

                            <div class="form-group">

                                <label>Correo Electrónico<sup>*</sup></label>

                                <div class="form-group__content">

                                    <input id="emailOrder" name="emailOrder" class="form-control" type="email"
                                        value="<?php echo $_SESSION["user"]->email_customer ?>" readonly required>

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

                                    <select id="countryOrder" class="form-control select2"  name="countryOrder"
                                        onchange="changeCountry(event)" required>

                                        <?php if ($_SESSION["user"]->country_customer != null): ?>

                                        <option
                                            value="<?php echo $_SESSION["user"]->country_customer ?>_<?php echo explode("_", $_SESSION["user"]->phone_customer)[0] ?>">
                                            <?php echo $_SESSION["user"]->country_customer ?></option>

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
                                TODO: Guardar pais del usuario
                            ======================================================-->

                            <div class="form-group">

                                <div class="ps-checkbox">

                                    <input class="form-control" type="checkbox" id="countryAcepted" name="countryAcepted">

                                    <label for="countryAcepted">¿Desea guardar su Pais?</label>

                                </div>

                            </div>
                            <!--=====================================================
                                TODO: Ciudad del usuario
                            ======================================================-->

                            <div class="form-group">

                                <label>Ciudad<sup>*</sup></label>

                                <div class="form-group__content">

                                    <input id="cityOrder" name="cityOrder" class="form-control" type="text"
                                        pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}" onchange="validateJS(event, 'text')"
                                        value="<?php echo $_SESSION["user"]->city_customer ?>" required>

                                    <div class="valid-feedback">Campo Valido.</div>
                                    <div class="invalid-feedback">Por favor rellene este campo.</div>

                                </div>

                            </div>
                            <!--=====================================================
                                TODO: Guardar Ciudad del usuario
                            ======================================================-->

                            <div class="form-group">

                                <div class="ps-checkbox">

                                    <input class="form-control" type="checkbox" id="cityAcepted" name="cityAcepted">

                                    <label for="cityAcepted">¿Desea guardar su ciudad?</label>

                                </div>

                            </div>
                            <!--=====================================================
                                TODO: Teléfono del usuario
                            ======================================================-->

                            <div class="form-group">

                                <label>Teléfono<sup>*</sup></label>

                                <div class="form-group__content input-group">

                                    <?php if ($_SESSION["user"]->phone_customer != null): ?>

                                    <div class="input-group-append">
                                        <span
                                            class="input-group-text dialCode"><?php echo explode("_", $_SESSION["user"]->phone_customer)[0] ?></span>
                                    </div>

                                    <?php

                                        $phone = explode("_", $_SESSION["user"]->phone_customer)[1];

                                    ?>

                                    <?php else: ?>

                                    <div class="input-group-append">
                                        <span class="input-group-text dialCode">+00</span>
                                    </div>

                                    <?php

                                        $phone = "";

                                    ?>

                                    <?php endif ?>

                                    <input id="phoneOrder" name="phoneOrder" class="form-control" type="text"
                                        pattern="[-\\(\\)\\0-9 ]{1,}" onchange="validateJS(event, 'phone')"
                                        value="<?php echo $phone ?>" required>

                                    <div class="valid-feedback">Campo Valido.</div>
                                    <div class="invalid-feedback">Por favor rellene este campo.</div>

                                </div>

                            </div>
                            <!--=====================================================
                                TODO: Guardar Teléfono del usuario
                            ======================================================-->

                            <div class="form-group">

                                <div class="ps-checkbox">

                                    <input class="form-control" type="checkbox" id="phoneAcepted" name="phoneAcepted">

                                    <label for="phoneAcepted">¿Desea guardar su Teléfono?</label>

                                </div>

                            </div>
                            <!--=====================================================
                                TODO: Dirección del usuario
                            ======================================================-->

                            <div class="form-group">

                                <label>Dirección<sup>*</sup></label>

                                <div class="form-group__content">

                                    <input id="addressOrder" name="addressOrder" class="form-control" type="text"
                                        pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                                        onchange="validateJS(event, 'paragraphs')"
                                        value="<?php echo $_SESSION["user"]->address_customer ?>" required>

                                    <div class="valid-feedback">Campo Valido.</div>
                                    <div class="invalid-feedback">Por favor rellene este campo.</div>

                                </div>

                            </div>

                            <!--=====================================================
                                TODO: Guardar Dirección del usuario
                            ======================================================-->

                            <div class="form-group">

                                <div class="ps-checkbox">

                                    <input class="form-control" type="checkbox" id="addressAcepted" name="addressAcepted">

                                    <label for="addressAcepted">¿Desea guardar su dirección?</label>

                                </div>

                            </div>
                            </form>
                            <!--=====================================================
                                TODO: Información adicional de la orden
                            ======================================================-->

                            <h3 class="mt-40"> Información adicional</h3>

                            <div class="form-group">

                                <label>Notas de pedido</label>

                                <div class="form-group__content">

                                    <textarea id="infoOrder" name="infoOrder" class="form-control" rows="7"
                                        pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                                        onchange="validateJS(event, 'paragraphs')"
                                        placeholder="Notas sobre su pedido, por ejemplo, información especial para la entrega."></textarea>

                                    <div class="valid-feedback">Campo Valido.</div>
                                    <div class="invalid-feedback">Por favor rellene este campo.</div>

                                </div>

                            </div>

                            <!--=====================================================
                                        TODO: Boton para proceder al pago
                            ======================================================-->

                            <div class="form-group">

                                <div class="form-group__content">

                                    <button type="submit" class="ps-btn ps-btn--fullwidth"> Proceder a la compra <i class="icon-arrow-right"></i></button>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>
                </form>
            </div>
        </div>

    </div>

</div>