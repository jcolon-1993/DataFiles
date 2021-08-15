<!DOCTYPE html>
<html>
  <head>
    <title>Data Files</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
  </head>
  <body>
    <h2>Guitar Wars - High Scores</h2>
    <p>Welcome, Guitar Warrior, do you have what it takes to crack the high score
       list? If so, just <a href="addscore.php">add your own score</a>.</p>
       <hr />
     <?php
        require_once('connectvars.php');
        require_once('appvars.php');

        // Connect to the database
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        // Retrieve the score data from mySQL
        $query = "SELECT * FROM guitarwars ORDER BY score DESC";
        $data = mysqli_query($dbc, $query);

        $i = 0;
        // Loop through the array of score data, formatting it as html
        echo "<table>";
        while ($row = mysqli_fetch_array($data))
        {
          if ($i == 0)
          {
            echo '<tr><td colspan="2" class="topscoreheader">Top Score:' .
            $row['score'] . '</td></tr>';
          }
          // Display the score data
          echo '<tr><td class="scoreinfo">';
          echo '<span class="score">' . $row['score'] . '</span><br />';
          echo '<strong>Name: </strong>' . $row['name'] . '<br />';
          echo '<strong>Date: </strong>' . $row['date'] . '</td></tr>';
          // Validation for file upload
          if (is_file(GW_UPLOADPATH . $row['screenshot']) && filesize(GW_UPLOADPATH . $row['screenshot']) > 0)
          {
            echo '<td><img src="' . GW_UPLOADPATH . $row["screenshot"]. '" alt="score image" /></td></tr>';
          }
          else
          {
            echo '<td><img src="' . GW_UPLOADPATH . 'unverified.gif" alt="Unverified score"></td></tr>';
          }
          $i++;
        }
        echo "</table>";

        mysqli_close($dbc);
     ?>
  </body>
</html>
