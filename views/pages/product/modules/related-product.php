<div class="ps-section--default">

    <div class="ps-section__header">

        <h3>Productos relacionados</h3>

    </div>

    <div class="ps-section__content">

        <div class="ps-carousel--nav owl-slider" data-owl-auto="true" data-owl-loop="true" data-owl-speed="10000"
            data-owl-gap="30" data-owl-nav="true" data-owl-dots="true" data-owl-item="6" data-owl-item-xs="2"
            data-owl-item-sm="2" data-owl-item-md="3" data-owl-item-lg="4" data-owl-item-xl="5" data-owl-duration="1000"
            data-owl-mousedrag="on">

            <?php foreach ($newProduct as $key => $item): ?>

                <div class="ps-product">

                    <div class="ps-product__thumbnail">

                        <!--=====================================================
                            TODO: Imagen del producto
                        ======================================================-->

                        <a href="<?php echo $path.$item->url_product ?>">

                            <img src="<?php echo TemplateController::srcImg() ?>views/img/products/<?php echo $item->url_category ?>/<?php echo $item->picture_product ?>" alt="<?php echo $item->name_product ?>">

                        </a>

                        <!--=====================================================
                            TODO: Descuento de oferta o fuera de stock
                        ======================================================-->

                        <?php if ($item->stock_product == 0): ?>

                        <div class="ps-product__badge out-stock">Agotado</div>

                        <?php else: ?>

                        <?php if ($item->productoffer_product != null): ?>

                        <div class="ps-product__badge">
                            -

                            <?php

                                echo TemplateController::offerDiscount(

                                    $item->price_product,
                                    json_decode($item->productoffer_product,true)[1],
                                    json_decode($item->productoffer_product,true)[0]

                                );

                            ?>


                            %

                        </div>

                        <?php endif ?>

                        <?php endif ?>

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

                        <a class="ps-product__vendor" href="<?php echo $path.$item->url_brand ?>">
                            <?php echo $item->name_brand ?>
                        </a>

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

                            <div class="ps-product__rating">

                                

                            </div>

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
    </div>
</div> <!-- End Related products -->