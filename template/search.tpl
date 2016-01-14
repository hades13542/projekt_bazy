<br>

<div id="szukaj">
    <form>
        <input type="text" id="name" name="name" />
        <input type="button" value="Szukaj" onclick="search()" />
    </form>
</div>
<p id="response"></p>
<?php


//foreach ($odpowiedz as $row) {
//    foreach($row as $tekst)
//    echo $tekst;
//    echo '<br>';
 //   }
?>
<div id="ocena_div">
    <form>
	<?php
    	echo $cos;
	?>
        <input type="text" id="ocena" name="ocena" />
        <input type="button" value="Oceń!" onclick="ocena_change()" />
    </form>
</div>
<p id="response_ocena"></p>
