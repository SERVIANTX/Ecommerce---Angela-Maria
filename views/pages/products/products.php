<?php

	$selectCategory = "url_product,url_category,picture_product,name_product,stock_product,productoffer_product,price_product,views_category,name_category,id_category,summary_product,url_brand,name_brand";

	$selectSubCategory = "url_product,url_category,picture_product,name_product,stock_product,productoffer_product,price_product,views_subcategory,name_subcategory,id_subcategory,summary_product,url_brand,name_brand";

    /*=====================================================
        TODO: Validar si hay parámetros de paginación
    =====================================================*/

	if(isset($urlParams[1])){

		if(is_numeric($urlParams[1])){


			$startAt = ($urlParams[1]*6) - 6;

		}else{

			echo '<script>

			window.location = "'.$path.$urlParams[0].'";

			</script>';

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

				echo '<script>

				window.location = "'.$path.$urlParams[0].'";

				</script>';

			}

		}else{

			echo '<script>

			window.location = "'.$path.$urlParams[0].'";

			</script>';

		}

	}else{

		$orderBy = "id_product";
		$orderMode = "DESC";
	}


	/*=================================================================
        TODO: Traemos los productos recién agregados a la categoría
    =================================================================*/

	$url = CurlController::api()."relations?rel=products,categories,brands&type=product,category,brand&linkTo=url_category,status_product&equalTo=".$urlParams[0].",1&orderBy=".$orderBy."&orderMode=".$orderMode."&startAt=".$startAt."&endAt=6&select=".$selectCategory;
	$method = "GET";
	$fields = array();
	$header = array();

	$showcaseProducts = CurlController::request($url, $method, $fields, $header)->results;

	if($showcaseProducts == "Not Found"){

		/*=====================================================================
			TODO: Traemos los productos recién agregados a la subcategoría
		=====================================================================*/

		$url = CurlController::api()."relations?rel=products,categories,subcategories,brands&type=product,category,subcategory,brand&linkTo=url_subcategory,status_product&equalTo=".$urlParams[0].",1&orderBy=".$orderBy."&orderMode=".$orderMode."&startAt=".$startAt."&endAt=6&select=".$selectSubCategory;

		$method = "GET";
		$fields = array();
		$header = array();

		$showcaseProducts = CurlController::request($url, $method, $fields, $header)->results;

		if($showcaseProducts != "Not Found"){

			/*=====================================================================
				TODO: Traer el total de productos de subcategorías
			=====================================================================*/

			$url = CurlController::api()."relations?rel=products,subcategories,brands&type=product,subcategory,brand&linkTo=url_subcategory,status_product&equalTo=".$urlParams[0].",1&select=id_subcategory";
			$method = "GET";
			$fields = array();
			$header = array();

			$dataProducts = CurlController::request($url, $method, $fields, $header);

			if($dataProducts->status == 200){

				$totalProducts = $dataProducts->total;

			}else{

				$totalProducts = 0;
			}

			/*=====================================================================
				TODO: Actualizar las vistas de subcategorías
			=====================================================================*/

			$view = $showcaseProducts[0]->views_subcategory+1;

			$url = CurlController::api()."subcategories?id=".$showcaseProducts[0]->id_subcategory."&nameId=id_subcategory&token=no&except=views_subcategory";
			$method = "PUT";
			$fields =  "views_subcategory=".$view;
			$header = array();

			$updateViewsSubCategory = CurlController::request($url, $method, $fields, $header);

		}else{

			echo '<script>

			window.location = "'.$path.'";

			</script>';
		}

	}else{

		/*=================================================================
			TODO: Traer el total de productos de categorías
		=================================================================*/


		$url = CurlController::api()."relations?rel=products,categories,brands&type=product,category,brand&linkTo=url_category,status_product&equalTo=".$urlParams[0].",1&select=id_category";
		$method = "GET";
		$fields = array();
		$header = array();

		$dataProducts = CurlController::request($url, $method, $fields, $header);

		if($dataProducts->status == 200){

			$totalProducts = $dataProducts->total;

		}else{

			$totalProducts = 0;
		}

		/*=================================================================
			TODO: Actualizar las vistas de categorías
		=================================================================*/

		$view = $showcaseProducts[0]->views_category+1;

		$url = CurlController::api()."categories?id=".$showcaseProducts[0]->id_category."&nameId=id_category&token=no&except=views_category";
		$method = "PUT";
		$fields =  "views_category=".$view;
		$header = array();

		$updateViewsCategory = CurlController::request($url, $method, $fields, $header);

	}

	/*=================================================================
		TODO: Traemos los productos más vendidos de esta categoría
	=================================================================*/

	$url = CurlController::api()."relations?rel=products,categories,brands&type=product,category,brand&linkTo=url_category,status_product&equalTo=".$urlParams[0].",1&orderBy=sales_product&orderMode=DESC&startAt=0&endAt=6&select=".$selectCategory;
	$method = "GET";
	$fields = array();
	$header = array();

	$bestSalesItems = CurlController::request($url, $method, $fields, $header)->results;

	if($bestSalesItems == "Not Found"){

		/*=================================================================
			TODO: Traemos los productos más vendidos de esta subcategoría
		=================================================================*/

		$url = CurlController::api()."relations?rel=products,categories,subcategories,brands&type=product,category,subcategory,brand&linkTo=url_subcategory,status_product&equalTo=".$urlParams[0].",1&orderBy=sales_product&orderMode=DESC&startAt=0&endAt=6&select=".$selectSubCategory;
		$method = "GET";
		$fields = array();
		$header = array();

		$bestSalesItems = CurlController::request($url, $method, $fields, $header)->results;

	}

	/*=================================================================
		TODO: Traemos los productos más vistos de esta categoría
	=================================================================*/

	$url = CurlController::api()."relations?rel=products,categories,brands&type=product,category,brand&linkTo=url_category,status_product&equalTo=".$urlParams[0].",1&orderBy=views_product&orderMode=DESC&startAt=0&endAt=6&select=".$selectCategory;
	$method = "GET";
	$method = "GET";
	$fields = array();
	$header = array();

	$recommendedItems = CurlController::request($url, $method, $fields, $header)->results;

	if($recommendedItems == "Not Found"){

		/*=================================================================
			TODO: Traemos los productos más vistos de esta subcategoría
		=================================================================*/

		$url = CurlController::api()."relations?rel=products,categories,subcategories,brands&type=product,category,subcategory,brand&linkTo=url_subcategory,status_product&equalTo=".$urlParams[0].",1&orderBy=views_product&orderMode=DESC&startAt=0&endAt=6&select=".$selectSubCategory;
		$method = "GET";
		$fields = array();
		$header = array();

		$recommendedItems = CurlController::request($url, $method, $fields, $header)->results;

	}


?>


<!--=====================================================
TODO: Breadcrumb
======================================================-->

<?php include "modules/breadcrumb.php" ?>

<!--=====================================================
    TODO: Categories Content
======================================================-->

<div class="container-fuid bg-white my-4">

    <div class="container">

		<!--=====================================================
			TODO: Layout Categories
		======================================================-->

		<div class="ps-layout--shop">

			<section>

				<!--=====================================================
					TODO: Best Sale Items
				======================================================-->

				<?php include "modules/best-sales-items.php" ?>

				<!--=====================================================
					TODO: Recommended Items
				======================================================-->

				<?php include "modules/recommended-items.php" ?>

				<!--=====================================================
					TODO: Products found
				======================================================-->

				<?php include "modules/showcase.php" ?>

            </section>

        </div>

	</div>

</div>