<!--=====================================================
    TODO: Navegación del Menu
======================================================-->



<ul class="ps-tab-list">

    <li class="active"><a href="#tab-1">Descripción</a></li>
    <li><a href="#tab-2">Detalles</a></li>
    <li><a href="#tab-3">Marca</a></li>

</ul>

<div class="ps-tabs">

    <!--=====================================================
        TODO: Descripción
    ======================================================-->

    <div class="ps-tab active" id="tab-1">

        <div class="ps-document">

            <?php echo $item->description_product ?>

        </div>

    </div>

    <!--=====================================================
        TODO: Detalles
    ======================================================-->

    <div class="ps-tab" id="tab-2">

        <div class="table-responsive">

            <table class="table table-bordered ps-table ps-table--specification">

                <tbody>

                    <?php

                        $details = json_decode($item->details_product, true);

                    ?>

                    <?php foreach ($details as $key => $value): ?>

                    <tr>
                        <td><?php echo $value["title"] ?></td>
                        <td><?php echo $value["value"] ?></td>
                    </tr>

                    <?php endforeach ?>

                </tbody>

            </table>

        </div>

    </div>

    <!--=====================================================
        TODO: Marca
    ======================================================-->

    <div class="ps-tab" id="tab-3">

        <div class="media">

            <img src="<?php echo TemplateController::srcImg() ?>views/img/brands/<?php echo $item->picture_brand ?>" class="mr-5 mt-1 rounded-circle" alt="<?php echo $item->name_brand ?>" width="120">

            <div class="media-body">

                <h4><?php echo $item->name_brand ?></h4>

                <p><?php /* echo $item->name_brand */ ?></p>

                <a href="<?php echo $path.$item->url_brand ?>">Más productos de <?php echo $item->name_brand ?></a>

            </div>

        </div>

    </div>

    <div class="ps-tab active" id="tab-6">

        <p>Lo sentimos, no hay más ofertas disponibles.</p>

    </div>

</div>