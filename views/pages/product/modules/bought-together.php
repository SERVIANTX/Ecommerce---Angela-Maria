<?php
/* echo '<pre>'; print_r($item); echo '</pre>';
return; */

    $select = "id_product,url_category,picture_product,name_product,productoffer_product,price_product,stock_product,url_product,url_brand,name_brand,picture_brand";

    $url = CurlController::api()."relations?rel=products,categories,subcategories,brands&type=product,category,subcategory,brand&linkTo=id_category_product&equalTo=".$item->id_category."&select=".$select;
    $method = "GET";
    $fields = array();
    $header = array();

    $newProduct =  CurlController::request($url, $method, $fields, $header)->results;

    /* echo '<pre>'; print_r(); echo '</pre>';
                return; */

?>

<?php if (count($newProduct) > 1): ?>


<div class="ps-block--bought-toggether">

    <h4>Productos comprados con frecuencia</h4>

    <div class="ps-block__content">

        <div class="ps-block__items">

            <!--=====================================================
                TODO: Producto actual
            ======================================================-->

            <div class="ps-block__item">

                <div class="ps-product ps-product--simple">

                    <div class="ps-product__thumbnail">

                        <!--=====================================================
                            TODO: Imagen del producto
                        ======================================================-->

                        <a href="<?php echo $path.$item->url_product ?>">
                                <img src="<?php echo TemplateController::srcImg() ?>views/img/products/<?php echo $item->url_category ?>/<?php echo $item->picture_product ?>" alt="<?php echo $item->name_product ?>">
                        </a>

                    </div>

                    <div class="ps-product__container">

                        <div class="ps-product__content">

                            <!--=====================================================
                                TODO: nombre del producto
                            ======================================================-->

                            <a class="ps-product__title" href="<?php echo $path.$item->url_product ?>">
                                <?php echo $item->name_product ?>
                            </a>

                            <!--=====================================================
                                TODO: El precio en oferta del producto
                            ======================================================-->

                            <?php if ($item->productoffer_product != null): ?>

                            <p class="ps-product__price sale">

                                <?php

                                    $price1 = TemplateController::offerPrice(

                                        $item->price_product,
                                        json_decode($item->productoffer_product,true)[1],
                                        json_decode($item->productoffer_product,true)[0]

                                    );

                                    echo "S/.".$price1;

                                ?>

                                <del> S/.<?php echo $item->price_product ?></del>

                            </p>

                            <?php else: ?>

                            <?php $price1 = $item->price_product  ?>

                            <p class="ps-product__price"><?php echo "S/.".$item->price_product ?></p>

                            <?php endif ?>

                        </div>

                    </div>

                </div>

            </div>

            <!--=====================================================
                TODO: Nuevo Producto
            ======================================================-->

            <?php foreach ($newProduct as $key => $value): ?>

            <?php if ($value->id_product != $item->id_product): ?>

            <div class="ps-block__item">

                <div class="ps-product ps-product--simple">

                    <div class="ps-product__thumbnail">

                        <!--=====================================================
                            TODO: Imagen del producto
                        ======================================================-->

                        <a href="<?php echo $path.$value->url_product ?>">

                            <img src="<?php echo TemplateController::srcImg() ?>views/img/products/<?php echo $value->url_category ?>/<?php echo $value->picture_product ?>" alt="<?php echo $value->name_product ?>">

                        </a>

                    </div>

                    <div class="ps-product__container">

                        <div class="ps-product__content">

                            <!--=====================================================
                                TODO: nombre del producto
                            ======================================================-->

                            <a class="ps-product__title" href="<?php echo $path.$value->url_product ?>">
                                <?php echo $value->name_product ?>
                            </a>

                            <!--=====================================================
                                TODO: El precio en oferta del producto
                            ======================================================-->

                            <?php if ($value->productoffer_product != null): ?>

                            <p class="ps-product__price sale">

                                <?php

                                        $price2 = TemplateController::offerPrice(

                                        $value->price_product,
                                        json_decode($value->productoffer_product,true)[1],
                                        json_decode($value->productoffer_product,true)[0]

                                    );

                                        echo "S/.".$price2;

                                ?>

                                <del> S/.<?php echo $value->price_product ?></del>

                            </p>

                            <?php else: ?>

                            <?php $price2 = $value->price_product  ?>

                            <p class="ps-product__price"><?php echo "S/.".$value->price_product ?></p>

                            <?php endif ?>

                        </div>

                    </div>

                </div>

            </div>

            <div class="ps-block__item ps-block__total">

                <p>Precio Total:<strong> S/.<?php echo $price1 + $price2  ?></strong></p>

                <a class="ps-btn"
                    onclick="addShoppingCart2('<?php echo $item->url_product ?>','<?php echo $value->url_product ?>','<?php echo CurlController::api() ?>', '<?php echo $_SERVER["REQUEST_URI"] ?>', this)"
                    detailsSC quantitySC>Añadir todo al carrito</a>
                    <?php if(isset($_SESSION["user"])){
                        $id = $_SESSION["user"]->id_customer;
                        }else{
                            $id = 0;
                        }
                    ?>
                <a class="ps-btn ps-btn--gray ps-btn--outline"
                    onclick="addWishlist2('<?php echo $item->url_product ?>','<?php echo $value->url_product ?>','<?php echo CurlController::api() ?>','<?php echo $id?>','<?php echo $_SERVER["REQUEST_URI"] ?>', '<?php echo $path; ?>')">Añadir todo a la lista de deseos</a>

            </div>

        </div>

    </div>

</div>

<?php return; ?>

<?php endif ?>

<?php endforeach ?>

<?php endif ?>