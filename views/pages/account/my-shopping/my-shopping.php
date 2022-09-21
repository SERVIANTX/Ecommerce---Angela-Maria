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

        }else{

            /*=====================================================
                TODO: Data de órdenes
            ======================================================*/

            $select = "id_order,date_order,address_order,phone_order,notes_order,status_order,displayname_customer,payment_order,date_created_order,import_order";

            $url = CurlController::api()."relations?rel=orders,customers&type=order,customer&linkTo=id_customer_order&equalTo=".$_SESSION["user"]->id_customer."&select=".$select."&orderBy=id_order&orderMode=DESC&token=".$_SESSION["user"]->token_customer;

            $method = "GET";
            $fields = array();
            $header = array();

            $shopping = CurlController::request($url, $method, $fields, $header)->results;

            if(!is_array($shopping)){

                $shopping = array();

            }

            /* echo '<pre>'; print_r($shopping); echo '</pre>';
            return; */

            /*=====================================================
                TODO: Data de Cliente
            ======================================================*/

            /* $select = "id_order_dispute,content_dispute,answer_dispute,date_answer_dispute,date_created_dispute,method_user,logo_store,url_store";

            $url = CurlController::api()."relations?rel=ordersdetails,products&type=orderdetail,product&linkTo=id_order&equalTo=".$_SESSION["user"]->id_user."&select=".$select."&orderBy=id_dispute&orderMode=DESC&token=".$_SESSION["user"]->token_user;
            $method = "GET";
            $fields = array();
            $header = array();

            $disputes = CurlController::request($url, $method, $fields, $header)->results;

            if(!is_array($disputes)){

                $disputes = array();

            } */

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

                                <th>Orden</th>
                                <th>Fecha</th>
                                <th>Estado de la orden</th>
                                <th>TOTAL</th>
                                <th>ACTIONS</th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php foreach ($shopping  as $key => $value): ?>

                                <tr>

                                    <td class="price text-center">#<?php echo $value->id_order ?></td>


                                    <td class="text-center"><?php echo $value->date_order ?></td>

                                    <?php

                                        switch($value->status_order){
                                            case "0":
                                                echo "<td class='text-center'>No Asignado</td>";
                                                break;
                                            case "1":
                                                echo "<td class='text-center'>Preparando tu pédido</td>";
                                                break;
                                            case "2":
                                                echo "<td class='text-center'>Pedido en camino</td>";
                                                break;
                                            case "3":
                                                echo "<td class='text-center'>Finalizado</td>";
                                                break;
                                        }

                                    ?>

                                    <td class="text-center"><?php echo $value->import_order ?></td>
                                    <td class="text-center">    <a type="button" class="ps-btn"  href='/account&detail-ordes?id=<?php echo base64_encode($value->id_order)?>' >Ver</a>  </td>

                                </tr>

                            <?php endforeach ?>

                        </tbody>

                    </table>

                </div><!-- End My Shopping -->

            </div>
<!--               -------------------                  pruebas-->
<?php

$select = "quantity_orderdetail,price_orderdetail,subtotal_orderdetail";

$url = CurlController::api()."relations?rel=ordersdetails,products&type=orderdetail,product&select=*&linkTo=id_order&equalTo=".$value->id_order."&select=".$select."&token=".$_SESSION["user"]->token_customer;

$method = "GET";
$fields = array();
$header = array();

$shopping1 = CurlController::request($url, $method, $fields, $header)->results;


?>
<!--   *------------------------prubas -->




<!-- incio modal -->
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        ...


        <div class="table-responsive">

<table class="table ps-table--whishlist dt-responsive dt-client" width="100%">

    <thead>

        <tr>

            
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>subtotal</th>
         

        </tr>

    </thead>

    <tbody>

        <?php foreach ($shopping1  as $key => $value): ?>

            <tr>

       


                <td class="text-center"><?php echo $value->quantity_orderdetail ?></td>
                <td class="text-center"><?php echo $value->price_orderdetail ?></td>
                <td class="text-center"><?php echo $value->subtotal_orderdetail ?></td>

                <td class="text-center">Total</td>
                <td class="text-center">    <button type="button" class="ps-btn" data-toggle="modal" data-target="#exampleModalCenter"  >Ver</button>  </td>

            </tr>

        <?php endforeach ?>

    </tbody>

</table>

</div><!-- End My Shopping -->



        




        
        
      </div>
      <div class="modal-footer">
      
      </div>
    </div>
  </div>
</div>
<!-- fin modal -->


        </div>

    </div>

</div>