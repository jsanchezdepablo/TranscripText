

                <body>
                    <div id="primary" class="content-area col-md-12">
                        <main id="main" class="post-wrap" role="main">
                            <article class="page type-page status-publish hentry create-OCR">
                                <div class="entry-content meteEnlaces">

                                    <?php


                                        if(isset($_GET["id"])){
                                            if(isset($_GET["download"])){
                                                downloadBook();
                                            }
                                        }


                                        function downloadBook(){
                                            include("connection.php");
                                            require('../plugins/pdf/fpdf.php');

                                            $id_libro = $_GET["id"];
                                            $line_text = array();
                                            $titulo = "";
                                            $i = 0;

                                            $res1 = $connection->query("SELECT titulo FROM libro WHERE ID = '$id_libro'");

                                            while ($fila = $res1->fetch_row()) {
                                               $titulo = $fila[0];
                                               break;
                                            }





                                            $res = $connection->query("SELECT * FROM pagina WHERE id_libro = '$id_libro' ORDER BY num_pagina");

                                            $pdf=new FPDF('P','mm','A4');
                                            $pdf->AddPage();
                                            header_page($pdf, $titulo);
                                            $pdf->SetFont('Arial','',10);



                                            while($i = $res->fetch_object()){
                                                $texto = $i->texto;
                                                $texto_decode = iconv('utf-8', 'cp1252', $texto);
                                                $pdf->Write(10, $texto_decode);

                                                /*for ($cont = 0; $i <= strlen($texto); $cont++) {
                                                    $line_text[$cont] = substr($texto, $i, 500);
                                                    $i = $i+500;
                                                    $texto_decode = iconv('utf-8', 'cp1252', $line_text[$cont]);
                                                    $pdf->Cell(10,50, $texto_decode);
                                                    $pdf->Ln();
                                                }*/
                                            }
                                            footer_page($pdf);
                                            ob_end_clean();
                                            $pdf->Output();


                                            // Cerrar la conexión
                                            mysqli_close($connection);
                                        }


                                        function header_page($pdf, $titulo){

                                            $titulo_decode = iconv('utf-8', 'cp1252', $titulo);
                                            // Select Arial bold 15
                                            $pdf->SetFont('Arial','B',15);
                                            // Move to the right
                                            $pdf->Cell(80);
                                            // Framed title
                                            $pdf->Cell(30,10,$titulo_decode,0,0,'C');
                                            // Line break
                                            $pdf->Ln(18);
                                        }


                                        function footer_page($pdf){
                                            $pagina_decode = iconv('utf-8', 'cp1252', 'Página ');
                                            // Go to 1.5 cm from bottom
                                            $pdf->SetY(-1.5);
                                            // Select Arial italic 8
                                            $pdf->SetFont('Arial','I',8);
                                            // Print centered page number
                                            $pdf->Cell(0,-20,$pagina_decode.$pdf->PageNo(),0,0,'C');

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
