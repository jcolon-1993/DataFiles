<!DOCTYPE html>
<html>
  <head>
    <title>Data Files</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
  </head>
  <body>
     <?php
     // Define the upload path and maximum file constant.
     require_once('connectvars.php');
     require_once('appvars.php');
       if (isset($_POST['submit']))
       {
         // Grab the score data from POST
         $name = $_POST['name'];
         $score = $_POST['score'];
         $screenshot = $_FILES['screenshot']['name'];
         $screenshot_type = $_FILES['screenshot']['type'];
         $screenshot_size = $_FILES['screenshot']['size'];

         // Validaton for file type
         if (!empty($name) && (!empty($score)) && (!empty($screenshot)))
         {
           if (($screenshot_type == 'image/gif') || ($screenshot_type == 'image/jpeg') ||
           ($screenshot_type == 'image/pjpeg') || ($screenshot_type == 'image/png')
           && ($screenshot_size > 0) && ($screenshot_size <= GW_MAXFILESIZE))
           {
             if ($_FILES['screenshot']['error'] == 0)
             {
             // Move the file to the target upload folder
             $target = GW_UPLOADPATH . time() . $screenshot;
             // Connect to the database
             $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

             // Write the data to the database
             $query = "INSERT INTO guitarwars VALUE (0, NOW(), '$name', '$score', '$screenshot')";
             mysqli_query($dbc, $query);

             // Confirm success with the user
             echo '<p>Thanks for adding your high score!</p>';
             echo '<p><strong>Name:</strong>' . $name . '<br />';
             echo '<strong>Score:</strong>' . $score . '</p>';
             echo '<img src="' . GW_UPLOADPATH . $screenshot . '" alt="Score image" /></p>';
             echo '<p><a href="index.php">&lt;&lt; Back to high scores</a></p>';
             // Clear the score data to clear the form
             $name= "";
             $score = "";
             $screenshot = "";

             mysqli_close($dbc);
         }
         else
         {
           echo '<p class="error">Sorry, there was a probelm uploading your screen shot image.</p>';
         }
       }
     }
     else
     {
       echo '<p class="error">The screen shot must be a GIF, JPEG, PNG image file no ' .
       'greater than ' . (GM_MAXFILESIZE / 1024) . 'KB in size.</p>';
     }

     // Try to delete the temporary screen shot image file
     @unlink($_FILES['screenshot'['tmp_name']]);
   }
         else
         {
           echo '<p class="error">Please enter all of the information to add ' .
           'your high score.</p>';
         }

     ?>

     <hr />
     <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
       <input type="hidden" name="MAX_FILES_SIZE" value="<?php echo GW_MAXFILESIZE; ?>">
       <label for="name">Name:</label>
       <input type="text" id="name" name="name" value="<?php if (!empty($name)) echo $name ?>">
       <br />
       <label for="score">Score:</label>
       <input type="text" id="score" name="score" value="<?php if (!empty($score)) echo $score ?>">
       <br />
       <label for="screenshot">Screen shot:</label>
       <input type="file" id="screenshot" name="screenshot" />
       <hr />
       <input type="submit" value="Add" name="submit" />
     </form>
  </body>
</html>
