<br>
<?php
    echo $cos;
?>
<div id="szukaj">
    <form>
        <input type="text" id="name" name="name" />
        <input type="button" value="Szukaj" onclick="search()" />
    </form>
</div>
<p id="response"></p>
<div id="ocena_div">
    <form>
        <input type="text" id="ocena" name="ocena" />
        <input type="button" value="Oceń!" onclick="ocena_change()" />
    </form>
</div>
<p id="response_ocena"></p>
