<?php

    /*============================================================
        TODO: Traer las categorías más visitadas de mayor a menor
    =============================================================*/

    $select = "picture_category,name_category,url_category,id_category";
    $url = CurlController::api()."categories?orderBy=views_category&orderMode=DESC&startAt=0&endAt=6&select=".$select;
    $method = "GET";
    $fields = array();
    $header = array();

    $topCategories = CurlController::request($url, $method, $fields, $header)->results;

?>

<!--=====================================================
    TODO: Preload
======================================================-->

<div class="container-fluid preloadTrue">

    <div class="container">

        <div class="row">

            <?php

                $blocks = [0,1,2,3,4,5];

            ?>

            <?php foreach ($blocks as $key => $value): ?>

                <div class="col-xl-2 col-lg-3 col-sm-4 col-6">

                    <div class="ph-item">

                        <div class="ph-col-12">
                            <div class="ph-picture"></div>
                        </div>

                        <div class="ph-col-12">

                            <div class="ph-row">
                                <div class="ph-col-12 big"></div>
                            </div>

                        </div>

                    </div>

                </div>

            <?php endforeach ?>

        </div>

    </div>

</div>

<!--=====================================================
    TODO: Load
======================================================-->

<div class="ps-top-categories preloadFalse">

    <div class="container">

        <h3>Principales categorías del mes</h3>

        <div class="row">

            <?php foreach ($topCategories as $key => $value): ?>

                <div class="col-xl-2 col-lg-3 col-sm-4 col-6 ">
                    <div class="ps-block--category">
                        <a class="ps-block__overlay" href="<?php echo $path.$value->url_category ?>"></a>
                        <img src="<?php echo TemplateController::srcImg() ?>views/img/categories/<?php echo $value->picture_category ?>" alt="<?php echo $value->name_category ?>">
                        <p style="min-height: 50px;"><?php echo $value->name_category ?></p>
                    </div>
                </div>

            <?php endforeach ?>

        </div>

    </div>

</div>