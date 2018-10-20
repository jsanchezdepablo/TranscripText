
<?php include("header.php") ?>


<?php

    if (isset($_POST['nombre_libro'])) {
        addBook();
    }

?>

                <body>
                    <br>
                    <div id="primary" class="content-area col-md-12">
                        <main id="main" class="post-wrap" role="main">
                            <article class="page type-page status-publish hentry create-book">
                                <header class="entry-header">
                                    <h1 class="title-post entry-title">Crea tu libro</h1>
                                </header>
                                <div class="entry-content">
                                    <form method="POST" enctype="multipart/form-data" class="wppb-user-forms wppb-edit-user wppb-user-role-administrator label-size">
                                        <ul>
                                            <li class="wppb-form-field">
                                                <label>Nombre<span class="wppb-required" title="Campo requerido">*</span></label>
                                                <input class="text-input" name="nombre_libro" maxlength="70" type="text" required="" placeholder="Nombre del libro">
                                            </li>
                                            <li class="wppb-form-field">
                                                <label>Portada</label>
                                                <input class="text-input" type="file" class="form-control margin-ocr" name="portada"  title="Selecciona aquí tu fichero">
                                            </li>
                                        </ul>
                                        <input type="submit" value="Crear libro">
                                    </form>
                                </div>
                            </article>

                            <article  class="page type-page status-publish hentry">
                                <header class="entry-header">
                                    <h1 class="title-post entry-title">Tus libros</h1>
                                </header>
                                <div class="entry-content">
                                    <div class="col-xs-12">
                                        <?php
                                            if(isset($_GET["id"])){
                                                if(isset($_GET["drop"])){
                                                    deleteBook();

                                                }else if(isset($_GET["download"])){
                                                    downloadBook();
                                                }
                                            }
                                        ?>
                                    </div>
                                    <div class="col-xs-12">
                                        <?php
                                            show_books();
                                        ?>
                                    </div>
                                </div>
                            </article>
                        </main>
                    </div>
                </body>
            </div> <!-- div del row -->
        </div> <!-- container -->
    </div> <!-- content-->

    <?php include("footer.php") ?>
</html>
