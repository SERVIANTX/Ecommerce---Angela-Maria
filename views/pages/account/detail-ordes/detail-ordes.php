<?php

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
            if(!isset($_GET["id"])){


                echo '<script>

                window.location = "/account&my-shopping";

            </script>';

        return;
            }

            else{
                $security = base64_decode($_GET["id"]);

            /*=====================================================
                TODO: Data de órdenes
            ======================================================*/
            $select = "id_order,picture_product,name_product,quantity_orderdetail,price_orderdetail,subtotal_orderdetail";

            $url = CurlController::api()."relations?rel=ordersdetails,products&type=orderdetail,product&select=*&linkTo=id_order&equalTo=".$security."&token=".$_SESSION["user"]->token_customer;

            $method = "GET";
            $fields = array();
            $header = array();

            $shopping1 = CurlController::request($url, $method, $fields,$header)->results;

            if(!is_array($shopping1)){

                $shopping1 = array();

            }
            }

           

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
                    <li class="active"><a href="<?php echo $path ?>account&my-shopping">Mis compras</a></li>
                    <li><a href="<?php echo $path ?>account&edit-information">Mi perfil</a></li>
                </ul>

                <!--=====================================================
                    TODO: My Shopping
                ======================================================-->

                <div class="table-responsive">

<table class="table ps-table--whishlist dt-responsive dt-client" width="100%">

<thead>
                    <tr>
                        <th>#</th>
                        <th>Imagen</th>
                        <th>Descripción</th>
                        <th>Cantidad </th>
                        <th>Precio Unitario</th>
                        <th>Total</th>
                    </tr>
                </thead>
                
                <tbody>
                        <?php

                            $Total = 0;
                            $Idcontador = 0;

                            foreach ($shopping1 as $key => $value) :

                                $Total = $Total + $value->subtotal_orderdetail;
                                $Idcontador++;

                        ?>

                            <tr>
                                <td><?php echo $Idcontador ?></td>

                                <?php

                                        $url = "categories?select=url_category&linkTo=id_category&equalTo=".$value->id_category_product;
                                        $method = "GET";
                                        $fields = array();
                                       

                                        $responseCategory = CurlController::request2($url, $method, $fields);
                                        $dataCategory = CurlController::request2($url, $method, $fields)->results;
                                 


                                        if($responseCategory->status == 200){

                                            $datoCategory = $dataCategory;

                                       }
                                       else{

                                           echo '<script>

                                                   window.location = "/account&my-shopping";

                                               </script>';
                                      }

                                        foreach ($datoCategory as $key => $valueCategory) :

                                ?>

                                <td><img src='<?php echo TemplateController::srcImg() ?>views/img/products/<?php echo $valueCategory->url_category ?>/<?php echo $value->picture_product ?>' style='width:70px'></td>

                                <?php endforeach; ?>

                                <td><?php echo $value->name_product ?></td>
                                <td class="text-right"><?php echo $value->quantity_orderdetail ?></td>
                                <td class="text-right">S/ <?php echo $value->price_orderdetail ?></td>
                                <td class="text-right">S/ <?php echo $value->subtotal_orderdetail ?></td>
                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                    <tfoot>
                        <tr>
                        <th class="text-right" colspan="5">SubTotal</th>
                        <th class="text-right">S/ <?php echo $Total ?></th>
                        </tr>
                        <tr>
                        <th class="text-right" colspan="5">Costo de envio</th>
                        <th class="text-right">S/ 3.00</th>
                        </tr>
                        <tr>
                        <th class="text-right" colspan="5">Total</th>
                        <th class="text-right">S/ <?php echo $Total + 3 ?></th>
                        </tr>
                        
                    </tfoot>


</table>

</div><!-- End My Shopping -->


            </div>


        </div>

    </div>

</div>