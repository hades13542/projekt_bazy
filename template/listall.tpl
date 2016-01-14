<table border="1">
    <tr><td>NAZWA</td><td>Data Wydania</td><td>Opis</td><td>Ocena</td><td>Multiplayer</td></tr>
    <?php
        if ($data) {
            foreach ($data as $row) {
                if ($row['multiplayer'] == f){
                    $row['multiplayer'] = "NIE";
                }else{
                    $row['multiplayer'] = "TAK";
                }
                echo '<tr><td>'.$row['nazwa'].'</td><td>'.$row['data_wydania'].'</td><td>'.$row['opis'].'</td><td>'. round($row['ocena'],2) .'</td><td>'.$row['multiplayer'].'</td></tr>';
            }
        }
    ?>
</table>