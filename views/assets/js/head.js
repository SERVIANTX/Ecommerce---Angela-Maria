/*=====================================================
	TODO: Función para formatear Inputs
======================================================*/

function fncFormatInputs(){

    if(window.history.replaceState){
        window.history.replaceState( null, null, window.location.href );
    }

}

/*=====================================================
	TODO: Función para Notie Alert
======================================================*/

function fncNotie(type, text){

	notie.alert({

		type: type,
		text: text,
		time: 10

    })

}

/*=====================================================
	TODO: Función Sweetalert
======================================================*/

function fncSweetAlert(type, text, url){

	switch (type) {

		/*=====================================================
			TODO: Cuando ocurre un error
		======================================================*/

		case "error":

			if(url == null){

				Swal.fire({
					icon: 'error',
					title: 'Error',
					text: text
				})

			}else{

				Swal.fire({
					icon: 'error',
					title: 'Error',
					text: text
				}).then((result) => {

					if (result.value) {

						window.open(url, "_top");

					}

				})

			}

        break;

		/*=====================================================
			TODO: Cuando es correcto
		======================================================*/

		case "success":

			if(url == null){

				Swal.fire({
					icon: 'success',
					title: 'Success',
					text: text
				})

			}else{

				Swal.fire({
					icon: 'success',
					title: 'Success',
					text: text
				}).then((result) => {

					if (result.value) {

						window.open(url, "_top");

					}

				})

			}

        break;

		/*=====================================================
			TODO: Cuando estamos precargando
		======================================================*/

		case "loading":

			Swal.fire({
				allowOutsideClick: false,
				icon: 'info',
				text:text
			})
			Swal.showLoading()

        break;

		/*=====================================================
			TODO: Cuando necesitamos cerrar la alerta suave
		======================================================*/

		case "close":

			Swal.close()

		break;

		/*=====================================================
			TODO: Cuando solicitamos confirmación
		======================================================*/

		case "confirm":

			return new Promise(resolve=>{

				Swal.fire({
					text: text,
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					cancelButtonText: 'Cancel',
					confirmButtonText: 'Yes, delete!'
				}).then(function(result){

					resolve(result.value);

				})

			})


		break;

		/*=====================================================
			TODO: Cuando es Informacion
		======================================================*/

		case "infoProduct":

			if(url == null){

				Swal.fire({
					icon: 'info',
					title: 'Lo sentimos',
					text: text
				})

			}else{

				Swal.fire({
					icon: 'info',
					title: 'Lo sentimos',
					text: text
				}).then((result) => {

					if (result.value) {

						window.open(url, "_top");

					}

				})

			}

        break;

		/*=====================================================
			TODO: Cuando necesitamos incorporar un HTML
		======================================================*/

		case "html":

			Swal.fire({
				allowOutsideClick: false,
				title: 'Haga clic para continuar con el pago...',
				icon: 'info',
				html:text,
				showConfirmButton: false,
				showCancelButton: true,
				cancelButtonColor: '#d33'
			})

		break;

	}

}