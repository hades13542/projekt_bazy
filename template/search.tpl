
<?php
    echo $cos;
?>
<div id="szukaj">
    <form>
        <input type="text" id="name" name="name" />
        <input type="button" value="Szukaj" onclick="search()" />
        <p id="response"></p>
    </form>
</div>
<div id="ocena">
    <form>
        <input type="text" id="ocena" name="ocena" />
        <input type="button" value="Oceń!" onclick="ocena_change()" />
        <p id="response"></p>
    </form>
</div>
