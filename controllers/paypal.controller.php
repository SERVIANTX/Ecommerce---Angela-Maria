<?php
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

            $subTotalOrder = $price*$value["quantity"];

        }
        else{
                $subTotalOrder = $pOrder->price_product*$value["quantity"];

            }
            $totalOrder += $subTotalOrder;
    endforeach;
    $TotalMoney = $totalOrder + 3;
?>

<div id="paypal-button-contaniner"></div>
<script>
    function round(num) {
            var m = Number((Math.abs(num) * 100).toPrecision(15));
            return Math.round(m) / 100 * Math.sign(num);
        }

    var amount = <?php echo $TotalMoney ?>;
    var url = "https://api.apilayer.com/exchangerates_data/convert?to=USD&from=PEN&amount="+amount;
    var myHeaders = new Headers();
            myHeaders.append("apikey", "o3npDDLsHM9F1FdPY9vXxI0o8WzuV8cq");

            var requestOptions = {
            method: 'GET',
            headers: myHeaders,
            redirect: 'follow'
            };

            fetch(url, requestOptions)
            .then(res => res.json())
            .then(data => {
                pagarpaypal(data)
            });
    const pagarpaypal = (data) => {
        var amountPEN = data.result;
        var dato = round(amountPEN);
        paypal.Buttons({
        style:{
            color:'blue',
            shape:'pill',
            label:'buynow'
        },
        createOrder: function(data, actions){
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: dato
                    }
                }]
            });
        },
        onApprove: (data, actions) => {
        return actions.order.capture().then(function(orderData) {
            const transaction = orderData.purchase_units[0].payments.captures[0];
            var id = transaction.status;
            window.location.href="/payment?status="+id;
        });
        },
        onCancel: function(data){
        }
    }).render('#paypal-button-contaniner');
    }
</script>


