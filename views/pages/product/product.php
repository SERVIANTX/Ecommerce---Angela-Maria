<?php

	/*=======================================================================
		TODO: Recibir variable GET de cupones y convertirla en Cookie
	========================================================================*/

	if(isset($_GET["coupon"])){

		if(isset($_COOKIE["couponsMP"])){

			$arrayCoupon = json_decode($_COOKIE["couponsMP"],true);

			foreach ($arrayCoupon as $key => $value) {

				if($value != $_GET["coupon"]){

					array_push($arrayCoupon, $_GET["coupon"]);
				}
			}

			setcookie("couponsMP", json_encode($arrayCoupon), time()+3600*24*7);

		}else{

			$arrayCoupon = array($_GET["coupon"]);
			setcookie("couponsMP", json_encode($arrayCoupon), time()+3600*24*7);

		}

	}

	/*=======================================================================
		TODO: Traer toda la información del producto
	========================================================================*/

	$select = "id_product,maxquantitysale_product,url_category,url_product,picture_product,name_product,productoffer_product,price_product,id_category,name_category,id_subcategory,name_subcategory,gallery_product,stock_product,summary_product,title_list_product,views_product,description_product,details_product,url_subcategory,id_brand,url_brand,name_brand,picture_brand";

	$url = CurlController::api()."relations?rel=products,categories,subcategories,brands&type=product,category,subcategory,brand&linkTo=url_product,status_product&equalTo=".$urlParams[0].",1&select=".$select;
	$method = "GET";
	$fields = array();
	$header = array();

	$item = CurlController::request($url, $method, $fields, $header)->results[0];

	if($item == "N"){

		echo '<script>

				fncSweetAlert(
					"infoProduct",
					"Este producto está deshabilitado",
					"'.$path.'"
				);

			</script>';

		return;

	}

	/*=======================================================================
		TODO: Actualizar las vistas de producto
	========================================================================*/

	$view = $item->views_product+1;

	$url = CurlController::api()."products?id=".$item->id_product."&nameId=id_product&token=no&except=views_product";
	$method = "PUT";
	$fields =  "views_product=".$view;
	$header = array();

	$updateViewsProduct = CurlController::request($url, $method, $fields, $header);

?>



<!--=====================================================
    TODO: Preload
======================================================-->

<!-- <div id="loader-wrapper">
    <img src="img/template/loader.jpg">
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
</div>   -->

<!--=====================================================
    TODO: Call to Action -> FALTA
======================================================-->

<?php include "modules/call-to-action.php" ?>

<!--=====================================================
    TODO: Breadcrumb
======================================================-->

<?php include "modules/breadcrumb.php" ?>

<!--=====================================================
    TODO: Product Content
======================================================-->

<div class="ps-page--product">

	<div class="ps-container">

		<!--=====================================================
			TODO: Product Container
		======================================================-->

		<div class="ps-page__container">

			<!--=====================================================
				TODO: Left Column
			======================================================-->

			<div class="ps-page__left">

				<div class="ps-product--detail ps-product--fullwidth">

					<!--=====================================================
						TODO: Product Header
					======================================================-->

					<div class="ps-product__header">

						<!--=====================================================
							TODO: Gallery
						======================================================-->

						<?php Include "modules/gallery.php" ?>

						<!--=====================================================
							TODO: Product Info
						======================================================-->

						<?php include "modules/product-info.php" ?>

					</div> <!-- End Product header -->

					<!--=====================================================
						TODO: Product Content
					======================================================-->

					<div class="ps-product__content ps-tab-root">

						<!--=====================================================
							TODO: Bought Together
						======================================================-->

						<?php include "modules/bought-together.php" ?>

						<!--=====================================================
							TODO: Menu
						======================================================-->

						<?php include "modules/menu.php" ?>

					</div><!--  End product content -->

				</div>

			</div><!-- End Left Column -->


			<!--=====================================================
				TODO: Right Column
			======================================================-->

			<?php include "modules/right-column.php" ?>

		</div><!--  End Product Container -->

		<!--=====================================================
			TODO: Related products
		======================================================-->

		<?php include "modules/related-product.php" ?>
	</div>

</div><!-- End Product Content -->