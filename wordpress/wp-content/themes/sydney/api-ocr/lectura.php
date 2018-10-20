
<?php include("header.php");?>

                <body>
                    <div id="primary" class="content-area col-md-12">
                        <main id="main" class="post-wrap" role="main">
                            <article class="page type-page status-publish hentry create-OCR">
                                <div class="entry-content meteEnlaces">

                                    <?php
                                        paginacion();

                                        if(isset($_POST["pagina"])){
                                            page_edition();
                                        }
                                        if(isset($_POST["texto-edicion"])){
                                            text_edition();
                                        }
                                    ?>

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
