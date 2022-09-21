<?php

    $select = "url_category,picture_product,name_product,price_product,url_product,productoffer_product,url_brand,name_brand,picture_brand";

    $url = CurlController::api()."relations?rel=products,categories,subcategories,brands&type=product,category,subcategory,brand&linkTo=id_brand_product&equalTo=".$item->id_brand."&orderBy=id_product&orderMode=DESC&startAt=0&endAt=2&select=".$select;

    $method = "GET";
    $fields = array();
    $header = array();

    $storeProduct =  CurlController::request($url, $method, $fields, $header)->results;

?>

<div class="ps-page__right d-block d-sm-none d-xl-block">

    <aside class="widget widget_product widget_features">

        <p><i class="icon-network"></i> Sus pedidos llegan al instante</p>

        <p><i class="icon-shield-check"></i> Sus datos estan 100% seguros</p>

        <p><i class="icon-receipt"></i> Te brindamos soporte 24/7</p>

        <p><i class="icon-credit-card"></i> Sus pagos en linea estan completamente seguros</p>

    </aside>

    <aside class="widget widget_sell-on-site">

        <p><i class="icon-store"></i> No tienes una cuenta<a href="<?php echo $path."account&enrollment" ?>">> ¡Regístrese ahora!</a></p>

    </aside>

    <aside class="widget widget_same-brand">

        <h3>La misma marca</h3>

        <div class="widget__content">

            <?php foreach ($storeProduct as $key => $item): ?>

            <div class="ps-product">

                <div class="ps-product__thumbnail">

                    <!--=====================================================
                        TODO: Imagen del producto
                    ======================================================-->

                    <a href="<?php echo $path.$item->url_product ?>">

                        <img src="<?php echo TemplateController::srcImg() ?>views/img/products/<?php echo $item->url_category ?>/<?php echo $item->picture_product ?>" alt="<?php echo $item->name_product ?>">

                    </a>

                    <!--=====================================================
                        TODO: Botones de acciones
                    ======================================================-->

                    <ul class="ps-product__actions">

                        <li>
                            <a class="btn"
                                onclick="addShoppingCart('<?php echo $item->url_product ?>','<?php echo CurlController::api() ?>', '<?php echo $_SERVER["REQUEST_URI"] ?>', this)"
                                detailsSC quantitySC data-toggle="tooltip" data-placement="top" title="Añadir al carrito">
                                <i class="icon-bag2"></i>
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo $path.$item->url_product ?>" data-toggle="tooltip" data-placement="top"
                                title="Ver producto">
                                <i class="icon-eye"></i>
                            </a>
                        </li>
                        <?php if(isset($_SESSION["user"])){
                            $id = $_SESSION["user"]->id_customer;
                            }else{
                                $id = 0;
                            }
                        ?>
                        <li>
                            <a class="btn"
                                onclick="addWishlist('<?php echo $item->url_product ?>','<?php echo CurlController::api() ?>','<?php echo $id ?>','<?php echo $_SERVER["REQUEST_URI"] ?>', '<?php echo $path; ?>')"
                                data-toggle="tooltip" data-placement="top" title="Añadir a la lista">
                                <i class="icon-heart"></i>
                            </a>
                        </li>

                    </ul>

                </div>

                <div class="ps-product__container">

                    <!--=====================================================
                        TODO: nombre de la marca
                    ======================================================-->

                    <a class="ps-product__vendor"
                        href="<?php echo $path.$item->url_brand ?>"><?php echo $item->name_brand ?></a>


                    <div class="ps-product__content">

                        <!--=====================================================
                            TODO: nombre del producto
                        ======================================================-->

                        <a class="ps-product__title" href="<?php echo $path.$item->url_product ?>">
                            <?php echo $item->name_product ?>
                        </a>

                        <!--=====================================================
                            TODO: Las reseñas del producto
                        ======================================================-->

                        

                        <!--=====================================================
                            TODO: El precio en oferta del producto
                        ======================================================-->

                        <?php if ($item->productoffer_product != null): ?>

                        <p class="ps-product__price sale">

                            <?php

                                echo "S/.".TemplateController::offerPrice(

                                    $item->price_product,
                                    json_decode($item->productoffer_product,true)[1],
                                    json_decode($item->productoffer_product,true)[0]

                                );

                            ?>

                            <del> S/.<?php echo $item->price_product ?></del>

                        </p>

                        <?php else: ?>

                        <p class="ps-product__price"><?php echo "S/.".$item->price_product ?></p>

                        <?php endif ?>

                    </div>

                    <div class="ps-product__content hover">

                        <!--=====================================================
                            TODO: El nombre del producto
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

                                echo "S/.".TemplateController::offerPrice(

                                    $item->price_product,
                                    json_decode($item->productoffer_product,true)[1],
                                    json_decode($item->productoffer_product,true)[0]

                                );

                            ?>

                            <del> S/.<?php echo $item->price_product ?></del>

                        </p>

                        <?php else: ?>

                        <p class="ps-product__price"><?php echo "S/.".$item->price_product ?></p>

                        <?php endif ?>

                    </div>

                </div>

            </div>

            <?php endforeach ?>

        </div>

    </aside>

</div><!-- End Right Column -->