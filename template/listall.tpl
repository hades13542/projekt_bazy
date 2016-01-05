<table border="1">
    <tr><td>ID</td><td>NAZWA</td></tr>
    <?php
        if ($data) {
            foreach ($data as $row) {
                echo '<tr><td>'. $row['idtable_01'] .'</td><td>'.$row['name'].'</td></tr>';
            }
        }
    ?>
</table>