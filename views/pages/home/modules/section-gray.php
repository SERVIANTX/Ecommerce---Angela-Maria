<!--=====================================================
    TODO: Preload
======================================================-->

<div class="container-fluid preloadTrue">

    <div class="container">

        <div class="ph-item">

            <div class="ph-col-2">

                <div class="ph-row">

                    <div class="ph-col-12 big"></div>

                    <div class="ph-col-12 empty"></div>

                    <div class="ph-col-12 empty"></div>

                    <div class="ph-col-8"></div>

                    <div class="ph-col-4 empty"></div>

                    <div class="ph-col-12 empty"></div>

                    <div class="ph-col-12"></div>

                    <div class="ph-col-12 empty"></div>

                    <div class="ph-col-12"></div>

                    <div class="ph-col-12 empty"></div>

                    <div class="ph-col-12"></div>

                    <div class="ph-col-12 empty"></div>

                    <div class="ph-col-12"></div>

                    <div class="ph-col-12 empty"></div>

                    <div class="ph-col-12"></div>

                </div>

            </div>

            <div class="ph-col-2">

                <div class="ph-picture" style="height:500px"></div> 

            </div>

            <div class="ph-col-8">

                <div class="ph-picture" style="height:500px"></div> 

            </div>

        </div>

    </div>

</div>

<!--=====================================================
    TODO: Load
======================================================-->

<div class="ps-section--gray preloadFalse">

    <div class="container">

    <?php

                /*========================================================
                    TODO: Quitar categoría que aún no tenga producto
                ========================================================*/

                foreach ($topCategories as $key => $value) {

                    $url = CurlController::api()."products?select=id_product&linkTo=id_category_product&equalTo=".$value->id_category;
                    $products = CurlController::request($url, $method, $fields, $header);

                    if($products->status == 404){

                        unset($topCategories[$key]);

                    }

                }
                ?>

        <?php foreach ($topCategories as $key => $value): ?>

        <!--=====================================================
            TODO: Products of category
        ======================================================-->

        <div class="ps-block--products-of-category">

            <!--=====================================================
                TODO: Menu subcategory
            ======================================================-->

            <div class="ps-block__categories">

                <h3><?php echo $value->name_category ?></h3>

                    <ul>

                        <!--============================================================
                            TODO: Traer las subcategorías según el id de la categoría
                        =============================================================-->

                        <?php

                            $select = "name_subcategory,url_subcategory";

                            $url = CurlController::api()."subcategories?linkTo=id_category_subcategory&equalTo=".$value->id_category."&startAt=0&endAt=15&select=".$select;
                            $method = "GET";
                            $fields = array();
                            $header = array();

                            $listSubcategories = CurlController::request($url, $method, $fields, $header)->results;

                        ?>

                        <?php foreach ($listSubcategories as $index => $item): ?>

                            <li><a href="<?php echo $path.$item->url_subcategory ?>"><?php echo $item->name_subcategory ?></a></li>

                        <?php endforeach ?>

                    </ul>

                    <a class="ps-block__more-link" href="<?php echo $path.$value->url_category ?>">Ver todo</a>

            </div>


            <?php

                $select ="name_product,picture_product,stock_product,productoffer_product,url_product,price_product";

                $url = CurlController::api()."products?linkTo=id_category_product&equalTo=".$value->id_category."&orderBy=views_product&orderMode=DESC&startAt=0&endAt=6&select=".$select;

                $method = "GET";
                $fields = array();
                $header = array();

                $listProducts = CurlController::request($url, $method, $fields, $header)->results;

            ?>

            <!--=====================================================
                TODO: Vertical Slider Category
            ======================================================-->

            <?php

                $selectSC ="name_product,price_product,picture_product,stock_product,productoffer_product,url_product,picture_vbanner";

                $urlSC = CurlController::api()."relations?rel=vertical_banners,products&type=vbanner,product&linkTo=id_category_product&equalTo=".$value->id_category."&orderBy=views_product&orderMode=DESC&startAt=0&endAt=6&select=".$selectSC;

                $method = "GET";
                $fields = array();
                $header = array();

                $listProductsSC = CurlController::request($urlSC, $method, $fields, $header)->results;

            ?>

            <div class="ps-block__slider">

                <div class="ps-carousel--product-box owl-slider" data-owl-auto="true" data-owl-loop="true" data-owl-speed="7000" data-owl-gap="0" data-owl-nav="true" data-owl-dots="true" data-owl-item="1" data-owl-item-xs="1" data-owl-item-sm="1" data-owl-item-md="1" data-owl-item-lg="1" data-owl-duration="500" data-owl-mousedrag="off">

                    <?php foreach ($listProductsSC as $index => $item): ?>

                        <a href="<?php echo $path.$item->url_product ?>">

                            <img src="<?php echo TemplateController::srcImg() ?>views/img/banners/vertical/<?php echo $item->picture_vbanner ?>" alt="<?php echo $item->name_product ?>">

                        </a>

                    <?php endforeach; ?>

                </div>

            </div>

            <!--=====================================================
                TODO: Block Product Box
            ======================================================-->

            <div class="ps-block__product-box">

                <!--=====================================================
                    TODO: Product Simple
                ======================================================-->

                <?php foreach ($listProducts as $index => $item): ?>

                    <div class="ps-product ps-product--simple">

                        <div class="ps-product__thumbnail">

                            <!--=====================================================
                                TODO: Imagen del producto
                            ======================================================-->

                            <a href="<?php echo $path.$item->url_product ?>">

                                <img src="<?php echo TemplateController::srcImg() ?>views/img/products/<?php echo $value->url_category ?>/<?php echo $item->picture_product ?>" alt="<?php echo $item->name_product ?>">

                            </a>

                            <!--=====================================================
                                TODO: Descuento de oferta o fuera de stock
                            ======================================================-->

                            <?php if ($item->stock_product == 0): ?>

                                <div class="ps-product__badge out-stock">No hay stock</div>

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

                        </div>

                        <div class="ps-product__container">

                            <div class="ps-product__content" data-mh="clothing">

                                <!--=====================================================
                                    TODO: Título del producto
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

        <?php endforeach ?>

    </div>

</div>