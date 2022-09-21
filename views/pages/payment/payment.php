<?php

    require_once ("controllers/orders.controller.php");


    /*=====================================================
        TODO: Traer la orden
    ======================================================*/

    $select = "*";

    $url = CurlController::api()."orders?linkTo=id_customer_order&equalTo=".$_SESSION["user"]->id_customer."&select=".$select."&orderBy=id_order&orderMode=DESC&startAt=0&endAt=1";
    $method = "GET";
    $fields = array();
    $header = array();

    $pOrder = CurlController::request($url, $method, $fields, $header)->results[0];
    $statusOrder = CurlController::request($url, $method, $fields, $header);

    if($statusOrder->status == 200){

        $url = CurlController::api()."users?select=token_phone_user&linkTo=rol_user&equalTo=repart";
        $method = "GET";
        $fields = array();
        $header = array();

        $pNotification = CurlController::request($url, $method, $fields, $header);

        if($pNotification->status == 200){
            $notification = $pNotification->results;
            foreach($notification as $key => $valueToken){

                if($valueToken->token_phone_user != null){
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS =>'{
                        "to": "'.$valueToken->token_phone_user.'",
                        "notification": {
                            "body": "El pedido N° #'.$pOrder->id_order.' esta esperando ser asignado",
                            "title": "🛍️ ¡Nuevo pedido entrante!",
                            "sound": "default",
                            "alert": "New"
                        },
                        "priority": "high",
                        "contentAvailable": true,
                        "data": {
                            "body": "El pedido N° #'.$pOrder->id_order.' esta esperando ser asignado",
                            "title": "🛍️ ¡Nuevo pedido entrante!",
                            "key_1": "Value for key_1",
                            "key_2": "Value for key_2"
                        }
                    }',
                        CURLOPT_HTTPHEADER => array(
                        'Authorization: key=AAAAfch23zA:APA91bFXqT9N-PnrUZ1ecRt5t0qPyfCYAbBjlV_ODQRKDZqMhMJPxrFP9m1BnQBUZEdW45YdRm52oz_VVB_iiiSKfHXhOLhl3FPCXqtX7ykzw-zOWwRrrN-OC2KoF4x3InnPlZo4FJ1X',
                        'Content-Type: application/json'
                    ),
                    ));

                    $response = curl_exec($curl);

                    curl_close($curl);
                }
            }
        }



        $url = CurlController::api()."relations?rel=ordersdetails,products,categories&type=orderdetail,product,category&linkTo=id_order&equalTo=".$pOrder->id_order."&select=name_product,url_product,picture_product,url_category,quantity_orderdetail,price_orderdetail,subtotal_orderdetail";
        $method = "GET";
        $fields = array();
        $header = array();

        $detalles = CurlController::request($url, $method, $fields, $header)->results;
        $statusdetalles = CurlController::request($url, $method, $fields, $header);

        if($statusdetalles->status == 200){

            $tbody = "";

            foreach ($detalles as $key => $valueDetails) {

                $tbody.= '<table data-group="Contents" data-module="Content 4" data-thumbnail="https://editor.maool.com/images/starto/thumbnails/content-4.png" border="0" width="100%" align="center" cellpadding="0" cellspacing="0" style="width:100%;max-width:100%;">
                                <tbody>
                                    <tr>
                                        <td data-bgcolor="Outer Bgcolor" align="center" valign="middle" bgcolor="#F1F1F1" style="background-color: #F1F1F1;">
                                            <table border="0" width="600" align="center" cellpadding="0" cellspacing="0" class="row" style="width:600px;max-width:600px;">
                                                <tbody>
                                                    <tr>
                                                        <td data-bgcolor="Inner Bgcolor" align="center" bgcolor="#FFFFFF" style="background-color:#FFFFFF;">
                                                            <table border="0" width="520" align="center" cellpadding="0" cellspacing="0" class="row" style="width:520px;max-width:520px;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td align="center" class="container-padding">
                                                                            <table border="0" width="100%" cellpadding="0" cellspacing="0" align="center" style="width:100%; max-width:100%;">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td data-resizable-height="" style="font-size:15px;height:15px;line-height:15px;" class="spacer-first ui-resizable">
                                                                                            &nbsp;<div class="ui-resizable-handle ui-resizable-s" style="z-index: 90;"></div>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td align="center" valign="middle">
                                                                                            <!--[if (gte mso 9)|(IE)]><table border="0" cellpadding="0" cellspacing="0"><tr><td><![endif]-->
                                                                                            <table width="100" border="0" cellpadding="0" cellspacing="0" align="left" class="row" style="width:100px;max-width:100px;">
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td align="center" valign="middle">
                                                                                                            <a href="'. $valueDetails->url_product .'"
                                                                                                                style="text-decoration:none;border:0px;"><img
                                                                                                                    data-image="Product Img 1"
                                                                                                                    src="'. TemplateController::srcImg() .'views/img/products/'. $valueDetails->url_category .'/'. $valueDetails->picture_product .'"
                                                                                                                    alt="'. $valueDetails->name_product .'" border="0"
                                                                                                                    width="100"
                                                                                                                    style="display:inline-block!important;border:0;width:100px;max-width:100px;border-radius:8px;"></a>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                            <!--[if (gte mso 9)|(IE)]></td><td><![endif]-->
                                                                                            <table width="20" border="0"
                                                                                                cellpadding="0"
                                                                                                cellspacing="0" align="left"
                                                                                                class="row"
                                                                                                style="width:20px;max-width:20px;">
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td valign="middle"
                                                                                                            align="center"
                                                                                                            height="20">
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                            <!--[if (gte mso 9)|(IE)]></td><td><![endif]-->
                                                                                            <table width="300" border="0"
                                                                                                cellpadding="0"
                                                                                                cellspacing="0" align="left"
                                                                                                class="row"
                                                                                                style="width:300px;max-width:300px;">
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td valign="middle"
                                                                                                            align="center"
                                                                                                            class="autoheight"
                                                                                                            height="10">
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td data-text="Product Title"
                                                                                                            data-font="Primary"
                                                                                                            align="left"
                                                                                                            valign="middle"
                                                                                                            class="center-text"
                                                                                                            style="font-family:&#39;Poppins&#39;, sans-serif;color:#191919;font-size:18px;line-height:28px;font-weight:600;letter-spacing:0px;padding:0px;padding-bottom:5px;"
                                                                                                            contenteditable="true"
                                                                                                            data-gramm="false">
                                                                                                            '. $valueDetails->name_product .'
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td data-text="Product Qty"
                                                                                                            data-font="Primary"
                                                                                                            align="left"
                                                                                                            valign="middle"
                                                                                                            class="center-text"
                                                                                                            style="font-family:&#39;Poppins&#39;, sans-serif;color:#595959;font-size:16px;line-height:26px;font-weight:400;letter-spacing:0px;"
                                                                                                            contenteditable="true"
                                                                                                            data-gramm="false">
                                                                                                            Cant: '. $valueDetails->quantity_orderdetail .', Precio: S/'. $valueDetails->price_orderdetail .'</td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                            <!--[if (gte mso 9)|(IE)]></td><td><![endif]-->
                                                                                            <table width="10" border="0"
                                                                                                cellpadding="0"
                                                                                                cellspacing="0" align="left"
                                                                                                class="row"
                                                                                                style="width:10px;max-width:10px;">
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td valign="middle"
                                                                                                            align="center"
                                                                                                            height="10">
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                            <!--[if (gte mso 9)|(IE)]></td><td><![endif]-->
                                                                                            <table width="90" border="0"
                                                                                                cellpadding="0"
                                                                                                cellspacing="0" align="left"
                                                                                                class="row"
                                                                                                style="width:90px;max-width:90px;">
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td valign="middle"
                                                                                                            align="center"
                                                                                                            class="autoheight"
                                                                                                            height="10">
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td data-text="Product Price"
                                                                                                            data-font="Primary"
                                                                                                            align="right"
                                                                                                            valign="middle"
                                                                                                            class="center-text"
                                                                                                            style="font-family:&#39;Poppins&#39;, sans-serif;color:#191919;font-size:20px;line-height:30px;font-weight:600;letter-spacing:0px;"
                                                                                                            contenteditable="true"
                                                                                                            data-gramm="false">
                                                                                                            S/'. $valueDetails->subtotal_orderdetail .'</td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                            <!--[if (gte mso 9)|(IE)]></td></tr></table><![endif]-->
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td data-resizable-height=""
                                                                                            style="font-size:15px;height:15px;line-height:15px;"
                                                                                            class="ui-resizable">&nbsp;<div
                                                                                                class="ui-resizable-handle ui-resizable-s"
                                                                                                style="z-index: 90;"></div>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>';
            }

            /*=============================================
                TODO: facebook
            =============================================*/

            $url = "extrasettings?select=id_extrasetting,value_extrasetting&linkTo=type_extrasetting&equalTo=facebook";
            $method = "GET";
            $fields = array();
            $response = CurlController::request2($url, $method, $fields);
            if($response->status == 200){ $UrlFacebook = $response->results[0]; }else{ $UrlFacebook = "https://www.facebook.com/"; }

            /*=============================================
                TODO: instagram
            =============================================*/

            $url = "extrasettings?select=id_extrasetting,value_extrasetting&linkTo=type_extrasetting&equalTo=instagram";
            $method = "GET";
            $fields = array();
            $response = CurlController::request2($url, $method, $fields);
            if($response->status == 200){ $UrlInstagram = $response->results[0]; }else{ $UrlInstagram = "https://www.instagram.com/"; }

            /*=============================================
                TODO: whatsapp
            =============================================*/

            $url = "extrasettings?select=id_extrasetting,value_extrasetting&linkTo=type_extrasetting&equalTo=whatsapp";
            $method = "GET";
            $fields = array();
            $response = CurlController::request2($url, $method, $fields);
            if($response->status == 200){ $UrlWhatsapp = $response->results[0]; }else{ $UrlWhatsapp = "https://web.whatsapp.com/"; }

            if($pOrder->payment_order == 1){ $methodPay = "Paypal";}else{ $methodPay = "Mercado Pago";}

            $name = $_SESSION["user"]->displayname_customer;
            $subject = "Tu pedido se ha procesado";
            $email = $_SESSION["user"]->email_customer;
            $message = file_get_contents('views/mails/factura.html');

            $message = str_replace("amDisplayname", $_SESSION["user"]->displayname_customer, $message);
            $message = str_replace("amNumero", $pOrder->id_order, $message);
            $message = str_replace("amFecha", $pOrder->date_created_order, $message);
            $message = str_replace("amMetodo", $methodPay, $message);
            $message = str_replace("amDireccion", $pOrder->address_order, $message);
            $message = str_replace("amSubTotal", $pOrder->import_order - 3, $message);
            $message = str_replace("amTotal", $pOrder->import_order, $message);
            $message = str_replace("amUrl", TemplateController::path(), $message);
            $message = str_replace("amWhatsapp", $UrlWhatsapp->value_extrasetting, $message);
            $message = str_replace("amFacebook", $UrlFacebook->value_extrasetting, $message);
            $message = str_replace("amInstagram", $UrlInstagram->value_extrasetting, $message);
            $message = str_replace('amDetalle', $tbody , $message);

            $sendEmail = TemplateController::sendEmail($name, $subject, $email, $message);

            if($sendEmail == "ok"){

                echo '<script>window.location.replace("'.TemplateController::path().'account&my-shopping")</script>' ;

            }else{

                echo '<script>window.location.replace("'.TemplateController::path().'account&my-shopping")</script>' ;
            }
        }


    }




?>