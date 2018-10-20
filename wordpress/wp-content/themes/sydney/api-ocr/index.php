
<?php include("header.php");?>

                <body>
                    <br>
                    <div id="primary" class="content-area col-md-12">
                        <main id="main" class="post-wrap" role="main">
                            <article class="page type-page status-publish hentry">
                                <header class="entry-header">
                                    <h1 class="title-post entry-title">Sube aquí tu imagen a transcribir</h1>
                                </header>
                                <div class="entry-content">
                                    <form id="upload" method='POST' enctype="multipart/form-data">
                                        <div class="col-xs-12 margin-ocr">
                                        <input type="file" class="form-control" name="attachment"  title="Selecciona aquí tu fichero" required="required" aria-required="true">
                                        <button type="submit" class="btn btn-success" name="transform">Transformar</button>
                                        </div>
                                    </form>
                                </div>
                            </article>


<?php if(isset($_POST['transform']) && isset($_FILES)) {
  require __DIR__ . '/vendor/autoload.php';
  $target_dir = "uploads/";
  $uploadOk = 1;
  $FileType = strtolower(pathinfo($_FILES["attachment"]["name"],PATHINFO_EXTENSION));
  $target_file = $target_dir . $_FILES['attachment']['name'];

  // Check file size
  if ($_FILES["attachment"]["size"] > 5000000) {
      //header('HTTP/1.0 403 Forbidden');
      echo "Lo sentimos, tu archivo es demasiado grande.";
      $uploadOk = 0;
  }
  if($FileType != "pdf" && $FileType != "png" && $FileType != "jpg") {
      //header('HTTP/1.0 403 Forbidden');
      echo "Lo sentimos, sube un archivo con extensión PDF, PNG o JPG.";
      $uploadOk = 0;
  }
  if ($uploadOk == 1) {
      if (move_uploaded_file($_FILES["attachment"]["tmp_name"], $target_file)) {
          uploadToApi($target_file);
      } else {
          //header('HTTP/1.0 403 Forbidden');
          echo "Lo sentimos, hubo un error cargando tu archivo.";
      }
  }

} else if (isset($_POST['download'])) {
    downloadPDF();

}else if (isset($_POST['showExistingBooks'])) {
    showExistingBooks();
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

                    <article class="page type-page status-publish hentry create-OCR">
                        <header class="entry-header">
                            <h1 class="title-post entry-title">Resultado transcripción:</h1>
                        </header>
                        <div class="entry-content">
                            <form method="POST" action="<?php login_check_OCR_chooseForm();?>" enctype="multipart/form-data">
                              <img class="image-text col-xs-6 imagen-altura" name="image" src="uploads/<?php echo $_FILES['attachment']['name'] ?>" >

                              <?php
                                  foreach($response['ParsedResults'] as $pareValue) {
                                      $text =  $pareValue['ParsedText'];
                                  }
                              ?>

                              <textarea class="text-area-height col-xs-6 area-lectura-ocr" name="text"><?php echo /*str_replace( "\r\n" , " " , */$text;?></textarea>

                              <?php echo login_check_OCR();?>

                              <?php
                                    echo '<script>
                                              var d = new Date();
                                              d.setTime(d.getTime() + (10*24*60*60*1000));
                                              var expira = d.toUTCString();
                                              document.cookie = "ocr-imagen="+"'.$_FILES['attachment']['name'].'"+"; expires="+expira+"; path=/;";
                                          </script>';

                                ?>

                          </form>
                        </div>
                      </article>
              </main>

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
?>

<?php
  if(isset($_POST['book-options'])){
    addToExistingBook();

  }?>
                    </div>
                </body>
            </div> <!-- div del row -->
        </div> <!-- container -->
    </div> <!-- content-->



    <?php include("footer.php") ?>
</html>


<?php

function catch_user(){
    if (isset($_COOKIE['wordpress_logged_in_bbfa5b726c6b7a9cf3cda9370be3ee91'])){
        $cookie_value = $_COOKIE['wordpress_logged_in_bbfa5b726c6b7a9cf3cda9370be3ee91'];
        $cookie_values = explode("|", $cookie_value);
        $current_user = $cookie_values[0];

        //echo  '<script>console.log("'. $current_user. '")</script>';
        /*echo ( '<script>console.log("'. $_COOKIE["wordpress_logged_in_bbfa5b726c6b7a9cf3cda9370be3ee91"]. '")</script>');*/
    }
}


?>
