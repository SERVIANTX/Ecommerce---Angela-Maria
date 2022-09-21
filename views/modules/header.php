<?php

    /*=============================================
        TODO: Traer él listado de categorías
    =============================================*/

    $url = CurlController::api()."categories?select=id_category,url_category,name_category,icon_category,title_list_category";
    $method = "GET";
    $fields = array();
    $header = array();

    $menuCategories = CurlController::request($url, $method, $fields, $header)->results;

    /*========================================================
        TODO: Quitar categoría que aún no tenga producto
    ========================================================*/

    foreach ($menuCategories as $key => $value) {

        $url = CurlController::api()."products?select=id_product&linkTo=id_category_product&equalTo=".$value->id_category;
        $products = CurlController::request($url, $method, $fields, $header);

        if($products->status == 404){

            unset($menuCategories[$key]);

        }

    }

    /*=============================================
        TODO: Traer lista de deseos
    =============================================*/

    $wishlist = array();

    if(isset($_SESSION["user"])){

        $url = CurlController::api()."customers?linkTo=id_customer&equalTo=".$_SESSION["user"]->id_customer."&select=wishlist_customer";
        $response = CurlController::request($url, $method, $fields, $header)->results[0];

        if(!empty($response->wishlist_customer)){

            $wishlist = json_decode($response->wishlist_customer, true);

        }

    }

?>

<header class="header header--standard header--market-place-4" data-sticky="true">

    <!--=====================================================
        TODO: Header TOP
    ======================================================-->

    <div class="header__top">

        <div class="container">

            <!--=====================================================
                TODO: Social
            ======================================================-->

            <div class="header__left">
                <ul class="d-flex justify-content-center">
                    <li><a href="<?php echo $facebook->value_extrasetting ?>" target="_blank"><i class="fab fa-facebook-f mr-4"></i></a></li>
                    <li><a href="<?php echo $instagram->value_extrasetting ?>" target="_blank"><i class="fab fa-instagram mr-4"></i></a></li>
                    <li><a href="<?php echo $whatsapp->value_extrasetting ?>" target="_blank"><i class="fab fa-whatsapp mr-4"></i></a></li>
                </ul>
            </div>

            <!--=====================================================
                TODO: Contacto & lenguaje
            ======================================================-->

            <div class="header__right">
                <ul class="header__top-links">
                    <li><i class="icon-telephone"></i> Línea directa: <a href="tel:<?php echo $celular->value_extrasetting ?>"><strong><?php echo $celular->value_extrasetting ?></strong></a></li>
                </ul>
            </div>

        </div>

    </div>

    <!--=====================================================
        TODO: Header Content
    ======================================================-->

    <div class="header__content">

        <div class="container">

            <div class="header__content-left">

                <!--=====================================================
                    TODO: Logo
                ======================================================-->

                <a class="ps-logo" href="/">
                    <img src="assets/img/template/log2.png" alt="logo">
                </a>

                <!--=====================================================
                    TODO: Menú
                ======================================================-->

                <div class="menu--product-categories">

                    <div class="menu__toggle">
                        <i class="icon-menu"></i>
                        <span> Compra por categorías</span>
                    </div>

                    <div class="menu__content">

                        <ul class="menu--dropdown">

                            <?php foreach ($menuCategories as $key => $value): ?>

                                <li class="menu-item-has-children has-mega-menu">

                                    <a href="<?php echo $path.$value->url_category ?>">
                                        <i class="<?php echo $value->icon_category ?>"></i>
                                        <?php echo $value->name_category ?>
                                    </a>

                                    <div class="mega-menu">

                                        <!--=====================================================
                                            TODO: Traer el listado de títulos
                                        ======================================================-->

                                        <?php

                                            $title_list = json_decode($value->title_list_category);

                                        ?>

                                        <?php foreach ($title_list as $key => $value): ?>

                                        <div class="mega-menu__column">

                                            <h4><?php echo $value ?><span class="sub-toggle"></span></h4>

                                            <ul class="mega-menu__list">

                                                <!--=====================================================
                                                    TODO: Traer las subcategorías
                                                ======================================================-->

                                                <?php

                                                    $url = CurlController::api()."subcategories?linkTo=title_list_subcategory&equalTo=".rawurlencode($value)."&select=url_subcategory,name_subcategory";
                                                    $method = "GET";
                                                    $fields = array();
                                                    $header = array();

                                                    $menuSubcategories = CurlController::request($url, $method, $fields, $header)->results;

                                                ?>

                                                <?php foreach ($menuSubcategories as $key => $value): ?>

                                                    <li>
                                                        <a href="<?php echo $path.$value->url_subcategory ?>"><?php echo $value->name_subcategory ?></a>
                                                    </li>

                                                <?php endforeach ?>

                                            </ul>
                                        </div>

                                        <?php endforeach ?>

                                    </div>
                                </li>

                            <?php endforeach ?>

                        </ul>

                    </div>

                </div>

            </div>

            <!--=====================================================
                TODO: Search
            ======================================================-->

            <div class="header__content-center">

                <form class="ps-form--quick-search">

                    <input class="form-control inputSearch" type="text" placeholder="Estoy buscando...">

                    <button type="button" class="btnSearch" path="<?php echo $path ?>"><i class="fas fa-search"></i></button>

                </form>

            </div>

            <div class="header__content-right">

                <div class="header__actions">

                    <!--=====================================================
                        TODO: Wishlist
                    ======================================================-->

                    <a class="header__extra" href="<?php echo $path ?>account&wishlist">
                        <i class="icon-heart"></i>
                        <span>
                            <i class="totalWishlist"><?php echo count($wishlist) ?></i>
                        </span>
                    </a>

                    <!--=====================================================
                        TODO: Cart
                    ======================================================-->

                    <?php

                        $totalPriceSC = 0;

                        if(isset($_COOKIE["listSC"])){

                            $shoppingCart = json_decode($_COOKIE["listSC"], true);

                            $totalSC = count($shoppingCart);

                        }else{

                            $totalSC = 0;
                        }

                    ?>

                    <div class="ps-cart--mini">

                        <a class="header__extra">
                            <i class="icon-bag2"></i><span><i><?php echo $totalSC ?></i></span>
                        </a>

                        <?php if ($totalSC > 0): ?>

                        <div class="ps-cart__content">

                            <div class="ps-cart__items">

                                <?php foreach ($shoppingCart as $key => $value): ?>

                                    <?php

                                        /*=====================================================
                                            TODO: Cart
                                        ======================================================*/

                                        $select = "url_product,url_category,name_product,picture_product,price_product,productoffer_product,name_brand";

                                        $url = CurlController::api()."relations?rel=products,categories,brands&type=product,category,brand&linkTo=url_product&equalTo=".$value["product"]."&select=".$select;
                                        $method = "GET";
                                        $fields = array();
                                        $header = array();

                                        $item = CurlController::request($url, $method, $fields, $header)->results[0];

                                    ?>

                                <div class="ps-product--cart-mobile">

                                    <div class="ps-product__thumbnail">
                                        <a href="<?php echo $path.$item->url_product ?>">
                                            <img src="<?php echo TemplateController::srcImg() ?>views/img/products/<?php echo $item->url_category ?>/<?php echo $item->picture_product ?>" alt="<?php echo $item->name_product ?>">
                                        </a>
                                    </div>

                                    <div class="ps-product__content">

                                        <!-- Eliminar el producto -->
                                        <a class="ps-product__remove btn"
                                            onclick="removeSC('<?php echo $item->url_product ?>','<?php echo $_SERVER["REQUEST_URI"] ?>')">
                                            <i class="icon-cross"></i>
                                        </a>

                                        <!-- Nombre del producto -->
                                        <a href="<?php echo $path.$item->url_product ?>">
                                            <?php echo $item->name_product ?>
                                        </a>

                                        <!-- Marca del producto -->
                                        <p class="mb-0"><strong>Marca: </strong><?php echo $item->name_brand ?></p>

                                        <!-- Detalles del producto -->
                                        <div class="small text-secondary">

                                            <?php

                                                        /* if($value["details"] != ""){

                                                            foreach (json_decode($value["details"],true)  as $key => $detail) {

                                                                foreach (array_keys($detail) as $key => $list) {

                                                                    echo '<div>'.$list.':'.array_values($detail)[$key].'</div>';
                                                                }

                                                            }

                                                        } */

                                                    ?>

                                        </div>

                                        <!-- La cantidad del producto -->
                                        <p class="mb-0">

                                            <!-- La cantidad del producto -->
                                            <p class="float-left">

                                                <strong>Cantidad:</strong> <?php echo $value["quantity"] ?>

                                            </p>

                                            <!-- Precio del producto -->

                                            <?php if ($item->productoffer_product != null): ?>

                                            <h4 class="ps-product__price sale float-right text-danger mt-5">

                                                <?php

                                                            $price = TemplateController::offerPrice(

                                                                    $item->price_product,
                                                                    json_decode($item->productoffer_product,true)[1],
                                                                    json_decode($item->productoffer_product,true)[0]

                                                                );

                                                                echo "S/.".$price;

                                                                $totalPriceSC += ($price*$value["quantity"]);

                                                            ?>

                                                <del class="text-muted"> S/.<?php echo $item->price_product ?></del>

                                            </h4>

                                            <?php else: ?>

                                            <h4 class="ps-product__price float-right text-secondary mt-5">S/.
                                                <?php echo $item->price_product ?>
                                                <?php  $totalPriceSC += ($item->price_product*$value["quantity"]); ?>

                                            </h4>

                                            <?php endif ?>

                                        </p>


                                    </div>

                                </div>

                                <?php endforeach ?>


                            </div>

                            <div class="ps-cart__footer">

                                <h3>Total:<strong>S/.<?php echo $totalPriceSC ?></strong></h3>
                                <figure>
                                    <a class="ps-btn" href="<?php echo $path ?>shopping-cart">Ver Carrito</a>
                                    <a class="ps-btn" href="<?php echo $path ?>data_confirmation">Checkout</a>
                                </figure>

                            </div>

                        </div>

                        <?php endif ?>

                    </div>

                    <!--=====================================================
                        TODO: Cuentas de usuario
                    ======================================================-->

                    <?php if (isset($_SESSION["user"])): ?>

                        <div class="ps-block--user-header">
                            <div class="ps-block__left">

                                <?php if ($_SESSION["user"]->method_customer == "direct"): ?>

                                    <?php if ($_SESSION["user"]->picture_customer == ""): ?>

                                        <img class="img-fluid rounded-circle ml-auto" style="width:50%" src="<?php echo TemplateController::srcImg() ?>views/img/customers/default/default.png">

                                    <?php else: ?>

                                        <img class="img-fluid rounded-circle ml-auto" style="width:50%" src="<?php echo TemplateController::srcImg() ?>views/img/customers/<?php echo $_SESSION["user"]->id_customer ?>/<?php echo $_SESSION["user"]->picture_customer ?>">

                                <?php endif ?>

                                <?php else: ?>

                                    <?php if (explode("/", $_SESSION["user"]->picture_customer)[0] == "https:"): ?>

                                        <img class="img-fluid rounded-circle ml-auto" style="width:50%" src="<?php echo $_SESSION["user"]->picture_customer ?>">

                                    <?php else: ?>

                                        <img class="img-fluid rounded-circle ml-auto" style="width:50%" ssrc="<?php echo TemplateController::srcImg() ?>views/img/customers/<?php echo $_SESSION["user"]->id_customer ?>/<?php echo $_SESSION["user"]->picture_customer ?>">

                                <?php endif ?>


                                <?php endif ?>

                            </div>
                            <div class="ps-block__right">
                                <a href="<?php echo $path ?>account&wishlist">Mi Cuenta</a>
                            </div>
                        </div>

                    <?php else: ?>

                    <!--=====================================================
                        TODO: Login y Registro
                    ======================================================-->

                    <div class="ps-block--user-header">
                        <div class="ps-block__left">
                            <i class="icon-user"></i>
                        </div>
                        <div class="ps-block__right">
                            <a href="<?php echo $path ?>account&login">Iniciar Sesión</a>
                            <a href="<?php echo $path ?>account&enrollment">Registrarse</a>
                        </div>
                    </div>

                    <?php endif ?>

                </div><!-- End Header Actions-->

            </div><!-- End Header Content Right-->

        </div><!-- End Container-->

    </div><!-- End Header Content-->

</header>