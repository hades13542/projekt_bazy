<form name="form">
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

        <tr><td><span id="data"><input type="button" value="Zapisz" onclick="fn_saveSimple()" /></span></td>
            <td><span id="response"></span></td></tr>
    </table>
</form>
<div id="kolejny"><input type="button" value="Dodaj Kolejny" onclick="handleButtonKolejny()" /></div>
