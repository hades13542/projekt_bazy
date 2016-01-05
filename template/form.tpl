<form name="form">
    <table>
        <tr><td><label for="idtable_01">idtable:</label></td>
            <td><input value="<?php if(isset($formData)) echo $formData['idtable_01']; ?>" type="text" id="idtable_01" name="idtable_01" /></td></tr>

        <tr><td><label for="name">name:</label></td>
            <td><input value="<?php if(isset($formData)) echo $formData['name']; ?>" type="text" id="name" name="name" /></td></tr>

        <tr><td><span id="data"><input type="button" value="Zapisz" onclick="fn_save()" /></span></td>
            <td><span id="response"></span></td></tr>
    </table>
</form>
