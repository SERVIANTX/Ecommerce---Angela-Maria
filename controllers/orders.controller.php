<?php

       if(!isset($_COOKIE["DataUserCheckout"])){
            echo '<script>
            window.location.replace("'.TemplateController::path().'")
            </script>';
        }
        /*=====================================================
            TODO: Traer el tipo de Pago
        ======================================================*/
            $status = $_GET['status'];
            $paymentMethod = "";
            $id = "";
            switch($status){
                case "COMPLETED":
                    $paymentMethod = 1;
                    break;
                case "approved":
                    $paymentMethod = 0;
                    break;
                case "Pending":
                    echo '<script>window.location.replace("'.TemplateController::path().'checkout/")</script>' ;
                    break;
                case "On hold":
                    echo '<script>window.location.replace("'.TemplateController::path().'checkout/")</script>' ;
                    break;
                case "Held":
                    echo '<script>window.location.replace("'.TemplateController::path().'checkout/")</script>' ;
                    $paymentMethod = 0;
                    break;
                case "Temporary hold":
                    echo '<script>window.location.replace("'.TemplateController::path().'checkout/")</script>' ;
                    $paymentMethod = 0;
                    break;
                case "Refunded":
                    echo '<script>window.location.replace("'.TemplateController::path().'checkout/")</script>' ;
                    $paymentMethod = 0;
                    break;
                case "Denied":
                    echo '<script>window.location.replace("'.TemplateController::path().'checkout/")</script>' ;
                    $paymentMethod = 0;
                    break;
                case "Unclaimed":
                    echo '<script>window.location.replace("'.TemplateController::path().'checkout/")</script>' ;
                    $paymentMethod = 0;
                    break;
            }


            /*=====================================================
                TODO: Recuperar Información del usuario
            ======================================================*/

            if(isset($_COOKIE["DataUserCheckout"])){

                $dataOrder = json_decode($_COOKIE["DataUserCheckout"],true);

            }

                /*==================================================================
                    TODO: Actualizar Direccion del cliente si activo el checkbox
                ==================================================================*/

                if($dataOrder["addressAcepted"] == 1){
                    $idcustomer = $dataOrder["idUser"];
                    $addresscustomer = $dataOrder["addressOrder"];

                    $url = "customers?id=".$idcustomer."&nameId=id_customer&table=customers&suffix=customer&token=".$_SESSION["user"]->token_customer;
                    $method = "PUT";
                    $fields = 'address_customer='.$addresscustomer;

                    $response = CurlController::request2($url, $method, $fields);
                }

                /*==================================================================
                    TODO: Actualizar Telefono del cliente si activo el checkbox
                ==================================================================*/

                if($dataOrder["phoneAcepted"] == 1){
                    $idcustomer = $dataOrder["idUser"];
                    $phoneOrder = urlencode($dataOrder["phoneOrder"]);

                    $url = "customers?id=".$idcustomer."&nameId=id_customer&table=customers&suffix=customer&token=".$_SESSION["user"]->token_customer;
                    $method = "PUT";
                    $fields = 'phone_customer='.$phoneOrder;

                    $response = CurlController::request2($url, $method, $fields);
                }

                /*==================================================================
                    TODO: Actualizar Ciudad del cliente si activo el checkbox
                ==================================================================*/

                if($dataOrder["cityAcepted"] == 1){
                    $idcustomer = $dataOrder["idUser"];
                    $cityOrder = $dataOrder["cityOrder"];

                    $url = "customers?id=".$idcustomer."&nameId=id_customer&table=customers&suffix=customer&token=".$_SESSION["user"]->token_customer;
                    $method = "PUT";
                    $fields = 'city_customer='.$cityOrder;

                    $response = CurlController::request2($url, $method, $fields);
                }

                /*==================================================================
                    TODO: Actualizar Pais del cliente si activo el checkbox
                ==================================================================*/

                if($dataOrder["countryAcepted"] == 1){
                    $idcustomer = $dataOrder["idUser"];
                    $countryOrder = $dataOrder["countryOrder"];

                    $url = "customers?id=".$idcustomer."&nameId=id_customer&table=customers&suffix=customer&token=".$_SESSION["user"]->token_customer;
                    $method = "PUT";
                    $fields = 'country_customer='.$countryOrder;

                    $response = CurlController::request2($url, $method, $fields);
                }

                /*=============================================
                    TODO: Agrupamos la información
                =============================================*/

                $data = array(

                    "address_order" => $dataOrder["addressOrder"],
                    "phone_order" =>  $dataOrder["phoneOrder"],
                    "notes_order" => $dataOrder["infoOrder"],
                    "id_customer_order" =>  $dataOrder["idUser"],
                    "payment_order" => $paymentMethod,
                    "import_order" => $_SESSION["orderTotal"],
                    "date_created_order" => date("Y-m-d"),

                );
                /*=====================================================
                    TODO: Guardar la orden
                ======================================================*/

                $url = "orders?table=customers&suffix=customer&token=".$_SESSION["user"]->token_customer;
                $method = "POST";
                $fields = $data;

                $response = CurlController::request2($url, $method, $fields);
                if($response->status == 200){
                    $id = $response->results->lastId;
                }else{
                    echo '<script>

                    fncFormatInputs();
                    matPreloader("off");
                    fncSweetAlert("close", "", "");
                    fncNotie(3, "Error al guardar el pedido. Ponte en contacto con la Empresa");

                    </script>';
                }

                if(isset($_COOKIE["listSC"])){

                    $order = json_decode($_COOKIE["listSC"],true);
                }

                foreach ($order as $key => $value):

                    /*=====================================================
                        TODO: Traer id del producto
                    ======================================================*/

                    $select = "id_product,price_product,productoffer_product,stock_product,id_category_product";

                    $url = CurlController::api()."products?linkTo=url_product&equalTo=".$value["product"]."&select=".$select;
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
                            $price = $pOrder->price_product;
                            $subTotalOrder = $price * $value["quantity"];
                        }

                    $id_product = $pOrder->id_product;

                    /*=====================================================
                        TODO: Guardar detalles de la orden
                    ======================================================*/

                    $data = array(

                        "id_order" => $id,
                        "id_product_orderdetail" => $id_product,
                        "quantity_orderdetail" => $value["quantity"],
                        "price_orderdetail" =>  $price,
                        "subtotal_orderdetail" => $subTotalOrder,
                        "id_category_orderdetail" => $pOrder->id_category_product,
                    );


                    $url = "ordersdetails?table=customers&suffix=customer&token=".$_SESSION["user"]->token_customer;
                    $method = "POST";
                    $fields = $data;

                    $response = CurlController::request2($url, $method, $fields);

                    if($response->status == 200){

                        $stockA = $pOrder->stock_product - $value["quantity"];

                        $url = "products?id=".$id_product."&nameId=id_product&table=customers&suffix=customer&token=".$_SESSION["user"]->token_customer;
                        $method = "PUT";
                        $fields = 'stock_product='.$stockA;

                        $response = CurlController::request2($url, $method, $fields);
                        if($response->status == 200){

                            setcookie('DataUserCheckout','',time()-100);
                            setcookie('listSC','',time()-100);

                            /* echo '<script>window.location.replace("http://angelamaria.com/account&my-shopping")</script>' ; */

                        }
                        else{
                            echo '<script>

                            fncFormatInputs();
                            matPreloader("off");
                            fncSweetAlert("close", "", "");
                            fncNotie(3, "Error al guardar el pedido. Ponte en contacto con la Empresa");

                            </script>';
                        }
                    }
                    else{
                        echo '<script>

                            fncFormatInputs();
                            matPreloader("off");
                            fncSweetAlert("close", "", "");
                            fncNotie(3, "Error al guardar el pedido. Ponte en contacto con la Empresa");

                            </script>';
                    }

                endforeach;
?>