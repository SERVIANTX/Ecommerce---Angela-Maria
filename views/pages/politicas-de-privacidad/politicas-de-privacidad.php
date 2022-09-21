<?php

    /*=============================================
        TODO: Traer él texto de Pade Views
    =============================================*/

    $select = "text_pageview";

	$url = CurlController::api()."pageviews?linkTo=type_pageview&equalTo=politicas-de-privacidad&select=".$select;
	$method = "GET";
	$fields = array();
	$header = array();

	$item = CurlController::request($url, $method, $fields, $header)->results[0];

?>

<!--=====================================================
    TODO: Breadcrumb
======================================================-->

<div class="ps-breadcrumb">

    <div class="container">

        <ul class="breadcrumb">

            <li><a href="/">Home</a></li>

            <li>Politicas De Privacidad</li>

        </ul>

    </div>

</div>

<!--=====================================================
    TODO: Become a Vendor Content
======================================================-->

<div class="container-fluid p-0">

    <!--=====================================================
        TODO: Become a VendorBest Faqs
    ======================================================-->

    <section class="ps-store-list">

        <div class="container">

            <div class="ps-section__header mt-18">

                <h3 class="mt-35">Politicas De Privacidad</h3>

            </div>

        </div>

    </section>

    <div class="ps-section--vendor ps-vendor-faqs">
        <div class="container">
            <div class="ps-section__content">
                <div class="row">

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <figure>
                            <p><?php print_r($item->text_pageview); ?></p>
                        </figure>
                    </div>

                </div>
            </div>
            <div class="ps-section__footer">
                <p>¿Todavía tienes más preguntas? Siéntete libre de contactarnos.</p><a class="ps-btn" href="tel:<?php echo $celular->value_extrasetting ?>">Contáctenos</a>
            </div>
        </div>
    </div>

    <!--=====================================================
        TODO: Become a VendorBest Banner
    ======================================================-->

    <div class="ps-vendor-banner bg--cover" style="background: url(assets/img/vendor/vendor.jpg);">
        <div class="container">
            <h2>No puedes esperar para ver lo que tenemos en la tienda</h2><a class="ps-btn ps-btn--lg"
                href="/">Empieza a comprar</a>
        </div>
    </div>

</div>