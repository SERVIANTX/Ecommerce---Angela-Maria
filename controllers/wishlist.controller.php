<?php
    include('curl.controller.php');
    if(isset($_GET['function']) && !empty($_GET['function'])) {
        $function = $_GET['function'];

        switch($function) {
            case 'addwhislist':

                $dataWishlistStatus="";
                $dataProduct = [];
                $count = 0;

                $url = CurlController::api()."customers?select=id_customer,wishlist_customer&linkTo=token_customer,id_customer&equalTo=".$_GET['token'].",".$_GET['idUser'];
                $method = "GET";
                $fields = array();
                $header = array();

                $pOrder = CurlController::request($url, $method, $fields, $header);
                if($pOrder->status = 200){
                    $dataOrder = $pOrder->results[0];
                    $dataWishlist = json_decode($dataOrder->wishlist_customer);
                    if($dataWishlist == null){
                        $dataWishlistStatus="vacio";

                    }
                    else{
                        $dataWishlistStatus="lleno";

                    }
                }
                if($dataWishlistStatus == "vacio"){

                    $arrayTemp = $_GET['urlProduct'];

                    array_push($dataProduct, $arrayTemp);

                    $url = CurlController::api()."customers?id=".$_GET['idUser']."&nameId=id_customer&table=customers&suffix=customer&token=".$_GET['token'];
                    $method = "PUT";

                    $data = "wishlist_customer=".json_encode($dataProduct);
                    $header = array();
                    $addWishList = CurlController::request($url, $method, $data, $header);

                    echo json_encode($addWishList->status);

                }elseif($dataWishlistStatus == "lleno"){

                    $arrayTemp = $_GET['urlProduct'];

                    foreach($dataWishlist as $key => $value){

                        if($value == $arrayTemp){

                            $count = 1;

                        }
                    }
                    if($count == 1){

                        echo 501;

                    }
                    else{
                        array_push($dataWishlist,$arrayTemp);
                        $url = CurlController::api()."customers?id=".$_GET['idUser']."&nameId=id_customer&table=customers&suffix=customer&token=".$_GET['token'];
                        $method = "PUT";
                        $data = "wishlist_customer=".json_encode($dataWishlist);
                        $header = array();
                        $addWishList = CurlController::request($url, $method, $data, $header);

                        echo json_encode($addWishList->status);

                    }

                }elseif($dataWishlistStatus == ""){

                    echo 400;

                }
                else{
                    echo 400;
                }
                break;
            case 'removewishlist':

                $count = -1;

                $arrayTemp = $_GET['urlProduct'];
                $dataWishlist = [];
                $url = CurlController::api()."customers?select=id_customer,wishlist_customer&linkTo=token_customer,id_customer&equalTo=".$_GET['token'].",".$_GET['idUser'];
                $method = "GET";
                $fields = array();
                $header = array();

                $pOrder = CurlController::request($url, $method, $fields, $header);
                if($pOrder->status = 200){
                    $dataOrder = $pOrder->results[0];
                    $dataWishlist = json_decode($dataOrder->wishlist_customer);
                }
                foreach($dataWishlist as $key => $value){
                    $count++;
                    if($value == $arrayTemp){

                        array_splice($dataWishlist, $count, 1);
                        break;

                    }
                }
                $url = CurlController::api()."customers?id=".$_GET['idUser']."&nameId=id_customer&table=customers&suffix=customer&token=".$_GET['token'];
                $method = "PUT";
                $data = "wishlist_customer=".json_encode($dataWishlist);
                $header = array();
                $dataremove = CurlController::request($url, $method, $data, $header);
                echo json_encode($dataremove->status);

                break;
        }
    }
?>