<!DOCTYPE html>
<html>
    <head>
        <title>OCR - TranscripText</title>

        <link rel="stylesheet" href="../css/bootstrap/bootstrap.min.css">
        <link rel="stylesheet" id="sydney-font-awesome-css" href="../fonts/font-awesome.min.css?ver=4.9.5" type="text/css" media="all">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Raleway:400,500,600" rel="stylesheet">
        <link rel="stylesheet" href="../style.css">
        <link rel="stylesheet" href="../../../plugins/profile-builder/assets/css/style-front-end.css">
        <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.0/js/bootstrap.min.js'></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="http://gmpg.org/xfn/11">


        <?php include('my_functions.php');?>
    </head>


    <div id="page" class="hfeed site">
  	    <a class="skip-link screen-reader-text" href="#content"></a>

      	<header id="masthead" class="site-header <?php index_check(); ?>" role="banner">  <!-- Y que aquí le meta en class la llamada a mi funcion con un echo de la funcion o llamarla simplemente-->
      		<div class="header-wrap">
                <div class="container">
                    <div class="row">
    	                <div class="col-md-4 col-sm-8 col-xs-12">
                            <h1 class="site-title"><a href="http://localhost/wordpress/" rel="home">TranscripText</a></h1>
                            <h2 class="site-description">Transcribe y edita, tan simple como parece.</h2>
      		            </div>
            		    <div class="col-md-8 col-sm-4 col-xs-12">
            				<div class="btn-menu"></div>
                            <nav id="mainnav" class="mainnav <?php login_check(); ?>" role="navigation">
                                <div class="menu-mi-menu-container">
                                    <ul id="menu-mi-menu" class="menu">
                                        <li id="menu-item-22" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-home menu-item-22">
                                            <a href="http://localhost/wordpress/">Inicio</a>
                                        </li>
                                        <li id="menu-item-110" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-110">
                                            <a href="http://localhost/wordpress/wp-content/themes/sydney/api-ocr/index.php">OCR</a>
                                        </li>
                                        <li id="menu-item-48" class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-37 current_page_item menu-item-48">
                                            <a href="http://localhost/wordpress/registro/">Registro</a>
                                        </li>
                                        <li id="menu-item-120" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-120">
                                            <a href="http://localhost/wordpress/wp-content/themes/sydney/api-ocr/biblioteca.php">Biblioteca</a>
                                        </li>
                                        <li id="menu-item-119" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-119">
                                            <a href="http://localhost/wordpress/perfil/">Perfil</a>
                                        </li>
                                        <li id="menu-item-47" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-47">
                                            <a href="http://localhost/wordpress/login/">Login</a>
                                        </li>

                                    </ul>
                                </div>
                            </nav>
            			</div>
        		    </div>
      			</div>
      		</div>
      	</header>

    </div>
    <?php headerFixed();?>


	<div id="content" class="page-wrap">
		<div class="container content-wrapper">
			<div class="row">
