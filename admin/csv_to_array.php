<?php

if ($_FILES["file"]["error"] > 0) {
  echo "Error: " . $_FILES["file"]["error"] . "<br>";
} else {

    echo "Upload: " . $_FILES["file"]["name"] . "<br>";
    echo "Type: " . $_FILES["file"]["type"] . "<br>";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
    echo "Stored in: " . $_FILES["file"]["tmp_name"]. "<br>";

    $users = array();

    $labels = array('id', 'name', 'age');

    $fh = fopen ($_FILES["file"]["tmp_name"], 'r');
    fgetcsv($fh);

    if ($fh) {
        while (!feof($fh)) {
            $row = fgetcsv($fh, 500, ';');
            $tempRow = array();
            if (isset($row) && is_array($row) && count($row)>0) {
                foreach ($row as $key => $value) {
                    $tempRow[$labels[$key ]] = $value;
                }
                $users[] = $tempRow;
            }
        }
        fclose($fh);
        $numLines = count($users);
    }

    // I want this to be displayed in index.html :
    echo $numLines;
    echo '<table style="border: 1px solid black;">';
    echo '<tr>';
    echo '<td>ID</td>';
    echo '</tr>';
    for ($x=0; $x<$numLines; $x++) {
        echo '<tr>';
        echo '<td>'.$users[$x]['id'].'</td>';
        echo '</tr>';
    }
    echo '</table>';

}

?>