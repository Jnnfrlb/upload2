<?php

if(isset($_POST['envoyer'])) //si le formulaire est soumis
{
  $content_dir = 'images/'; // dossier où seront déplacés les fichiers
  $fichier = $_FILES['fichier']['name'];
  $sizeMax = 1024000;
  $tmp_file = $_FILES['fichier']['tmp_name']; //fichier temporaire
  $size = $_FILES['fichier']['size'];
  $extension = array(".jpeg", ".jpg", ".JPG", ".gif", ".png");

  $nbFichiers = count($tmp_file); //compte le nb de fichiers envoyés

  for($i=0; $i<$nbFichiers; $i++)
  {
    if ($size[$i] > $sizeMax)
    {
      $error = 'Le fichier est trop volumineux.';
    }
    if (!in_array(strrchr($fichier[$i], '.'), $extension))
    {
      $error = 'Le type du fichier n\'est pas jpg, png ou gif.';
    }
    if(!isset($error))
    {
      $ext = uniqid().strrchr($fichier[$i], '.');
      $pathImg = 'images/'.$ext;

        if(move_uploaded_file($tmp_file[$i], $pathImg));
        {
          echo "<div class=\"alert alert-success\" role=\"alert\">Téléchargement réussi !</div></br>";
        }
      } else
        {
          echo "<div class=\"alert alert-danger\" role=\"alert\">".$error." </div>";
        }
    }
  }

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Upload File</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  </head>

  <body>
    <div class="container" style="border: 1px dashed black;">
      <form class="" action="formulaire.php" method="post" enctype="multipart/form-data">
          <h2>Téléchargez vos fichiers</h2><br>
          <label for="upload">Ajoutez vos téléchargements (uniquement jpg, png et gif ; max < 1Mo):</label><br>
          <input type="hidden" name="MAX_FILES_SIZE" value="1024000">
          <input type="file" name="fichier[]" id="upload" multiple="multiple"/><br/><br>
          <input type="submit" name="envoyer" value="Valider">
      </form><br>
    </div>
    <br><br><br>

   <div class="container">
     <h2>Images uploadées</h2><br>
      <div class="row">

          <?php

          if(isset($_POST['delete']))
          {
            $fileToDelete = "images/" .$_POST['filename'];
            if (file_exists($fileToDelete)) {
              unlink($fileToDelete);
            }
          }

            $content_dir = 'images/';
            $fichierDossier = scandir($content_dir);

              for($i = 2; $i < count($fichierDossier); $i++) {

                ?>

                  <div class=" col-md-3">
                      <div class="thumbnail">
                          <?=  '<img src="'.$content_dir.'/'.$fichierDossier[$i].'" style="max-height: 200px;">' ?>
                          <div class="caption">
                              <p>upload/<?= $fichierDossier[$i]; ?></p>
                              <form action="formulaire.php" method="post">
                                  <input type="hidden" name="filename" value="<?= $fichierDossier[$i] ?>">
                                  <input type="submit" name="delete" value="Delete">
                              </form>
                          </div>
                      </div>
                  </div>
              <?php
              }
              ?>

      </div>
   </div>

  </body>
</html>
