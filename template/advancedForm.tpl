<form>
    <table>
        <tr><td><label for="nazwa">Nazwa gry:</label></td>
            <td><input value="<?php if(isset($formData)) echo $formData['nazwa']; ?>" type="text" id="nazwa" name="nazwa" /></td></tr>

        <tr><td><label for="data_wydania">Data wydania:</label></td>
            <td><input value="<?php if(isset($formData)) echo $formData['data_wydania']; ?>" type="date" id="data_wydania" name="data_wydania" /></td></tr>

        <tr><td><label for="opis">Krótki opis gry:</label></td>
            <td><input value="<?php if(isset($formData)) echo $formData['opis']; ?>" type="text" id="opis" name="opis" /></td></tr>

        <tr><td><label for="ocena">Ocena gry (0-10):</label></td>
            <td><input value="<?php if(isset($formData)) echo $formData['ocena']; ?>" type="text" id="ocena" name="ocena" /></td></tr>

        <tr><td><label for="multiplayer">Multiplayer:</label></td>
            <td><input type="checkbox" id="multiplayer" name="multiplayer"></td></tr>

        <tr><td><label for="producent">Producent:</label></td>
            <td><input value="<?php if(isset($formData)) echo $formData['producent']; ?>" type="text" id="producent" name="producent" /></td></tr>

        <tr><td><label for="wydawca">Wydawca:</label></td>
            <td><input value="<?php if(isset($formData)) echo $formData['wydawca']; ?>" type="text" id="wydawca" name="wydawca" /></td></tr>

        <tr><td><label for="wydawca_pl">Wydawca w Polsce:</label></td>
            <td><input value="<?php if(isset($formData)) echo $formData['wydawca_pl']; ?>" type="text" id="wydawca_pl" name="wydawca_pl" /></td></tr>
    </table>
    <br>Wybierz kategorie:<br><br>
<?php
    foreach ($kat as $row) {
        echo '<input type="checkbox" class="kat" value="'.$row['idkategoria'].'" />' .$row['nazwa'].'<br>';
    }
?>
    Wybierz platformy:<br>
    <?php
    foreach ($platformy as $row) {
        echo '<input type="checkbox" class="plat" value="'.$row['idplatforma'].'" />' .$row['nazwa'].'<br>';
    }
    ?>
    <br>
    <tr><td><span id="data"><input type="button" value="Zapisz" onclick="fn_saveAdvanced()" /></span></td>
        <td><span id="response"></span></td></tr>
</form>
<div id="kolejny"><input type="button" value="Dodaj Kolejny" onclick="handleButtonKolejny()" /></div>