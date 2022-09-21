<!--=====================================================
    TODO: Preload
======================================================-->

<div class="d-flex justify-content-center preloadTrue">

    <div class="spinner-border text-muted my-5"></div>

</div>

<!--=====================================================
    TODO: Load
======================================================-->

<div id="showcase" class="ps-shopping ps-tab-root preloadFalse">

    <!--=====================================================
        TODO: Shoping Header
    ======================================================-->

    <div class="ps-shopping__header">

        <p><strong> <?php echo $totalProducts ?></strong> Productos encontrados</p>

        <div class="ps-shopping__actions">

            <select class="select2" data-placeholder="Sort Items" onchange="sortProduct(event)">

                <?php if (isset($urlParams[2])): ?>

                <?php if ($urlParams[2] == "new"): ?>

                <option value="<?php echo $_SERVER["REQUEST_URI"] ?>+new">Ordenar por nuevo</option>
                <option value="<?php echo $_SERVER["REQUEST_URI"] ?>+latest">Ordenar por más reciente</option>
                <option value="<?php echo $_SERVER["REQUEST_URI"] ?>+low">Ordenar por precio: de menor a mayor</option>
                <option value="<?php echo $_SERVER["REQUEST_URI"] ?>+high">Ordenar por precio: de mayor a menor</option>

                <?php endif ?>

                <?php if ($urlParams[2] == "latest"): ?>

                <option value="<?php echo $_SERVER["REQUEST_URI"] ?>+latest">Ordenar por más reciente</option>
                <option value="<?php echo $_SERVER["REQUEST_URI"] ?>+low">Ordenar por precio: de menor a mayor</option>
                <option value="<?php echo $_SERVER["REQUEST_URI"] ?>+high">Ordenar por precio: de mayor a menor</option>
                <option value="<?php echo $_SERVER["REQUEST_URI"] ?>+new">Ordenar por nuevo</option>

                <?php endif ?>

                <?php if ($urlParams[2] == "low"): ?>

                <option value="<?php echo $_SERVER["REQUEST_URI"] ?>+low">Ordenar por precio: de menor a mayor</option>
                <option value="<?php echo $_SERVER["REQUEST_URI"] ?>+high">Ordenar por precio: de mayor a menor</option>
                <option value="<?php echo $_SERVER["REQUEST_URI"] ?>+new">Ordenar por nuevo</option>
                <option value="<?php echo $_SERVER["REQUEST_URI"] ?>+latest">Ordenar por más reciente</option>


                <?php endif ?>

                <?php if ($urlParams[2] == "high"): ?>

                <option value="<?php echo $_SERVER["REQUEST_URI"] ?>+high">Ordenar por precio: de mayor a menor</option>
                <option value="<?php echo $_SERVER["REQUEST_URI"] ?>+low">Ordenar por precio: de menor a mayor</option>
                <option value="<?php echo $_SERVER["REQUEST_URI"] ?>+new">Ordenar por nuevo</option>
                <option value="<?php echo $_SERVER["REQUEST_URI"] ?>+latest">Ordenar por más reciente</option>

                <?php endif ?>

                <?php else: ?>

                <option value="<?php echo $_SERVER["REQUEST_URI"] ?>+new">Ordenar por nuevo</option>
                <option value="<?php echo $_SERVER["REQUEST_URI"] ?>+latest">Ordenar por más reciente</option>
                <option value="<?php echo $_SERVER["REQUEST_URI"] ?>+low">Ordenar por precio: de menor a mayor</option>
                <option value="<?php echo $_SERVER["REQUEST_URI"] ?>+high">Ordenar por precio: de mayor a menor</option>

                <?php endif ?>

            </select>

            <div class="ps-shopping__view">

                <p>Ver</p>

                <ul class="ps-tab-list">

                    <?php if (isset($_COOKIE["tab"])): ?>

                    <?php if ($_COOKIE["tab"] == "grid"): ?>

                    <li class="active" type="grid">
                        <a href="#tab-1">
                            <i class="icon-grid"></i>
                        </a>
                    </li>

                    <li type="list">
                        <a href="#tab-2">
                            <i class="icon-list4"></i>
                        </a>
                    </li>

                    <?php else: ?>

                    <li type="grid">
                        <a href="#tab-1">
                            <i class="icon-grid"></i>
                        </a>
                    </li>

                    <li class="active" type="list">
                        <a href="#tab-2">
                            <i class="icon-list4"></i>
                        </a>
                    </li>

                    <?php endif ?>

                    <?php else: ?>

                    <li class="active" type="grid">
                        <a href="#tab-1">
                            <i class="icon-grid"></i>
                        </a>
                    </li>

                    <li type="list">
                        <a href="#tab-2">
                            <i class="icon-list4"></i>
                        </a>
                    </li>

                    <?php endif ?>



                </ul>

            </div>

        </div>

    </div>

    <!--=====================================================
        TODO: Shoping Body
    ======================================================-->

    <div class="ps-tabs">

        <!--=====================================================
            TODO: Grid View
        ======================================================-->

        <?php if (isset($_COOKIE["tab"])): ?>

        <?php if ($_COOKIE["tab"] == "grid"): ?>

        <div class="ps-tab active" id="tab-1">

            <?php else: ?>

            <div class="ps-tab" id="tab-1">

                <?php endif ?>

                <?php else: ?>

                <div class="ps-tab active" id="tab-1">

                    <?php endif ?>

                    <div class="ps-shopping-product">

                        <div class="row">

                            <?php foreach ($showcaseProducts as $key => $item): ?>

                            <!--=====================================================
                                TODO: Product
                            ======================================================-->

                            <div class="col-lg-2 col-md-4 col-6">

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
                                                    detailsSC quantitySC data-toggle="tooltip" data-placement="top"
                                                    title="Añadir al carrito">
                                                    <i class="icon-bag2"></i>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="<?php echo $path.$item->url_product ?>" data-toggle="tooltip"
                                                    data-placement="top" title="Ver producto">
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
                                            TODO: nombre de la Marca
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

                            </div><!-- End Product -->

                            <?php endforeach ?>

                        </div>

                    </div>

                    <div class="ps-pagination">

                        <?php

                            if(isset($urlParams[1])){

                                $currentPage = $urlParams[1];

                            }else{

                                $currentPage = 1;

                            }

                        ?>

                        <ul class="pagination" data-total-pages="<?php echo ceil($totalProducts/6) ?>"
                            data-current-page="<?php echo $currentPage ?>"
                            data-url-page="<?php echo $_SERVER["REQUEST_URI"] ?>">

                        </ul>

                    </div>

                </div><!-- End Grid View-->

                <!--=====================================================
                    TODO: List View
                ======================================================-->

                <?php if (isset($_COOKIE["tab"])): ?>

                <?php if ($_COOKIE["tab"] == "list"): ?>

                <div class="ps-tab active" id="tab-2">

                    <?php else: ?>

                    <div class="ps-tab" id="tab-2">

                        <?php endif ?>

                        <?php else: ?>

                        <div class="ps-tab" id="tab-2">

                            <?php endif ?>

                            <div class="ps-shopping-product">

                                <?php foreach ($showcaseProducts as $key => $item): ?>

                                <!--=====================================================
                                    TODO: Product
                                ======================================================-->

                                <div class="ps-product ps-product--wide">

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
                                            TODO: El nombre de la tienda
                                        ======================================================-->

                                            <p class="ps-product__vendor">Marca:
                                                <a href="<?php echo $path.$item->url_brand ?>"><?php echo $item->name_brand ?></a>
                                            </p>

                                        <!--=====================================================
                                            TODO: Las reseñas del producto
                                        ======================================================-->

                                            

                                        <!--=====================================================
                                            TODO: El resumen del producto
                                        ======================================================-->

                                            <ul class="ps-product__desc">

                                                <?php

                                                    $summary = json_decode($item->summary_product,true);

                                                ?>

                                                <?php foreach ($summary as $key => $value): ?>

                                                <li> <?php echo $value ?></li>

                                                <?php endforeach ?>

                                            </ul>

                                        </div>

                                        <div class="ps-product__shopping">

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

                                            <a class="ps-btn"
                                                onclick="addShoppingCart('<?php echo $item->url_product ?>','<?php echo CurlController::api() ?>', '<?php echo $_SERVER["REQUEST_URI"] ?>', this)"
                                                detailsSC quantitySC>Añadir al carrito</a>

                                            <ul class="ps-product__actions">
                                                <li><a href="<?php echo $path.$item->url_product ?>"><i
                                                            class="icon-eye"></i>Ver</a></li>
                                                <li><a class="btn"
                                                        onclick="addWishlist('<?php echo $item->url_product ?>','<?php echo CurlController::api() ?>','<?php echo $id ?>','<?php echo $_SERVER["REQUEST_URI"] ?>', '<?php echo $path; ?>')"><i class="icon-heart"></i> Lista de deseos</a></li>
                                            </ul>

                                        </div>

                                    </div>

                                </div> <!-- End Product -->

                                <?php endforeach ?>

                            </div>

                            <div class="ps-pagination">

                                <ul class="pagination" data-total-pages="<?php echo ceil($totalProducts/6) ?>"
                                    data-current-page="<?php echo $currentPage ?>"
                                    data-url-page="<?php echo $_SERVER["REQUEST_URI"] ?>">

                                </ul>

                            </div>

                        </div>

                    </div>

                </div>