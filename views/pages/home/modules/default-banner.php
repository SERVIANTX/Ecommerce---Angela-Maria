<?php

    /*=====================================================
        TODO: Traer 2 productos aleatoriamente
    ======================================================*/

    $randomStart = rand(0, ($totalBannersD-2));

    $select = "picture_dbanner,url_product";

    $url = CurlController::api()."relations?rel=default_banners,products&type=dbanner,product&orderBy=id_dbanner&orderMode=ASC&startAt=".$randomStart."&endAt=5&select=".$select;

    $method = "GET";
    $fields = array();
    $header = array();

    $productsDefaultBanner2 = CurlController::request($url, $method, $fields, $header)->results;

    $productsDefaultBanner = array_slice($productsDefaultBanner2, 0, 2);



?>

<!--=====================================================
    TODO: Preload
======================================================-->

<div class="container-fluid preloadTrue">

    <div class="container">

        <div class="ph-item border-0">

            <div class="ph-col-6">

                <div class="ph-picture"></div>

            </div>

            <div class="ph-col-6">

                <div class="ph-picture"></div>

            </div>

        </div>

    </div>

</div>

<!--=====================================================
    TODO: Load
======================================================-->

<div class="ps-promotions preloadFalse">

    <div class="container">

        <div class="row">

            <?php foreach ($productsDefaultBanner as $key => $value): ?>

                <div class="col-md-6 col-12 ">
                    <a class="ps-collection" href="<?php echo $path.$value->url_product ?>">

                        <img src="<?php echo TemplateController::srcImg() ?>views/img/banners/default/<?php echo $value->picture_dbanner ?>">
                    </a>
                </div>

            <?php endforeach ?>

        </div>

    </div>

</div>