<form name="form">
    <table>
        <tr><td><label for="nazwa">Nazwa platformy:</label></td>
            <td><input value="<?php if(isset($formData)) echo $formData['nazwa']; ?>" type="text" id="nazwa" name="nazwa" /></td></tr>

        <tr><td><label for="producent">Producent platformy:</label></td>
            <td><input value="<?php if(isset($formData)) echo $formData['producent']; ?>" type="text" id="producent" name="producent" /></td></tr>

        <tr><td><span id="data"><input type="button" value="Zapisz" onclick="fn_savePlatformy()" /></span></td>
            <td><span id="response"></span></td></tr>
    </table>
</form>
<div id="kolejny"><input type="button" value="Dodaj Kolejny" onclick="handleButtonKolejny()" /></div>
