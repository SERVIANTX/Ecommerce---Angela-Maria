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
                        "Error: el token ha caducado, por favor, inicie sesión de nuevo",
                        "'.$path.'account&logout"
                    );

                </script>';

            return;

        }else{

            /*=====================================================
                TODO: Traer la Lista de deseos
            ======================================================*/

            $select = "url_product,url_category,name_product,picture_product,price_product,productoffer_product,stock_product";
            $productsWishlist = array();

            foreach ($wishlist as $key => $value) {

                $url = CurlController::api()."relations?rel=products,categories&type=product,category&linkTo=url_product&equalTo=".$value."&select=".$select;
                $method = "GET";
                $fields = array();
                $header = array();

                array_push($productsWishlist, CurlController::request($url, $method, $fields, $header)->results[0]);

            }

        }

    }

?>



<div class="ps-vendor-dashboard pro">

    <div class="container">

        <div class="ps-section__header">

            <!--=====================================================
                TODO: Profile
            ======================================================-->

            <?php

                include "views/pages/account/profile/profile.php";

            ?>

            <!--=====================================================
                TODO: Nav Account
            ======================================================-->

            <div class="ps-section__content">

                <ul class="ps-section__links">
                    <li class="active"><a href="<?php echo $path ?>account&wishlist">Mi lista de deseos</a></li>
                    <li><a href="<?php echo $path ?>account&my-shopping">Mis compras</a></li>
                    <li><a href="<?php echo $path ?>account&edit-information">Mi perfil</a></li>
                </ul>

                <!--=====================================================
                    TODO: Wishlist
                ======================================================-->

                <div class="table-responsive">

                    <table class="table ps-table--whishlist dt-responsive dt-client">

                        <thead>

                            <tr>

                                <th>Nombre del producto</th>

                                <th>Precio por unidad</th>

                                <th>Stock Status</th>

                                <th></th>

                                <th></th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php foreach ($productsWishlist as $key => $value): ?>

                            <tr>

                                <td>
                                    <div class="ps-product--cart">

                                        <div class="ps-product__thumbnail">
                                            <a href="<?php echo $path.$value->url_product ?>">
                                                <img
                                                    src="<?php echo TemplateController::srcImg() ?>views/img/products/<?php echo $value->url_category ?>/<?php echo $value->picture_product ?>">
                                            </a>
                                        </div>

                                        <div class="ps-product__content">
                                            <a href="<?php echo $path.$value->url_product ?>">
                                                <?php echo $value->name_product ?>
                                            </a>
                                        </div>
                                    </div>
                                </td>

                                <td class="ps-product">

                                    <!--=====================================================
                                        TODO: El precio en oferta del producto
                                    ======================================================-->

                                    <?php if ($value->productoffer_product != null): ?>

                                    <h4 class="ps-product__price sale">

                                        <?php

                                            echo "$".TemplateController::offerPrice(

                                                $value->price_product,
                                                json_decode($value->productoffer_product,true)[1],
                                                json_decode($value->productoffer_product,true)[0]

                                            );

                                        ?>

                                        <del> $<?php echo $value->price_product ?></del>

                                    </h4>

                                    <?php else: ?>

                                    <h4 class="ps-product__price">$<?php echo $value->price_product ?></h4>

                                    <?php endif ?>

                                </td>

                                <td>

                                    <!--=====================================================
                                        TODO: Stock del producto
                                    ======================================================-->

                                    <?php if ($value->stock_product == 0): ?>

                                    <span class="ps-tag ps-tag--out-stock"> Agotado</span>

                                    <?php else: ?>

                                    <span class="ps-tag ps-tag--in-stock">En-stock</span>

                                    <?php endif ?>

                                </td>

                                <td>
                                    <a class="ps-btn"
                                        onclick="addShoppingCart('<?php echo $value->url_product ?>','<?php echo CurlController::api() ?>', '<?php echo $_SERVER["REQUEST_URI"] ?>', this)"
                                        detailsSC quantitySC>Añadir al carrito
                                    </a>
                                </td>
                                <td>
                                    <a class="ps-btn"
                                        onclick="removeWishlist('<?php echo $value->url_product ?>', '<?php echo CurlController::api() ?>', '<?php echo $path; ?>','<?php echo $_SESSION["user"]->id_customer?>')">
                                        <i class="icon-cross"></i>
                                    </a>
                                </td>

                            </tr>

                            <?php endforeach ?>


                        </tbody>

                    </table>

                </div>

            </div>


        </div>

    </div>

</div>