<?php

    require  'extensions/vendor/autoload.php';

    MercadoPago\SDK::setAccessToken('TEST-608485411912974-070814-62316cc295598090fbf1611d4937aa18-424202411');


    $preference = new MercadoPago\Preference();

    $preference->back_urls = array(
        "success" => TemplateController::path()."payment",
        "failure" => TemplateController::path()."checkout/"
    );

    if (isset($_GET['id'])) {
        $varid = $_GET['id'];
    }
    else{
        $varid = 0;
    }

    if(isset($_COOKIE["listSC"])){

        $order = json_decode($_COOKIE["listSC"],true);
    }
    $totalOrder = 0;
    $productos=[];
    $item = new MercadoPago\Item();
    foreach ($order as $key => $value):

        /*=====================================================
            TODO: Traer productos del carrito de compras
        ======================================================*/

        $select = "id_product,name_product,url_product,id_brand,name_brand,url_brand,price_product,productoffer_product,sales_product,stock_product";

        $url = CurlController::api()."relations?rel=products,categories,brands&type=product,category,brand&linkTo=url_product&equalTo=".$value["product"]."&select=".$select;
        $method = "GET";
        $fields = array();
        $header = array();

        $pOrder = CurlController::request($url, $method, $fields, $header)->results[0];

        if ($pOrder->productoffer_product != null){

            $price = TemplateController::offerPrice(

                $pOrder->price_product,
                json_decode($pOrder->productoffer_product,true)[1],
                json_decode($pOrder->productoffer_product,true)[0]

            );

            $subTotalOrder = $price * $value["quantity"];

            }else{
                $subTotalOrder = $pOrder->price_product*$value["quantity"];
            }
            $totalOrder += $subTotalOrder;
    endforeach;
    $TotalMoney = $totalOrder + 3;

    $item->title = "Total";
    $item->quantity = "1";
    $item->unit_price = $TotalMoney;
    array_push($productos,$item);

    $preference->items = $productos;

    $preference->auto_return = "approved";
    $preference->binary_mode = true;

    $preference->save();
    ?>
	<script src="https://sdk.mercadopago.com/js/v2"></script>
	<br>
    <div class="cho-container"></div>
    <br>
    <script>
        const mp = new MercadoPago("TEST-000e11a7-e735-4cf2-bdb2-acbd48e1fdb9", {
            locale: "es-PE",
        });

        mp.checkout({
            preference: {
            id: "<?php echo $preference->id ?>",
            },
            render: {
            container: ".cho-container",
            label: 'Pagar con Mercado Pago!',
            },
            theme: {
                headerColor: "#c0392b",
                elementsColor: "#c0392b" // Color oscuro
                }
        });
    </script>
    <style>
    .mercadopago-button{
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        font-size: 16px;
        font-weight: bold;
        height: 18px !important;
        border-radius: 18px !important;
        display: inline-block !important;
        text-align: center !important;
        height: 100% !important;
        border: 1px solid transparent;
        border-radius: 0 3px 3px 0;
        position: relative;
        width: 100%;
        box-sizing: border-box;
        border: none;
        vertical-align: top;
        cursor: pointer;
        overflow: hidden;
    }
    </style>