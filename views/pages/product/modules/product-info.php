<div class="ps-product__info">

    <h1> <?php echo $item->name_product ?></h1>

    <div class="ps-product__meta">

    </div>

    <!--=====================================================
        TODO: El precio en oferta del producto
    ======================================================-->

    <?php if ($item->productoffer_product != null): ?>

    <h4 class="ps-product__price sale">

        <?php
                echo "S/.".TemplateController::offerPrice(

                    $item->price_product,
                    json_decode($item->productoffer_product,true)[1],
                    json_decode($item->productoffer_product,true)[0]

                );

            ?>

        <del> S/.<?php echo $item->price_product ?></del>

    </h4>

    <?php else: ?>

    <h4 class="ps-product__price"><?php echo "S/.".$item->price_product ?></h4>

    <?php endif ?>

    <div class="ps-product__desc">

        <p>

            <!--=====================================================
                TODO: Nombre de la marca
            ======================================================-->

            Marca:<a href="<?php echo $path.$item->url_brand ?>" class="mr-20"><strong>
                    <?php echo $item->name_brand ?></strong></a>

            <!--=====================================================
                TODO: Preguntar si el producto tiene Stock
            ======================================================-->

            <?php if ($item->stock_product == 0): ?>

            Status:<strong class="ps-tag--out-stock"> Agotado</strong>

            <?php else: ?>

            Status:<a href=""><strong class="ps-tag--in-stock"> En stock</strong></a>

            <?php endif ?>

        </p>

        <!--=====================================================
            TODO: Resumen del producto
        ======================================================-->

        <ul class="ps-list--dot">

            <?php

                $summary = json_decode($item->summary_product,true);

            ?>

            <?php foreach ($summary as $key => $value): ?>

            <li> <?php echo $value ?></li>

            <?php endforeach ?>

        </ul>

    </div>

    <!--=====================================================
        TODO: Validar ofertas del producto
    ======================================================-->

    <?php

    $today = date("Y-m-d");

    if ($item->productoffer_product != null && $item->stock_product != 0 && $today < date(json_decode($item->productoffer_product, true)[2])): ?>

    <div class="ps-product__countdown">

        <figure>

            <figcaption> ¡No te lo pierdas! Esta promoción caduca en</figcaption>

            <ul class="ps-countdown" data-time="<?php echo json_decode($item->productoffer_product, true)[2] ?>">

                <li><span class="days"></span>
                    <p>Días</p>
                </li>

                <li><span class="hours"></span>
                    <p>Horas</p>
                </li>

                <li><span class="minutes"></span>
                    <p>Minutos</p>
                </li>

                <li><span class="seconds"></span>
                    <p>Segundos</p>
                </li>

            </ul>

        </figure>

        <figure>

            <figcaption>Productos vendidos</figcaption>

            <div class="ps-product__progress-bar ps-progress" data-value="<?php echo $item->stock_product ?>">

                <div class="ps-progress__value"><span></span></div>

                <p><b><?php echo $item->stock_product ?>/100</b> Vendido</p>

            </div>

        </figure>

    </div>

    <?php endif ?>

    <div class="ps-product__shopping">

        <!--===================================================================
            TODO: Controles para modificar la cantidad de compra del producto
        ====================================================================-->

        <figure>

            <figcaption>Cantidad</figcaption>

            <div class="form-group--number quantity">

                <button class="up"
                    onclick="changeQuantity($('#quant0').val(), 'up', <?php echo $item->maxquantitysale_product ?>, 0)">
                    <i class="fa fa-plus"></i>
                </button>

                <button class="down"
                    onclick="changeQuantity($('#quant0').val(), 'down', <?php echo $item->stock_product ?>, 0)">
                    <i class="fa fa-minus"></i>
                </button>

                <input id="quant0" class="form-control" type="text" value="1" readonly>

            </div>

        </figure>

        <a class="ps-btn ps-btn--black"
            onclick="addShoppingCart('<?php echo $item->url_product ?>','<?php echo CurlController::api() ?>', '<?php echo $_SERVER["REQUEST_URI"] ?>', this)"
            detailsSC quantitySC>Añadir al carrito</a>

        <a class="ps-btn"
            onclick="addShoppingCart('<?php echo $item->url_product ?>','<?php echo CurlController::api() ?>', '<?php echo $path ?>checkout', this)"
            detailsSC quantitySC>Comprar ahora</a>
        <?php if(isset($_SESSION["user"])){
            $id = $_SESSION["user"]->id_customer;
            }else{
                $id = 0;
            }
        ?>
        <div class="ps-product__actions">
            <a class="btn"
                onclick="addWishlist('<?php echo $item->url_product ?>','<?php echo CurlController::api() ?>','<?php echo $id ?>','<?php echo $_SERVER["REQUEST_URI"] ?>', '<?php echo $path; ?>')">
                <i class="icon-heart"></i>
            </a>

        </div>

    </div>

    <div class="ps-product__specification">

        <p class="categories">

            <strong> Categorías:</strong>

            <a href="<?php echo $path.$item->url_category ?>"><?php echo $item->name_category ?></a>,
            <a href="<?php echo $path.$item->url_subcategory ?>"><?php echo $item->name_subcategory ?></a>,
            <a href="<?php echo $path.$item->title_list_product ?>"><?php echo $item->title_list_product ?></a>

        </p>

    </div>

    <div class="ps-product__sharing">

        <a class="facebook social-share" data-share="facebook" href="#">
            <i class="fab fa-facebook"></i>
        </a>

        <a class="twitter social-share" data-share="twitter" href="#">
            <i class="fab fa-twitter"></i>
        </a>

        <a class="linkedin"
            href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo $path.$item->url_product ?>"
            target="_blank">
            <i class="fab fa-linkedin"></i>
        </a>

    </div>

</div> <!-- End Product Info -->