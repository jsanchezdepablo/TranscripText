<?php

	function index_check() {
		$url = $_SERVER["REQUEST_URI"];
		$url_index = "/wordpress/";

		if (strcmp($url, $url_index) !== 0) {
				echo 'pink-link';
		}
		else{
			echo "";
		}
	}



	function login_check() {

		if (isset($_COOKIE['wordpress_logged_in_bbfa5b726c6b7a9cf3cda9370be3ee91'])){
			echo 'not-showed-register';

		}else{
			echo 'not-showed-perfil';
		}
	}



	function login_check_OCR(){
		if (isset($_COOKIE['wordpress_logged_in_bbfa5b726c6b7a9cf3cda9370be3ee91'])){
			echo '<div class="col-xs-12">
					<input type="submit" class="pull-right book-button" name="showExistingBooks" value="Añadir a un libro">
				</div>';
		}else{
			echo '<div class="col-xs-12">
					<input type="submit" class="pull-right" name="download"  value="Descargar">
				</div>';
		}
	}

	function login_check_OCR_chooseForm(){
		if (isset($_COOKIE['wordpress_logged_in_bbfa5b726c6b7a9cf3cda9370be3ee91'])){
			echo '';

		}else{
			echo './pdf-download.php';
		}
	}



	function catch_user2(){
	    if (isset($_COOKIE['wordpress_logged_in_bbfa5b726c6b7a9cf3cda9370be3ee91'])){
	        $cookie_value = $_COOKIE['wordpress_logged_in_bbfa5b726c6b7a9cf3cda9370be3ee91'];
	        $cookie_values = explode("|", $cookie_value);
	        $current_user = $cookie_values[0];

			return $current_user;
		//	echo  '<script>console.log("'. $current_user. '")</script>';
	        /*echo ( '<script>console.log("'. $_COOKIE["wordpress_logged_in_bbfa5b726c6b7a9cf3cda9370be3ee91"]. '")</script>');*/
	    }
	}

	function catch_user_id(){
		include("connection.php");
		$usuario = catch_user2();
		$id_usuario = null;

		$res =  $connection->query("SELECT * FROM wp_users");

		while($i = $res->fetch_object()){
			$i->user_login;
			if($i->user_login == $usuario){
				$id_usuario = $i-> ID;
				return $id_usuario;
				break;
			}
		}

	}


	function addPhoto(){
		require __DIR__ . '/vendor/autoload.php';
	    $target_dir = "uploads/";
	    $archivo = $_FILES['portada']['tmp_name'];
		$nombreArchivo = $_FILES['portada']['name'];
	    $target_file = $target_dir . $nombreArchivo;

		move_uploaded_file($archivo, $target_file);
	}


	function addBook(){
		include("connection.php");
		$id_usuario = catch_user_id();
		$titulo = $_POST['nombre_libro'];

		if($_FILES['portada']['name'] != null){
			$portada = $_FILES["portada"]["name"];
			addPhoto();
		}else{
			$portada = 'libro.jpg';
		}

		if($connection->query("INSERT INTO libro values (NULL, '$titulo', '$portada', '$id_usuario')")){
			msgExito("Tu libro se ha guardado correctamente");

		}else{
			if(mysqli_errno($connection) == 1062){
			   msgError("Hubo un error introduciendo el libro, prueba de nuevo");
			}
		}
		mysqli_close($connection);
	}


	function show_books(){
		include("connection.php");
		$id_usuario = catch_user_id();

		$res =  $connection->query("SELECT * FROM libro  WHERE id_usuario = $id_usuario ORDER BY ID DESC");
		while($i = $res->fetch_object()){
			$titulo_fetch = $i->titulo;
			$portada_fetch = $i->portada;
			$id = catch_book_id($titulo_fetch);

			echo '<div class="col-xs-4 libros-biblio">
					<a href="lectura.php?id='.$id.'&pagina=1">
						<p>'.$titulo_fetch.'</p>
						<img src="uploads/'.$portada_fetch.'" width="333px" height="500px">
						<div class="mi-enlace">
							<a href="?id='.$id.'&drop=true" class="pull-right"><i class="far fa-trash-alt"></i> Eliminar libro</a>
							<a href="download-book.php?id='.$id.'&download=true"><i class="far fa-file-pdf"></i> Descargar</a>
						</div>
					</a>
				</div>';
		}

		// Cerrar la conexión
		mysqli_close($connection);
	}


	function msgExito($msg){
		$mensaje='<div class="popup" onclick="myFunction()"><span class="popuptext-green show" id="myPopup">'.$msg.'</span></div>';
		echo '<script> function myFunction(){
				var popup = document.getElementById("myPopup");
    			popup.classList.toggle("show");
			}</script>';

		echo $mensaje;
	}

	function msgError($msg){
		$mensaje='<div class="popup" onclick="myFunction()"><span class="popuptext-red show" id="myPopup">'.$msg.'</span></div>';
		echo '<script> function myFunction(){
				var popup = document.getElementById("myPopup");
    			popup.classList.toggle("show");
			}</script>';

		echo $mensaje;
	}



function headerFixed(){
	echo "<script>
			var headerFix = $('.site-header').offset().top;
			$(window).on('load scroll', function() {
			  var y = $(this).scrollTop();
			  if (y >= headerFix) {
				$('.site-header').addClass('fixed');
				$('body').addClass('siteScrolled');
			  } else {
				$('.site-header').removeClass('fixed');
				$('body').removeClass('siteScrolled');
			  }
			  if (y >= 107) {
				$('.site-header').addClass('float-header');
			  } else {
				$('.site-header').removeClass('float-header');
			  }
			});
		</script>";
}


function showExistingBooks(){
	$textoOcr = $_POST['text'];

	include("connection.php");

	$id_usuario = catch_user_id();

	echo '<article class="page type-page status-publish hentry create-OCR">
			<h4 class="title-post entry-title">Elige tu libro guardado anteriormente</h4>
			<form method="POST" enctype="multipart/form-data">
				<select name="book-options">';

	$res =  $connection->query("SELECT * FROM libro  WHERE id_usuario = $id_usuario ORDER BY ID DESC");

	while($i = $res->fetch_object()){
		$titulo_fetch = $i->titulo;
		echo '<option value="'.$titulo_fetch.'">'.$titulo_fetch.'</option>';
	}
	echo '		</select>
			<textarea class="ocultar" name="texto-ocr">'.$textoOcr.'</textarea>
			<input type="submit" value="Elegir y guardar">
			</form>
		</article>';

	// Cerrar la conexión
	mysqli_close($connection);
}


function catch_book_id($bookName){
	include("connection.php");
	$id_libro = null;

	$res =  $connection->query("SELECT * FROM libro");

	while($i = $res->fetch_object()){
		if (strcmp($i->titulo, $bookName) == 0) {
			$id_libro = $i->ID;
			return $id_libro;
			break;
		}
	}

}

function addToExistingBook(){
	include("connection.php");
	$id_usuario = catch_user_id();
	$id_libro = catch_book_id($_POST['book-options']);
	$imagen = $_COOKIE["ocr-imagen"];
	$texto = $_POST['texto-ocr'];


	$res = $connection->query("SELECT MAX(num_pagina) as num_pagina FROM pagina WHERE id_libro = $id_libro");

	while($i = $res->fetch_object()){
		$num_pagina = $i->num_pagina;
	}

	$num_pagina = $num_pagina + 1; //Para aumentar en uno la ultima pagina

	addPagina($texto, $imagen, $num_pagina, $id_libro);


	// Cerrar la conexión
	mysqli_close($connection);

}



function addPagina($texto, $imagen, $num_pagina, $id_libro){
	//echo "ENTRO";
	$texto_codificado = /*str_replace( "\r\n" , " " , */$texto;
	include("connection.php");
	try {
		//echo "paso1";
		if($connection->query("INSERT INTO pagina values (NULL,'$texto_codificado', '$imagen', '$num_pagina', '$id_libro')") == true){
			msgExito("Tu página se ha guardado correctamente");
			//echo "paso2";
		}
	} catch (Exception $e) {
   		echo 'Excepción capturada: ',  $e->getMessage(), "\n";
		msgError("Hubo un error introduciendo la página, prueba de nuevo");
	}


	// Cerrar la conexión
	mysqli_close($connection);
}


function lectura(){
	include("connection.php");
	$id_libro = $_GET["id"];

	$res =  $connection->query("SELECT * FROM pagina WHERE id_libro = '$id_libro' ORDER BY num_pagina");

	while($i = $res->fetch_object()){
		$texto_fetch = $i->texto;
		$imagen_fetch = $i->imagen;

		echo '
			<img class="image-text col-xs-6 pull-left"  src="uploads/'.$imagen_fetch.'" >
			<textarea class="text-area-height col-xs-6 pull-right area-lectura">'.$texto_fetch.'</textarea>';
	}

	// Cerrar la conexión
	mysqli_close($connection);
}


function paginacion(){
	include("connection.php");
	$id_libro = $_GET["id"];


	if ($result = $connection->query("SELECT * FROM pagina WHERE id_libro = '$id_libro' ORDER BY num_pagina")) {
	    /* determinar el número de filas del resultado */
	    $num_total_registros = $result->num_rows;
	    $result->close();
	}

	if($num_total_registros == 0){
		check_pages();
	}

	//Limito la busqueda
	$TAMANO_PAGINA = 1;

	//examino la página a mostrar y el inicio del registro a mostrar
	$pagina = $_GET["pagina"];
	if (!$pagina) {
	   $inicio = 0;
	   $pagina = 1;
	}
	else {
	   $inicio = ($pagina - 1) * $TAMANO_PAGINA;
	}
	//calculo el total de páginas
	$total_paginas = ceil($num_total_registros / $TAMANO_PAGINA);

	$res = $connection->query("SELECT * FROM pagina WHERE id_libro = '$id_libro' ORDER BY num_pagina LIMIT ".$inicio."," . $TAMANO_PAGINA);

	while($i = $res->fetch_object()){
		$texto_fetch = $i->texto;
		$texto_fetch = /*str_replace( "\r\n" , " " , */$texto_fetch;
		$imagen_fetch = $i->imagen;
		$num_pagina = $i->num_pagina;

		echo '
			<img class="image-text col-xs-6 pull-left imagen-altura"  src="uploads/'.$imagen_fetch.'" >
			<form method="POST" enctype="multipart/form-data">
				<textarea class="text-area-height col-xs-6 pull-right area-lectura" name="texto-edicion">'.$texto_fetch.'</textarea>
				<div class="col-xs-12 edition-page">
					<h5> Aquí puedes editar el número o el texto de tu página</h5>
					<input type="submit" class="pull-right" name="download"  value="Editar libro">

			</form>



				<form method="POST" enctype="multipart/form-data" class="edition-page-form">
					<input type="submit" title="Si cambias el número de página, podrás intercambiarlo por otra página que ya exista." value="Intercambiar número de página">
					<input type="text" name="pagina"  value="'.$num_pagina.'">
				</form>
			</div>

			';

	}


	if ($total_paginas > 1) {
	      echo '<div class="col-xs-12 pasar-pagina">
		  			<a href="?id='.$id_libro.'&pagina='.($pagina-1).'"><i class="fas fa-caret-left"></i></a>
					';
	      for ($i=1;$i<=$total_paginas;$i++) {
	         if ($pagina == $i)
	            //si muestro el índice de la página actual, no coloco enlace
	            echo $pagina;
	         else
	            //si el índice no corresponde con la página mostrada actualmente,
	            //coloco el enlace para ir a esa página
	            echo '<span class="copia-pasar-pagina"> <a href="?id='.$id_libro.'&pagina='.$i.'">'.$i.'</a> </span> ';
	      }
	      if ($pagina != $total_paginas)
	         echo '<a href="?id='.$id_libro.'&pagina='.($pagina+1).'"><i class="fas fa-caret-right"></i></a></div>';

		if($pagina == 1)
	   		echo '<script> document.querySelector(".fa-caret-left").style.visibility="hidden"; </script>';
	}

	// Cerrar la conexión
	mysqli_close($connection);
}


function page_edition(){
	include("connection.php");
	$num_pagina_cambiar = $_POST["pagina"];
	$id_libro = $_GET["id"];
	$num_pagina_actual = $_GET["pagina"];

	$res1 = $connection->query("SELECT * FROM pagina WHERE id_libro='$id_libro' AND num_pagina='$num_pagina_cambiar'");
	$num_total_registros = $res1->num_rows;

	if($num_total_registros > 0){
		while($i = $res1->fetch_object()){
			$id = $i->ID;
			if($id){
				try {
					$connection->query("UPDATE pagina SET num_pagina='$num_pagina_cambiar' WHERE id_libro='$id_libro' AND num_pagina = '$num_pagina_actual'");
					$connection->query("UPDATE pagina SET num_pagina='$num_pagina_actual' WHERE ID='$id'");
					msgExito("Tu página se ha modificado correctamente");

				} catch (Exception $e) {
					echo 'Excepción capturada: ',  $e->getMessage(), "\n";
					msgError("Hubo un error introduciendo modificando la página, prueba de nuevo.");
				}
			}
		}

	}else{
		msgError("Solo puedes intercambiar páginas ya creadas, prueba otro número.");
	}

	// Cerrar la conexión
	mysqli_close($connection);
}


function check_pages(){

	echo '<div class="sin-pagina">
			<h3>No existen páginas para este libro...</h3>
			<a href="index.php">¿Quieres crear una?</a>
		</div>';
}

function text_edition(){
	include("connection.php");
	$id_libro = $_GET["id"];
	$num_pagina_actual = $_GET["pagina"];
	$texto_pagina = $_POST["texto-edicion"];


	try {
		$connection->query("UPDATE pagina SET texto='$texto_pagina' WHERE id_libro='$id_libro' AND num_pagina = '$num_pagina_actual'");
		msgExito("Tu página se ha modificado correctamente");

	} catch (Exception $e) {
		echo 'Excepción capturada: ',  $e->getMessage(), "\n";
		msgError("Hubo un error introduciendo modificando la página, prueba de nuevo.");
	}


	// Cerrar la conexión
	mysqli_close($connection);

}


function deleteBook(){
	include("connection.php");
	$id_libro = $_GET["id"];

	$msg = 'Estás a punto de eliminar el libro, ¿Quieres continuar? <a href="?id='.$id_libro.'&drop=true&eliminate=yes" > Aceptar</a>';

	$mensaje='<div class="popup" id="elimina" onclick="myFunction()"><span class="popuptext-red show eliminar-popup" id="myPopup1">'.$msg.'</span></div>';
	echo '<script>

		function myFunction(){
			var popup = document.getElementById("myPopup1");
			popup.classList.toggle("show");
		}

		</script>';

	echo $mensaje;

	if(isset($_GET["eliminate"])){

		try {
			$connection->query("DELETE FROM libro WHERE ID = '$id_libro'");

			echo '<script>
				document.getElementById("elimina").style.display = "none";
			</script>';

			msgExito("Tu libro se ha borrado correctamente");



		} catch (Exception $e) {
			echo 'Excepción capturada: ',  $e->getMessage(), "\n";
			msgError("Hubo un error borrando el libro, prueba de nuevo.");
		}

	}
	// Cerrar la conexión
	mysqli_close($connection);
}







?>
