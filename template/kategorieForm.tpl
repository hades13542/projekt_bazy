<form name="form">
    <table>
        <tr><td><label for="kategoria">Podaj nazwę kategorii:</label></td>
            <td><input value="<?php if(isset($formData)) echo $formData['kategoria']; ?>" type="text" id="kategoria" name="kategoria" /></td></tr>

        <tr><td><span id="data"><input type="button" value="Zapisz" onclick="fn_saveKategorie()" /></span></td>
            <td><span id="response"></span></td></tr>
    </table>
</form>
<div id="kolejny"><input type="button" value="Dodaj Kolejny" onclick="handleButtonKolejny()" /></div>