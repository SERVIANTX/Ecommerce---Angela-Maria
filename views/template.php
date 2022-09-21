<?php

    ob_start();
    session_start();

    /*=============================================
        TODO: Traer el dominio principal
    =============================================*/

    $path = TemplateController::path();
    $srcimage = TemplateController::srcImg();

    /*=============================================
        TODO: Traer el total de productos
    =============================================*/

    $url = CurlController::api()."products?select=id_product";
    $method = "GET";
    $fields = array();
    $header = array();

    $dataProducts = CurlController::request($url, $method, $fields, $header);

    if($dataProducts->status == 200){

        $totalProducts = $dataProducts->total;

    }else{

        $totalProducts = 0;
    }

    /*=============================================
        TODO: Traer el total de Top Banners
    =============================================*/

    $url = CurlController::api()."top_banners?select=id_tbanner";
    $method = "GET";
    $fields = array();
    $header = array();

    $dataBanners = CurlController::request($url, $method, $fields, $header);

    if($dataBanners->status == 200){

        $totalBanners = $dataBanners->total;

    }else{

        $totalBanners = 0;
    }

    /*=================================================
        TODO: Traer el total de Banners Horizontales
    =================================================*/

    $url = CurlController::api()."horizontal_banners?select=id_hbanner";
    $method = "GET";
    $fields = array();
    $header = array();

    $dataBannersH = CurlController::request($url, $method, $fields, $header);

    if($dataBannersH->status == 200){

        $totalBannersH = $dataBannersH->total;

    }else{

        $totalBannersH = 0;
    }

    /*=================================================
        TODO: Traer el total de Banners default
    =================================================*/

    $url = CurlController::api()."default_banners?select=id_dbanner";
    $method = "GET";
    $fields = array();
    $header = array();

    $dataBannersD = CurlController::request($url, $method, $fields, $header);

    if($dataBannersD->status == 200){

        $totalBannersD = $dataBannersD->total;

    }else{

        $totalBannersD = 0;
    }

    /*=============================================
        TODO: Dirección
    =============================================*/

    $url = "extrasettings?select=id_extrasetting,value_extrasetting&linkTo=type_extrasetting&equalTo=direccion";
    $method = "GET";
    $fields = array();

    $response = CurlController::request2($url, $method, $fields);

    if($response->status == 200){

        $direccion = $response->results[0];

    }else{

        $direccion = "https://www.google.com/maps";
    }

    /*=============================================
        TODO: Correo
    =============================================*/

    $url = "extrasettings?select=id_extrasetting,value_extrasetting&linkTo=type_extrasetting&equalTo=email";
    $method = "GET";
    $fields = array();

    $response = CurlController::request2($url, $method, $fields);

    if($response->status == 200){

        $email = $response->results[0];

    }else{

        $email = "https://gmail.com/";
    }

    $emailAM = $email->value_extrasetting;

    /*=============================================
        TODO: Celular
    =============================================*/

    $url = "extrasettings?select=id_extrasetting,value_extrasetting&linkTo=type_extrasetting&equalTo=celular";
    $method = "GET";
    $fields = array();

    $response = CurlController::request2($url, $method, $fields);

    if($response->status == 200){

        $celular = $response->results[0];

    }else{

        $celular = "987654321";
    }

    /*=============================================
        TODO: facebook
    =============================================*/

    $url = "extrasettings?select=id_extrasetting,value_extrasetting&linkTo=type_extrasetting&equalTo=facebook";
    $method = "GET";
    $fields = array();

    $response = CurlController::request2($url, $method, $fields);

    if($response->status == 200){

        $facebook = $response->results[0];

    }else{

        $facebook = "https://www.facebook.com/";
    }

    /*=============================================
        TODO: instagram
    =============================================*/

    $url = "extrasettings?select=id_extrasetting,value_extrasetting&linkTo=type_extrasetting&equalTo=instagram";
    $method = "GET";
    $fields = array();

    $response = CurlController::request2($url, $method, $fields);

    if($response->status == 200){

        $instagram = $response->results[0];

    }else{

        $instagram = "https://www.instagram.com/";
    }

    /*=============================================
        TODO: whatsapp
    =============================================*/

    $url = "extrasettings?select=id_extrasetting,value_extrasetting&linkTo=type_extrasetting&equalTo=whatsapp";
    $method = "GET";
    $fields = array();

    $response = CurlController::request2($url, $method, $fields);

    if($response->status == 200){

        $whatsapp = $response->results[0];

    }else{

        $whatsapp = "https://web.whatsapp.com/";
    }

    /*=============================================
        TODO: Capturar las rutas de la URL
    =============================================*/

    $routesArray = explode("/", $_SERVER['REQUEST_URI']);

    /*=============================================
        TODO: Ajuste para Facebook
    =============================================*/

    if(!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])){

        if(!empty(array_filter($routesArray)[1])){

            $urlGet = explode("?", array_filter($routesArray)[1]);

            $urlParams = explode("&", $urlGet[0]);

        }


    }else{


        if(!empty(array_filter($routesArray)[1])){

            $urlGet = explode("?", array_filter($routesArray)[1]);

            $urlParams = explode("&", $urlGet[0]);

        }

    }

    if(!empty($urlParams[0])){

        /*=================================================
            TODO: Filtrar categorías con el parámetro URL
        =================================================*/

        $url = CurlController::api()."categories?linkTo=url_category&equalTo=".$urlParams[0]."&select=url_category";
        $method = "GET";
        $fields = array();
        $header = array();

        $urlCategories = CurlController::request($url, $method, $fields, $header);

        if($urlCategories->status == 404){

            /*=====================================================
                TODO: Filtrar subcategorías con el parámetro URL
            =====================================================*/

            $url = CurlController::api()."subcategories?linkTo=url_subcategory&equalTo=".$urlParams[0]."&select=url_subcategory";
            $method = "GET";
            $fields = array();
            $header = array();

            $urlSubCategories = CurlController::request($url, $method, $fields, $header);

            if($urlSubCategories->status == 404){

                /*=====================================================
                    TODO: Filtrar productos con el parámetro URL
                =====================================================*/

                $url = CurlController::api()."relations?rel=products,categories&type=product,category&linkTo=url_product&equalTo=".$urlParams[0]."&select=url_product,name_product,url_category,picture_product,summary_product";
                $method = "GET";
                $fields = array();
                $header = array();

                $urlProduct = CurlController::request($url, $method, $fields, $header);

                if($urlProduct->status == 404){

                    /*=====================================================
                        TODO: Validar si hay parámetros de paginación
                    =====================================================*/

                    if(isset($urlParams[1])){

                        if(is_numeric($urlParams[1])){


                            $startAt = ($urlParams[1]*6) - 6;

                        }else{

                            $startAt = null;

                        }

                    }else{

                        $startAt = 0;
                    }

                    /*=====================================================
                        TODO: Validar si hay parámetros de orden
                    =====================================================*/

                    if(isset($urlParams[2])){

                        if(is_string($urlParams[2])){

                            if($urlParams[2] == "new"){

                                $orderBy = "id_product";
                                $orderMode = "DESC";

                            }

                            else if($urlParams[2] == "latest"){

                                $orderBy = "id_product";
                                $orderMode = "ASC";

                            }

                            else if($urlParams[2] == "low"){

                                $orderBy = "price_product";
                                $orderMode = "ASC";

                            }

                            else if($urlParams[2] == "high"){

                                $orderBy = "price_product";
                                $orderMode = "DESC";

                            }else{

                                $orderBy = "id_product";
                                $orderMode = "DESC";

                            }

                        }else{

                            $orderBy = "id_product";
                            $orderMode = "DESC";

                        }

                    }else{

                        $orderBy = "id_product";
                        $orderMode = "DESC";
                    }


                    $linkTo = ["name_product","title_list_product","summary_product","url_brand","name_brand"];
                    $select = "url_product,url_category,picture_product,name_product,stock_product,productoffer_product,price_product,views_category,name_category,id_category,views_subcategory,name_subcategory,id_subcategory,summary_product,url_brand,name_brand,picture_brand";

                    /* $select = "url_store,name_store,reviews_product,"; */

                    foreach ($linkTo  as $key => $value) {

                        /*====================================================================
                            TODO: Filtrar tabla producto con el parámetro URL de búsqueda
                        ====================================================================*/

                        /* $url = CurlController::api()."relations?rel=products,categories,subcategories,brands&type=product,category,subcategory,brand&linkTo=".$value.",status_product::api&search=".$urlParams[0].",1&orderBy=".$orderBy."&orderMode=".$orderMode."&startAt=".$startAt."&endAt=12&select=".$select; */

                        $url = CurlController::api()."relations?rel=products,categories,subcategories,brands&type=product,category,subcategory,brand&linkTo=".$value.",status_product&search=".$urlParams[0].",1&orderBy=".$orderBy."&orderMode=".$orderMode."&startAt=".$startAt."&endAt=12&select=".$select;

                        $method = "GET";
                        $fields = array();
                        $header = array();

                        $urlSearch = CurlController::request($url, $method, $fields, $header);

                        if($urlSearch->status != 404){

                            $select = "id_product";

                            /* $url = CurlController::api()."relations?rel=products,categories,subcategories,brands&type=product,category,subcategory,brand&linkTo=".$value.",status_product::api&search=".$urlParams[0].",1&select=".$select; */

                            $url = CurlController::api()."relations?rel=products,categories,subcategories,brands&type=product,category,subcategory,brand&linkTo=".$value.",status_product&search=".$urlParams[0].",1&select=".$select;

                            $totalSearch = CurlController::request($url, $method, $fields, $header)->total;

                            break;

                        }

                    }

                }

            }

        }


    }


?>


<!DOCTYPE html>
<html lang="es">
<head>

	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <script src="https://www.paypal.com/sdk/js?client-id=AcU57Jnlddhvc815cZ52_xVUTkA7Ok4Vl6Y705XaoHh7WLYgChTjFPbVpFcm4-vUGlr9Hq0FH_X-Zcr6&currency=USD"></script>
    <!--=====================================================
        TODO: METADATOS
    ======================================================-->

	<?php

		if (!empty($urlParams[0])){

			if(isset($urlProduct->status) && $urlProduct->status == 200){

				$name = $urlProduct->results[0]->name_product;
				$title = "Angela Maria | ".$urlProduct->results[0]->name_product;
				$description = "";

				foreach (json_decode($urlProduct->results[0]->summary_product,true) as $key => $value) {

					$description .= $value.", ";
				}

				$description = substr($description, 0, -2);

				$keywords = "";

                $keywords = substr($keywords, 0, -2);

                $image = $path.$srcimage."views/img/products/".$urlProduct->results[0]->url_category."/".$urlProduct->results[0]->picture_product;

				$url = $path.$urlProduct->results[0]->url_product;

			}else{

				$name = "Angela Maria";
				$title = "Angela Maria | Home";
				$description = "Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Cras mattis consectetur purus sit amet fermentum.";
				$keywords = "Angela Maria, Abarrotes, Desayuno, Lacteos, Limpieza, Higiene Salud Y Belleza, Aguas Y Bebidas, Cervezas Vinos Y Licores";
				$image = $path."views/img/bg/about-us.jpg";
				$url = $path;

			}

		}else{

			$name = "Angela Maria";
			$title = "Angela Maria | Home";
			$description = "Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Cras mattis consectetur purus sit amet fermentum.";
			$keywords = "Angela Maria, Abarrotes, Desayuno, Lacteos, Limpieza, Higiene Salud Y Belleza, Aguas Y Bebidas, Cervezas Vinos Y Licores";
			$image = $path."views/img/bg/about-us.jpg";
			$url = $path;

		}

	?>

	<title><?php echo $title ?></title>

	<meta name="description" content="<?php echo $description ?>">
	<meta name="keywords" content="<?php echo $keywords ?>">

    <!--=====================================================
        TODO: Marcado OPEN GRAPH FACEBOOK
    ======================================================-->

	<meta property="og:site_name" content="<?php echo $name ?>">
	<meta property="og:title" content="<?php echo $title ?>">
	<meta property="og:description" content="<?php echo $description ?>">
	<meta property="og:type" content="Type">
	<meta property="og:image" content="<?php echo $image?>">
	<meta property="og:url" content="<?php echo $url ?>">

    <!--=====================================================
        TODO: Marcado TWITTER
    ======================================================-->

	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:site" content="@angelamaria">
	<meta name="twitter:creator" content="@angelamaria">
	<meta name="twitter:title" content="<?php echo $title ?>">
	<meta name="twitter:description" content="<?php echo $description ?>">
	<meta name="twitter:image" content="<?php echo $image?>">
	<meta name="twitter:image:width" content="800">
	<meta name="twitter:image:height" content="418">
	<meta name="twitter:image:alt" content="<?php echo $description ?>">

    <!--=====================================================
        TODO: Marcado GOOGLE
    ======================================================-->

	<meta itemprop="name" content="<?php echo $title ?>">
	<meta itemprop="url" content="<?php echo $url ?>">
	<meta itemprop="description" content="<?php echo $description ?>">
	<meta itemprop="image" content="<?php echo $image?>">


    <base href="views/">

    <link rel="icon" href="assets/img/template/angelam.ico">

    <!--=====================================================
        TODO: CSS
    ======================================================-->

	<!-- google font -->
	<link href="https://fonts.googleapis.com/css?family=Work+Sans:300,400,500,600,700&display=swap" rel="stylesheet">

	<!-- font awesome -->
	<link rel="stylesheet" href="assets/css/plugins/fontawesome.min.css">

	<!-- linear icons -->
	<link rel="stylesheet" href="assets/css/plugins/linearIcons.css">

	<!-- Bootstrap 4 -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

	<!-- Owl Carousel -->
	<link rel="stylesheet" href="assets/css/plugins/owl.carousel.css">

	<!-- Slick -->
	<link rel="stylesheet" href="assets/css/plugins/slick.css">

	<!-- Light Gallery -->
	<link rel="stylesheet" href="assets/css/plugins/lightgallery.min.css">

	<!-- Font Awesome Start -->
	<link rel="stylesheet" href="assets/css/plugins/fontawesome-stars.css">

	<!-- jquery Ui -->
	<link rel="stylesheet" href="assets/css/plugins/jquery-ui.min.css">

	<!-- Select 2 -->
	<link rel="stylesheet" href="assets/css/plugins/select2.min.css">

	<!-- Scroll Up -->
	<link rel="stylesheet" href="assets/css/plugins/scrollUp.css">

    <!-- DataTable -->
    <link rel="stylesheet" href="assets/css/plugins/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/css/plugins/responsive.bootstrap.datatable.min.css">

    <!-- Placeholder-loading -->
    <!-- https://github.com/zalog/placeholder-loading -->
    <!-- https://www.youtube.com/watch?v=JU_sklV_diY -->
    <link rel="stylesheet" href="https://unpkg.com/placeholder-loading@0.2.6/dist/css/placeholder-loading.min.css">

    <!-- Notie Alert -->
    <link rel="stylesheet" href="assets/css/plugins/notie.min.css">

    <!-- include summernote css/js -->
	<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

	<!-- tags Input -->
	<link rel="stylesheet" href="assets/css/plugins/tagsinput.css">

	<!-- Dropzone -->
	<link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css">

	<!-- estilo principal -->
	<link rel="stylesheet" href="assets/css/style.css">

    <!-- estilo cookiee -->
	<link rel="stylesheet" href="assets/css/stylecookie.css">

	<!-- Market Place 4 -->
	<link rel="stylesheet" href="assets/css/market-place-4.css">

    <link rel="stylesheet" href="assets/custom/style.css">

    <!--=====================================================
        TODO: PLUGINS JS
    ======================================================-->

	<!-- jQuery library -->
	<script src="assets/js/plugins/jquery-1.12.4.min.js"></script>

	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

	<!-- Owl Carousel -->
	<script src="assets/js/plugins/owl.carousel.min.js"></script>

	<!-- Images Loaded -->
	<script src="assets/js/plugins/imagesloaded.pkgd.min.js"></script>

	<!-- Masonry -->
	<script src="assets/js/plugins/masonry.pkgd.min.js"></script>

	<!-- Isotope -->
	<script src="assets/js/plugins/isotope.pkgd.min.js"></script>

	<!-- jQuery Match Height -->
	<script src="assets/js/plugins/jquery.matchHeight-min.js"></script>

	<!-- Slick -->
	<script src="assets/js/plugins/slick.min.js"></script>

	<!-- jQuery Barrating -->
	<script src="assets/js/plugins/jquery.barrating.min.js"></script>

	<!-- Slick Animation -->
	<script src="assets/js/plugins/slick-animation.min.js"></script>

	<!-- Light Gallery -->
	<script src="assets/js/plugins/lightgallery-all.min.js"></script>
    <script src="assets/js/plugins/lg-thumbnail.min.js"></script>
    <script src="assets/js/plugins/lg-fullscreen.min.js"></script>
    <script src="assets/js/plugins/lg-pager.min.js"></script>

	<!-- jQuery UI -->
	<script src="assets/js/plugins/jquery-ui.min.js"></script>

	<!-- Sticky Sidebar -->
	<script src="assets/js/plugins/sticky-sidebar.min.js"></script>

	<!-- Slim Scroll -->
	<script src="assets/js/plugins/jquery.slimscroll.min.js"></script>

	<!-- Select 2 -->
	<script src="assets/js/plugins/select2.full.min.js"></script>

	<!-- Scroll Up -->
	<script src="assets/js/plugins/scrollUP.js"></script>

    <!-- DataTable -->
    <script src="assets/js/plugins/jquery.dataTables.min.js"></script>
    <script src="assets/js/plugins/dataTables.bootstrap4.min.js"></script>
    <script src="assets/js/plugins/dataTables.responsive.min.js"></script>

    <!-- Chart -->
    <script src="assets/js/plugins/Chart.min.js"></script>

	<!-- pagination -->
	<!-- http://josecebe.github.io/twbs-pagination/ -->
    <script src="assets/js/plugins/twbs-pagination.min.js"></script>

    <!-- md5 -->
    <script src="assets/js/plugins/md5.min.js"></script>

    <!-- Notie Alert -->
    <!-- https://jaredreich.com/notie/ -->
    <!-- https://github.com/jaredreich/notie -->
    <script src="https://unpkg.com/notie@4.3.1/dist/notie.min.js"></script>

    <!-- Sweet Alert -->
    <!-- https://sweetalert2.github.io/ -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <!-- summernote -->
    <!-- https://summernote.org/getting-started/#run-summernote -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

    <!-- Tags Input -->
    <!-- https://www.jqueryscript.net/form/Bootstrap-4-Tag-Input-Plugin-jQuery.html -->
    <script src="assets/js/plugins/tagsinput.js"></script>

    <!-- Dropzone -->
    <!-- https://www.dropzonejs.com/ -->
    <script src="https://rawgit.com/enyo/dropzone/master/dist/dropzone.js"></script>

    <!-- Shape Share -->
    <!-- https://www.jqueryscript.net/social-media/Social-Share-Plugin-jQuery-Open-Graph-Shape-Share.html -->
    <script src="assets/js/plugins/shape.share.js"></script>

    <script src="assets/js/head.js"></script>

</head>

<body>

    <!--=====================================================
        TODO: Traductor Yandex
    ======================================================-->

	<div id="ytWidget" style="display:none"></div>

	<script src="https://translate.yandex.net/website-widget/v1/widget.js?widgetId=ytWidget&pageLang=en&widgetTheme=light&autoMode=false" type="text/javascript"></script>

    <!--=====================================================
        TODO: Header Promotion
    ======================================================-->

	<?php include "modules/top-banner.php" ?>

    <!--=====================================================
        TODO: Header
    ======================================================-->

    <?php include "modules/header.php" ?>

    <!--=====================================================
        TODO: Header Mobile
    ======================================================-->

    <?php include "modules/header-mobile.php" ?>

    <!--=====================================================
        TODO: Pages
    ======================================================-->

	<?php

        if(!empty($urlParams[0])){

            if( $urlParams[0] == "account" ||
                $urlParams[0] == "shopping-cart" ||
                $urlParams[0] == "checkout" ||
                $urlParams[0] == "terminos-condiciones" ||
                $urlParams[0] == "politicas-de-privacidad" ||
                $urlParams[0] == "condiciones-de-promociones" ||
                $urlParams[0] == "payment" ||
                $urlParams[0] == "aviso-cookies" ||
                $urlParams[0] == "data_confirmation"){
                include "pages/".$urlParams[0]."/".$urlParams[0].".php";

            }else if($urlParams[0] == "index.php" ){

                echo '<script>

                        window.location = "'.$path.'";

                    </script>';

            }else if($urlCategories->status == 200 || $urlSubCategories->status == 200 ){

                include "pages/products/products.php";

            }else if($urlProduct->status == 200){

                include "pages/product/product.php";

            }else if($urlSearch->status == 200){

            include "pages/search/search.php";

            }else{

                include "pages/404/404.php";

            }

        }else{

            include "pages/home/home.php";

        }


	?>


    <!--=====================================================
        TODO: Newletter
    ======================================================-->

    <?php include "modules/newletter.php" ?>

    <!--=====================================================
        TODO: Cookie
    ======================================================-->

    <div class="aviso-cookies" id="aviso-cookies">
		<img class="galleta" src="assets/img/cookie.svg" alt="Galleta">
		<h3 class="titulo">Cookies</h3>
		<p class="parrafo">Utilizamos cookies propias y de terceros para mejorar nuestros servicios.</p>
		<button class="boton" id="btn-aceptar-cookies">De acuerdo</button>
		<a class="enlace" href="/aviso-cookies">Aviso de Cookies</a>
	</div>
	<div class="fondo-aviso-cookies" id="fondo-aviso-cookies"></div>

    <!--=====================================================
        TODO: Footer
    ======================================================-->

    <?php include "modules/footer.php" ?>

    <!--=====================================================
        TODO: JS PERSONALIZADO
    ======================================================-->

	<script src="assets/js/main.js"></script>

    <script src="assets/js/cookie.js"></script>

</body>
</html>