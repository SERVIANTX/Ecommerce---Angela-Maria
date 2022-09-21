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
    if(!isset($_COOKIE["DataUserCheckout"])){
        echo '<script>
        window.location.replace("'.TemplateController::path().'data_confirmation")
        </script>';
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

            <li><a href="<?php echo $path ?>data_confirmation">Confirmar Información</a></li>

            <li>Checkout</li>

        </ul>

    </div>

</div>

<!--=====================================================
    TODO: Checkout
======================================================-->

<div class="ps-checkout ps-section--shopping">

    <div class="container">

        <div class="ps-section__header">

            <h1>Checkout</h1>

        </div>

        <div class="ps-section__content">

            <?php
                $dataClient = json_decode($_COOKIE["DataUserCheckout"], true);
            ?>

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

                                    <input class="form-control"
                                        value="<?php echo $dataClient["clientOrder"] ?>" type="text" readonly
                                        required>

                                </div>

                            </div>

                            <!--=====================================================
                                TODO: Email del usuario
                            ======================================================-->

                            <div class="form-group">

                                <label>Correo Electrónico<sup>*</sup></label>

                                <div class="form-group__content">

                                    <input id="emailOrder" class="form-control" type="email"
                                        value="<?php echo $dataClient["emailOrder"] ?>" readonly required>

                                </div>

                            </div>
                            <!--=====================================================
                                TODO: Pais del usuario
                            ======================================================-->

                            <div class="form-group">

                                <label>País<sup>*</sup></label>

                                <div class="form-group__content">

                                <input id="countryOrder" class="form-control" type="text"
                                        value="<?php echo $dataClient["countryOrder"] ?>" readonly required>

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

                                    <input id="cityOrder" class="form-control" type="text"
                                        pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}" onchange="validateJS(event, 'text')"
                                        value="<?php echo $dataClient["cityOrder"] ?>" required readonly>

                                </div>

                            </div>

                            <!--=====================================================
                                TODO: Teléfono del usuario
                            ======================================================-->

                            <div class="form-group">

                                <label>Teléfono<sup>*</sup></label>

                                <div class="form-group__content input-group">

                                    <div class="input-group-append">
                                        <span
                                            class="input-group-text dialCode"><?php echo explode("_", $dataClient["phoneOrder"])[0] ?></span>
                                    </div>

                                    <input id="phoneOrder" class="form-control" type="text"
                                        pattern="[-\\(\\)\\0-9 ]{1,}" onchange="validateJS(event, 'phone')"
                                        value="<?php echo explode("_", $dataClient["phoneOrder"])[1]  ?>" required readonly>

                                </div>

                            </div>

                            <!--=====================================================
                                TODO: Dirección del usuario
                            ======================================================-->

                            <div class="form-group">

                                <label>Dirección<sup>*</sup></label>

                                <div class="form-group__content">

                                    <input id="addressOrder" class="form-control" type="text"
                                        pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                                        onchange="validateJS(event, 'paragraphs')"
                                        value="<?php echo $dataClient["addressOrder"] ?>" required readonly>
                                </div>

                            </div>

                            <!--=====================================================
                                TODO: Información adicional de la orden
                            ======================================================-->

                            <h3 class="mt-40"> Información adicional</h3>

                            <div class="form-group">

                                <label>Notas de pedido</label>

                                <div class="form-group__content">

                                    <textarea id="infoOrder" class="form-control" rows="7"
                                        pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                                        onchange="validateJS(event, 'paragraphs')"
                                        readonly><?php echo $dataClient["infoOrder"] ?></textarea>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!--=====================================================
                        TODO: Información de la orden
                    ======================================================-->

                    <div class="col-xl-5 col-lg-4 col-sm-12">

                        <div class="ps-form__total">

                            <h3 class="ps-form__heading">Tu pedido</h3>

                            <div class="content">

                                <div class="ps-block--checkout-total">

                                    <div class="ps-block__header d-flex justify-content-between">

                                        <p>Producto</p>

                                        <p>Total</p>

                                    </div>

                                    <?php

                                        $totalOrder = 0;

                                        if(isset($_COOKIE["listSC"])){

                                            $order = json_decode($_COOKIE["listSC"],true);
                                        }else{

                                            echo '<script>

                                                    window.location = "'.$path.'";

                                                </script>';

                                            return;

                                        }

                                    ?>

                                    <div class="ps-block__content">

                                        <table class="table ps-block__products">

                                            <tbody>

                                                <?php foreach ($order as $key => $value): ?>

                                                <?php

                                                    $subTotalOrder = 0;

                                                    /*=====================================================
                                                        TODO: Traer productos del carrito de compras
                                                    ======================================================*/

                                                    $select = "id_product,name_product,url_product,id_brand,name_brand,url_brand,price_product,productoffer_product,sales_product,stock_product";

                                                    $url = CurlController::api()."relations?rel=products,categories,brands&type=product,category,brand&linkTo=url_product&equalTo=".$value["product"]."&select=".$select;
                                                    $method = "GET";
                                                    $fields = array();
                                                    $header = array();

                                                    $pOrder = CurlController::request($url, $method, $fields, $header)->results[0];


                                                ?>

                                                <tr>

                                                    <td>

                                                        <!-- <input type="hidden" class="idStore"
                                                            value="<?php /* echo $pOrder->id_store */ ?>"> -->
                                                        <input type="hidden" class="idProduct"
                                                            value="<?php echo $pOrder->id_product ?>">
                                                        <!-- <input type="hidden" class="urlStore"
                                                            value="<?php /* echo $pOrder->url_store */ ?>"> -->
                                                        <input type="hidden" class="salesProduct"
                                                            value="<?php echo $pOrder->sales_product ?>">
                                                        <input type="hidden" class="stockProduct"
                                                            value="<?php echo $pOrder->stock_product ?>">

                                                        <!--=====================================================
                                                            TODO: Nombre del producto
                                                        ======================================================-->

                                                        <a href="<?php echo $path.$pOrder->url_product ?>"
                                                            class="nameProduct"> <?php echo $pOrder->name_product ?></a>

                                                        <div class="small text-secondary">

                                                            <!--=====================================================
                                                                TODO: Marca del producto
                                                            ======================================================-->

                                                            <div>Marca: <a
                                                                    href="<?php echo $path.$pOrder->url_brand ?>"><strong><?php echo $pOrder->name_brand ?></strong></a>
                                                            </div>

                                                            <!--=====================================================
                                                                TODO: Detalles del producto
                                                            ======================================================-->

                                                            <!--=====================================================
                                                                TODO: Precio de envío del producto
                                                            ======================================================-->


                                                            <!--=====================================================
                                                                TODO: Cantidad del producto
                                                            ======================================================-->

                                                            <div>Cantidad: <span
                                                                    class="quantityOrder"><?php echo $value["quantity"] ?></span>
                                                            </div>

                                                        </div>
                                                    </td>

                                                    <!--=====================================================
                                                        TODO: Precio definitivo del producto
                                                    ======================================================-->

                                                    <?php

														if ($pOrder->productoffer_product != null){

                                                                $price = TemplateController::offerPrice(

                                                                    $pOrder->price_product,
                                                                    json_decode($pOrder->productoffer_product,true)[1],
                                                                    json_decode($pOrder->productoffer_product,true)[0]

                                                                );

                                                                $subTotalOrder += $price*$value["quantity"];

														}else{


															$subTotalOrder += $pOrder->price_product*$value["quantity"];


														}

														$totalOrder += $subTotalOrder;
                                                        $shipping = 3;

													?>
                                                    <td class="text-right">S/.<span class="priceOrder"><?php echo $subTotalOrder ?></span></td>

                                                </tr>

                                                <?php endforeach ?>

                                            </tbody>

                                        </table>
                                        <h3 class="text-right totalOrder">Envio
                                            <span>S/.<?php
                                            if(empty($shipping)){
                                                echo '<script>

                                                    window.location = "'.$path.'";

                                                </script>';
                                            }else{
                                                echo $shipping;
                                            }
                                            ?></span></h3>
                                        <h3 class="text-right totalOrder" total="<?php echo $totalOrder ?>">Total
                                            <span>S/.<?php $TotalPay = $totalOrder + $shipping; echo $TotalPay;
                                                    $_SESSION["orderTotal"] = $TotalPay;?></span></h3>
                                    </div>

                                </div>

                                <hr class="py-3">

                                <div class="form-group">

                                        <?php require_once ("controllers/mercadopago.controller.php") ?>

                                </div>
                                <div class="form-group">

                                        <?php require_once ("controllers/paypal.controller.php") ?>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

        </div>

    </div>

</div>



<?php


    /*=========================================================
        TODO: Recibir variables de PAYU página de respuesta
    ==========================================================*/

    if (isset($_REQUEST['transactionState']) && $_REQUEST['transactionState'] == 4 && isset($_REQUEST['reference_pol'])) {

        $idPayment = $_REQUEST['reference_pol'];

        endCheckout($_REQUEST['reference_pol']);

    }

    /*=========================================================
        TODO: Recibir variables de PAYU página de confirmación
    ==========================================================*/

    if (isset($_REQUEST['state_pol']) && $_REQUEST['state_pol'] == 4 && isset($_REQUEST['reference_pol'])) {

        $idPayment = $_REQUEST['reference_pol'];

        endCheckout($_REQUEST['reference_pol']);

    }

    /*=========================================================
        TODO: Recibir variables de MP
    ==========================================================*/

    if(isset($_COOKIE["mp"])){

        $mp = json_decode($_COOKIE["mp"], true);

        MercadoPago\SDK::setAccessToken("YOUR ACCESS TOKEN");

        $payment = new MercadoPago\Payment();
        $payment->transaction_amount = $mp["transaction_amount"];
        $payment->token = $mp["token"];
        $payment->description = $mp['description'];
        $payment->installments = $mp['installments'];
        $payment->payment_method_id = $mp['payment_method_id'];
        $payment->issuer_id = $mp['issuer_id'];

        $payer = new MercadoPago\Payer();
        $payer->email = $mp['email'];
        $payer->identification = array(
            "type" => $mp['identificationType'],
            "number" => $mp['identificationNumber']
        );
        $payment->payer = $payer;

        $payment->save();

        if($payment->status == "approved"){

            endCheckout($payment->id);

        }
    }


    /*=========================================================
        TODO: Función para finalizar el checkout
    ==========================================================*/

    function endCheckout($idPayment){

        $totalProcess = 0;

        /*===========================================================================
            TODO: Actualizamos las ventas y disminuir el stock de los productos
        ===========================================================================*/

        if(isset($_COOKIE['idProduct']) && isset($_COOKIE['quantityOrder']) ){

            $idProduct = json_decode($_COOKIE['idProduct'], true);
            $quantityOrder = json_decode($_COOKIE['quantityOrder'], true);

            foreach ($idProduct as $key => $value) {

                $url = CurlController::api()."products?linkTo=id_product&equalTo=".$value."&select=stock_product,sales_product";
                $method = "GET";
                $fields = array();
                $header = array();

                $products = CurlController::request($url, $method, $fields, $header)->results[0];

                /*===========================================================================
                    TODO: Actualizamos las ventas y disminuimos el stock de los productos
                ===========================================================================*/

                $stock = $products->stock_product-$quantityOrder[$key];
                $sales = $products->sales_product+$quantityOrder[$key];

                /*===========================================================================
                    TODO: Actualizar el stock y las ventas de cada producto
                ===========================================================================*/

                $url = CurlController::api()."products?id=".$value."&nameId=id_product&token=".$_SESSION["user"]->token_customer;
                $method = "PUT";
                $fields =  "sales_product=".$sales."&stock_product=".$stock;
                $header = array();

                $updateProducts = CurlController::request($url, $method, $fields, $header);

                if($updateProducts->status == 200){

                    $totalProcess++;
                }
            }

        }

        /*===========================================================================
            TODO: Actualizamos el estado de la orden
        ===========================================================================*/

        if(isset($_COOKIE['idOrder'])){

            $idOrder= json_decode($_COOKIE['idOrder'], true);

            foreach ($idOrder as $key => $value) {

                $url = CurlController::api()."orders?id=".$value."&nameId=id_order&token=".$_SESSION["user"]->token_customer;
                $method = "PUT";
                $fields =  "status_order=pending";
                $header = array();

                $updateOrders = CurlController::request($url, $method, $fields, $header);

                if($updateOrders->status == 200){

                    $totalProcess++;
                }

            }

        }

        /*===========================================================================
            TODO: Actualizamos el estado de la venta
        ===========================================================================*/

        if(isset($_COOKIE['idSale'])){

            $idSale = json_decode($_COOKIE['idSale'], true);

            foreach ($idSale as $key => $value) {

                $url = CurlController::api()."sales?id=".$value."&nameId=id_sale&token=".$_SESSION["user"]->token_customer;
                $method = "PUT";
                $fields =  "status_sale=pending&id_payment_sale=".$idPayment;
                $header = array();

                $updateSales = CurlController::request($url, $method, $fields, $header);

                if($updateSales->status == 200){

                    $totalProcess++;
                }

            }

        }

        /*===========================================================================
            TODO: Cerramos el proceso de venta
        ===========================================================================*/

        if($totalProcess == (count($idProduct)+count($idOrder)+count($idSale))){

            echo '<script>

                    document.cookie = "listSC=; max-age=0";
                    document.cookie = "idProduct=; max-age=0";
                    document.cookie = "quantityOrder=; max-age=0";
                    document.cookie = "idOrder=; max-age=0";
                    document.cookie = "idSale=; max-age=0";
                    fncSweetAlert("success", "The purchase has been executed successfully", "/account&my-shopping");

                </script>';

        }
    }


?>