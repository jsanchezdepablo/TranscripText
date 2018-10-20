<?php

if(isset($_POST['transform']) && isset($_FILES)) {
    require __DIR__ . '/vendor/autoload.php';
    $target_dir = "uploads/";
    $uploadOk = 1;
    $FileType = strtolower(pathinfo($_FILES["attachment"]["name"],PATHINFO_EXTENSION));
    $target_file = $target_dir . $_FILES['attachment']['name'];

    // Check file size
    if ($_FILES["attachment"]["size"] > 5000000) {
        header('HTTP/1.0 403 Forbidden');
        echo "Lo sentimos, tu archivo es demasiado grande.";
        $uploadOk = 0;
    }
    if($FileType != "pdf" && $FileType != "png" && $FileType != "jpg") {
        header('HTTP/1.0 403 Forbidden');
        echo "Lo sentimos, sube un archivo con extensión PDF, PNG o JPG.";
        $uploadOk = 0;
    }
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["attachment"]["tmp_name"], $target_file)) {
            uploadToApi($target_file);
        } else {
            header('HTTP/1.0 403 Forbidden');
            echo "Lo sentimos, hubo un error cargando tu archivo.";
        }
    }

} else if (isset($_POST['download'])) {
    downloadPDF();

} else if (isset($_POST['addToNewBook'])) {
    addBook();

}else if (isset($_POST['addToExistingBook'])) {

}else {
    header('HTTP/1.0 403 Forbidden');
    echo "Lo sentimos, sube un archivo con extensión PDF, PNG o JPG.";
}

function uploadToApi($target_file){
    require __DIR__ . '/vendor/autoload.php';
    $fileData = fopen($target_file, 'r');
    $client = new \GuzzleHttp\Client();
    try {
    $r = $client->request('POST', 'https://api.ocr.space/parse/image',[
        'headers' => ['apiKey' => '3c5a17b91d88957'],
        'multipart' => [
            [
                'name' => 'file',
                'contents' => $fileData
            ]
        ]
    ], ['file' => $fileData]);
    $response =  json_decode($r->getBody(),true);
    if($response['ErrorMessage'] == "") {
?>

<?php include("header.php") ?>

                <body>
                    <div id="primary" class="content-area col-md-12">
                        <form method="POST">
                            <div class="form-group container">
                                <h3 class="col-xs-12">Resultado transcripción:</h3>

                                <img class="image-text col-xs-6" name="image" src="uploads/<?php echo $_FILES['attachment']['name'] ?>" >

                                <?php
                                    foreach($response['ParsedResults'] as $pareValue) {
                                        $text =  $pareValue['ParsedText'];
                                    }
                                ?>
                                <textarea class="text-area-height col-xs-6" name="text"><?php echo $text;?></textarea>
                                <?php echo login_check_OCR();?>
                            </div>
                        </form>
                    </div>
                </body>
            </div> <!-- div del row -->
        </div> <!-- container -->
    </div> <!-- content-->

    <?php include("footer.php") ?>
</html>
<?php
    } else {
        header('HTTP/1.0 400 Forbidden');
        echo $response['ErrorMessage'];
    }
    } catch(Exception $err) {
        header('HTTP/1.0 403 Forbidden');
        echo $err->getMessage();
    }
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


function catch_user(){
    if (isset($_COOKIE['wordpress_logged_in_bbfa5b726c6b7a9cf3cda9370be3ee91'])){
        $cookie_value = $_COOKIE['wordpress_logged_in_bbfa5b726c6b7a9cf3cda9370be3ee91'];
        $cookie_values = explode("|", $cookie_value);
        $current_user = $cookie_values[0];

        echo  '<script>console.log("'. $current_user. '")</script>';
        /*echo ( '<script>console.log("'. $_COOKIE["wordpress_logged_in_bbfa5b726c6b7a9cf3cda9370be3ee91"]. '")</script>');*/
    }
}

function downloadPDF(){
    require('../plugins/pdf/fpdf.php');
    $line_text = array();
    $i = 0;

    if (isset($_POST['download'])){
        $file = $_POST["text"];
            $pdf=new FPDF('P','mm','A4');
            $pdf->AddPage();
            $pdf->SetFont('Arial','B',10);

            for ($cont = 0; $i <= strlen($file); $cont++) {

                $line_text[$cont] = substr($file, $i, 100);
                $i = $i+100;
                $pdf->Cell(20,10, $line_text[$cont]);
                $pdf->Ln();

            }
            $pdf->Output();

    }
}



function addBook2(){
    require_once("connection.php");

    $text = $_POST['text'];

    //ESTO ES UNA PRUEBA

    $connection->query("CREATE TABLE myCity LIKE City");


/*ESTAS FUNCIONAN*/

//GET
    $res = $connection->query("SELECT * FROM wp_users");

    while($i = $res->fetch_object()){
        echo $i->ID.' <br/>';
    }


$res2 =$connection->query("SELECT * FROM pagina");

while($i = $res2->fetch_object()){
    echo $i->texto.' <br/>';
}

//ELIMINAR
//$connection->query("DELETE FROM pagina WHERE ID = 2");
//ACTUALIZAR
//$connection->query("UPDATE pagina Set texto='esto es una prueba y fuinciona' Where ID = 3");

//INSERT
//$connection->query("INSERT INTO pagina (ID, texto, id_libro) values (NULL, 'culo', '1')");



//INSERT INTO pagina (ID,texto) values (NULL,'$text')
    /*mysqli_query($connection,"SELECT * FROM pagina");
    mysqli_query($connection,"INSERT INTO pagina (ID,texto) values (NULL,'$text')");*/

/*    if (!$connection->query("SELECT * FROM pagina") && !$connection->query("INSERT INTO pagina (ID,texto) values (NULL,'$text')")){
        echo "Falló la creación de la tabla: (" . $mysqli->errno . ") " . $mysqli->error;
    }


    /*$res = $connection->query("INSERT INTO pagina (ID,texto) values (NULL,'$text')");

    $sql="INSERT INTO pagina (ID,texto) values (NULL,'$text')";
    if(mysqli_query($connection,$sql)){
        echo "FUNCIONA";


    }else{

    }*/

     // Cerrar la conexión
     mysqli_close($connection);
}



?>
