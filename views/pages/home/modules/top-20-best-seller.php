<?php

    $select = "url_product,picture_product,name_product,productoffer_product,price_product,url_category";

    $url = CurlController::api()."relations?rel=products,categories&type=product,category&orderBy=sales_product&orderMode=DESC&startAt=0&endAt=20&select=".$select;
    $method = "GET";
    $fields = array();
    $header = array();

    $topSalesProducts = CurlController::request($url, $method, $fields, $header)->results;

    $topSales = array();

    /*=====================================================
        TODO: Organizar bloques de a 5 productos
    ======================================================*/

    for($i = 0; $i < ceil(count($topSalesProducts)/4); $i++){

        array_push($topSales, array_slice($topSalesProducts, $i*4 , 4));

    }

?>


<div class="col-xl-3 col-12 ">

    <aside class="widget widget_best-sale" data-mh="dealhot">

        <h3 class="widget-title">Los 20 más vendidos</h3>

        <div class="widget__content">

            <div class="container-fluid preloadTrue">

                <?php

                    $blocks = [0,1,2,3];

                ?>

                <?php foreach ($blocks as $key => $value): ?>

                    <!--=====================================================
                        TODO: Preload
                    ======================================================-->

                    <div class="ph-item border-0 p-0 mt-0">

                        <div class="ph-col-6">

                            <div class="ph-picture" style="height:50px"></div>

                        </div>

                        <div class="ph-col-6">

                            <div class="ph-row">

                                <div class="ph-col-8"></div>
                                <div class="ph-col-4 empty"></div>

                                <div class="ph-col-12"></div>
                                <div class="ph-col-12"></div>

                                <div class="ph-col-6"></div>
                                <div class="ph-col-6 empty"></div>

                            </div>

                        </div>

                    </div>

                <?php endforeach ?>

            </div>

            <!--=====================================================
                TODO: Load
            ======================================================-->

            <div class="owl-slider preloadFalse" data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000" data-owl-gap="0" data-owl-nav="false" data-owl-dots="false" data-owl-item="1" data-owl-item-xs="1" data-owl-item-sm="1" data-owl-item-md="1" data-owl-item-lg="1" data-owl-duration="1000" data-owl-mousedrag="on">

                <?php foreach ($topSales as $key => $value): ?>

                    <div class="ps-product-group">

                        <?php foreach ($value as $index=> $item): ?>

                            <!--=====================================================
                                TODO: Product
                            ======================================================-->

                            <div class="ps-product--horizontal">

                                <div class="ps-product__thumbnail">
                                    <a href="<?php echo $path.$item->url_product ?>">
                                        <img src="<?php echo TemplateController::srcImg() ?>views/img/products/<?php echo $item->url_category ?>/<?php echo $item->picture_product ?>" alt="<?php echo $item->name_product ?>">
                                    </a>
                                </div>

                                <div class="ps-product__content">

                                    <a class="ps-product__title" href="<?php echo $path.$item->url_product ?>"><?php echo $item->name_product ?></a>

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

                        <?php endforeach ?>

                    </div>

                <?php endforeach ?>

            </div>

        </div>

    </aside>

</div>