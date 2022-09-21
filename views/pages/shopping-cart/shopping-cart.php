<?php

    /*============================================================
        TODO: Traer la Lista del carrito de compras
    =============================================================*/

    $productsSC = array();

    if(isset($_COOKIE["listSC"])){

        $shoppingCart = json_decode($_COOKIE["listSC"],true);

        $select = "url_product,url_category,name_product,picture_product,price_product,productoffer_product,stock_product,name_brand";

        foreach ($shoppingCart as $key => $value) {

            $url = CurlController::api()."relations?rel=products,categories,brands&type=product,category,brand&linkTo=url_product&equalTo=".$value["product"]."&select=".$select;
            $method = "GET";
            $fields = array();
            $header = array();

            array_push($productsSC, CurlController::request($url, $method, $fields, $header)->results[0]);

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

            <li>Carrito de compras</li>

        </ul>

    </div>

</div>

<!--=====================================================
    TODO: Carrito de compras
======================================================-->

<div class="ps-section--shopping ps-shopping-cart">

    <div class="container">

        <div class="ps-section__header">

            <h1>Carrito de compras</h1>

        </div>

        <div class="ps-section__content">

            <div class="table-responsive">

                <table class="table ps-table--shopping-cart dt-responsive">

                    <thead>

                        <tr>

                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>TOTAL</th>
                            <th></th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php foreach ($productsSC as $key => $value): ?>

                            <tr>
                                <td>

                                    <div class="ps-product--cart">

                                        <div class="ps-product__thumbnail">

                                            <a href="<?php echo $path.$value->url_product ?>">
                                                <img src="<?php echo TemplateController::srcImg() ?>views/img/products/<?php echo $value->url_category ?>/<?php echo $value->picture_product ?>" alt="<?php echo $value->name_product ?>">
                                            </a>

                                        </div>

                                        <div class="ps-product__content">

                                            <a href="<?php echo $path.$value->url_product ?>">
                                                <?php echo $value->name_product ?>
                                            </a>

                                            <div class="small text-secondary listSC"
                                                url="<?php echo $value->url_product ?>">

                                                

                                            </div>


                                            <p>Marca:<strong> <?php echo $value->name_brand ?></strong></p>

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

                                                $price = TemplateController::offerPrice(

                                                    $value->price_product,
                                                    json_decode($value->productoffer_product,true)[1],
                                                    json_decode($value->productoffer_product,true)[0]

                                                );

                                                echo "S/.<span>".$price."</span>";

                                            ?>

                                            <del> S/.<?php echo $value->price_product ?></del>

                                        </h4>

                                    <?php else: ?>

                                        <h4 class="ps-product__price">S/.<span><?php echo $value->price_product ?></span></h4>

                                    <?php endif ?>


                                </td>

                                <td>

                                    <div class="form-group--number quantity">

                                        <button
                                        class="up"
                                        onclick="changeQuantity($('#quant<?php echo $key ?>').val(), 'up', <?php echo $value->stock_product ?>, <?php echo $key ?>)">+</button>

                                        <button
                                        class="down"
                                        onclick="changeQuantity($('#quant<?php echo $key ?>').val(),  'down', <?php echo $value->stock_product ?>, <?php echo $key ?>)">-</button>

                                        <input
                                        id="quant<?php echo $key ?>"
                                        class="form-control" type="text" placeholder="1" value="<?php echo $shoppingCart[$key]["quantity"] ?>">

                                    </div>

                                </td>

                                <td>S/.<span class="subtotal">0</span></td>

                                <td>

                                    <a
                                    class="btn"
                                    onclick="removeSC('<?php echo $value->url_product ?>','<?php echo $_SERVER["REQUEST_URI"] ?>')">
                                        <i class="icon-cross"></i>
                                    </a>

                                </td>

                            </tr>

                        <?php endforeach ?>



                    </tbody>

                </table>

            </div>

            <hr>

            <div class="d-flex flex-row-reverse">
                <div class="p-2 totalPrice"><h3>Total S/.<span>0</span></h3></div>
            </div>

            <div class="ps-section__cart-actions">

                <a class="ps-btn" href="categories.html.html">
                    <i class="icon-arrow-left"></i> Volver a la tienda
                </a>

                <?php if (isset($_COOKIE["listSC"]) && $_COOKIE["listSC"] != "[]"): ?>



                    <a class="ps-btn" href="<?php echo $path ?>data_confirmation">
                    Confirmar Información <i class="icon-arrow-right"></i>
                    </a>

                <?php endif ?>


            </div>

        </div>

    </div>

</div>
