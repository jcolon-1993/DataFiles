<?php
  require_once('appvars.php');
  require_once('connectvars.php');

  // Connect to the database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  // retrieve the score data from MYSQL
  $query = "SELECT * FROM guitarwars ORDER BY score DESC, date ASC";
  $data = mysqli_query($dbc, $query);

  // Loop through the array of score data, formatting is as html
  echo '<table>';
  while ($row = mysqli_fetch_array($data))
  {
    echo '<tr class="scorerow"><td><strong>' . $row['name'] . '</strong></td>';
    echo '<td>' . $row['date'] . '</td>';
    echo '<td>' . $row['score'] . '</td>';
    echo '<td><a href="removescore.php?id=' . $row['id'] . '&amp;date=' . $row['date'] .
          '&amp;name=' . $row['name'] . '&amp;score=' . $row['score'] .  '&amp;screenshot=' .
          $row['screenshot'] . '">Remove</a></td></tr>';
  }
  echo '</table>';

  mysqli_close($dbc);

?>
