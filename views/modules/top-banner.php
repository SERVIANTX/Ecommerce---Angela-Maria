<?php

    $randomId = rand(1, $totalBanners);

    $url = CurlController::api()."relations?rel=top_banners,products&type=tbanner,product&linkTo=id_tbanner&equalTo=".$randomId."&select=picture_tbanner,data_tbanner,url_product";

    $method = "GET";
    $fields = array();
    $header = array();

    $randomData = CurlController::request($url, $method, $fields, $header)->results[0];
    $topBanner = json_decode($randomData->data_tbanner, true);

?>

<div class="ps-block--promotion-header bg--cover" style="background: url(<?php echo TemplateController::srcImg() ?>views/img/banners/top/<?php echo $randomData->picture_tbanner ?>">

    <div class="container">
        <div class="ps-block__left">
            <h3><?php echo $topBanner["H3 tag"] ?></h3>
            <figure>
                <p><?php echo $topBanner["P1 tag"]  ?></p>
                <h4><?php echo $topBanner["H4 tag"] ?></h4>
            </figure>
        </div>
        <div class="ps-block__center">
            <p><?php echo $topBanner["P2 tag"] ?><span><?php echo $topBanner["Span tag"] ?></span></p>
        </div><a class="ps-btn ps-btn--sm" href="<?php echo $path.$randomData->url_product ?>"><?php echo $topBanner["Button tag"] ?></a>
    </div>
</div>