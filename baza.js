/**
 * Created by atar1x on 05.01.16.
 */

//Wszystkie funkcje służą do komunikacji pomiędzy Widokiem a bazą.
//90% z nich to dokładnie to samo, różnią się tylko danymi przekazanymi z formularza (jako JSON)

//Zapisywanie do prostego dodawania
function fn_saveSimple(){
    var nazwa = document.getElementById("nazwa").value;
    var data_wydania = document.getElementById("data_wydania").value;
    var opis = document.getElementById("opis").value;
    var ocena = document.getElementById("ocena").value;
    var multiplayer = document.getElementById("multiplayer").checked;
    document.getElementById("data").style.display = "none";
    var flag = checkSimple(ocena);
    if (flag) {
        var json_data = "{\"nazwa\":\"" + nazwa + "\",\"data_wydania\":\"" + data_wydania + "\",\"opis\":\"" + opis + "\",\"ocena\":\"" + ocena + "\",\"multiplayer\":\"" + multiplayer + "\"}";
        var msg = "data=" + encodeURIComponent(json_data);
        var url = "index.php?sub=baza&action=saveSimple";
        resp = function (response) {
            document.getElementById("response").innerHTML = response;
        }
        console.log(json_data);
        xmlhttpPost(url, msg, resp);
        document.getElementById("kolejny").style.display = "block";
    }else{
        document.getElementById("response").innerHTML = "Czekaj";
        alert("Błednie podane dane!");
        location.reload();

    }
}
//Zapisywanie do platformy
function fn_savePlatformy(){
    var nazwa = document.getElementById("nazwa").value;
    var producent = document.getElementById("producent").value;
    document.getElementById("data").style.display = "none";
    var json_data = "{\"nazwa\":\"" + nazwa + "\",\"producent\":\"" + producent + "\"}";
    var msg = "data=" + encodeURIComponent(json_data);
    var url = "index.php?sub=baza&action=savePlatformy";
    resp = function (response) {
        document.getElementById("response").innerHTML = response;
    }
    console.log(json_data);
    xmlhttpPost(url, msg, resp);
	document.getElementById("kolejny").style.display = "block";
}
//Zapisywanie do zaawansowanego dodawania
function fn_saveAdvanced(){
    var array1 = [];
    var array2 = [];
    //console.log($('.kat')[0]);
    $('.kat:checked').each(function (){
        array1.push(this.value);
    });
    $('.plat:checked').each(function (){
        array2.push(this.value);
    });

    var nazwa = document.getElementById("nazwa").value;
    var data_wydania = document.getElementById("data_wydania").value;
    var opis = document.getElementById("opis").value;
    var ocena = document.getElementById("ocena").value;
    var multiplayer = document.getElementById("multiplayer").checked;
    var producent = document.getElementById("producent").value;
    var wydawca = document.getElementById("wydawca").value;
    var wydawca_pl = document.getElementById("wydawca_pl").value;
    var kategorie = array1.toString();
    var platformy = array2.toString();
    document.getElementById("data").style.display = "none";
    var flag = checkSimple(ocena);
    if (flag) {
        var json_data = "{\"nazwa\":\"" + nazwa + "\",\"data_wydania\":\"" + data_wydania + "\",\"opis\":\"" + opis + "\",\"ocena\":\"" + ocena + "\",\"multiplayer\":\"" + multiplayer + "\",\"producent\":\"" + producent + "\",\"wydawca\":\"" + wydawca + "\",\"wydawca_pl\":\"" + wydawca_pl + "\",\"kategorie\":\"" + kategorie + "\",\"platformy\":\"" + platformy + "\"}";
        var msg = "data=" + encodeURIComponent(json_data);
        var url = "index.php?sub=baza&action=saveAdvanced";
        resp = function (response) {
            document.getElementById("response").innerHTML = response;
        }
        console.log(json_data);
        xmlhttpPost(url, msg, resp);
        document.getElementById("kolejny").style.display = "block";
    }else{
        document.getElementById("response").innerHTML = "Czekaj";
        alert("Błednie podane dane!");
        location.reload();

    }
}
//Zapisywanie do kategorii
function fn_saveKategorie(){
    var kategoria = document.getElementById("kategoria").value;
        var json_data = "{\"nazwa\":\"" + kategoria + "\"}";
        var msg = "data=" + encodeURIComponent(json_data);
        var url = "index.php?sub=baza&action=saveKategorie";
        document.getElementById("data").style.display = "none";
        resp = function (response) {
            document.getElementById("response").innerHTML = response;
        }
        console.log(json_data);
        xmlhttpPost(url, msg, resp);
        document.getElementById("kolejny").style.display = "block";
    }
//Wyswietlanie przycisku "DODAJ KOLEJNY"
function handleButtonKolejny(){
    location.reload();
}
//Funkcja sprawdzająca czy ocena jest z zakresu 0-10
function checkSimple(ocena){

    var is_ocena = /[1-9]|10/;
    var flag = 1;
    if(!is_ocena.test(ocena)){
        flag=0;
    }
    return flag;
}
//Funkcja obslugujaca zmianę oceny
function ocena_change(){
    var ocena = document.getElementById("ocena").value;
    var json_data = "{\"ocena\":\"" + ocena + "\"}";
    var msg = "data=" + encodeURIComponent(json_data);
    var url = "index.php?sub=baza&action=ocena_change";
    resp = function (response) {
        document.getElementById("response_ocena").innerHTML = response;
    }
    console.log(resp);
    xmlhttpPost(url, msg, resp);
}
//Wyszukiwanie gry w bazie
function search(){
    var szukane = document.getElementById("name").value;
    var json_data = "{\"nazwa\":\"" + szukane + "\"}";
    var msg = "data=" + encodeURIComponent(json_data);
    var url = "index.php?sub=baza&action=searchFunc";
    resp = function (response) {
        document.getElementById("response").innerHTML = response;
    }
    console.log(resp);
    xmlhttpPost(url, msg, resp);
    document.getElementById("ocena_div").style.display = "block";
    document.getElementById("szukaj").style.display = "none";
}
//Wyszukiwanie wg kategorii
function searchKat(){
    var szukane = document.getElementById("name").value;
    var json_data = "{\"nazwa\":\"" + szukane + "\"}";
    var msg = "data=" + encodeURIComponent(json_data);
    var url = "index.php?sub=baza&action=searchKategorie";
    resp = function (response) {
        document.getElementById("response").innerHTML = response;
    }
    console.log(resp);
    xmlhttpPost(url, msg, resp);

}
//Wyszukiwanie wg Platformy!
function searchPlat(){
    var szukane = document.getElementById("name").value;
    var json_data = "{\"nazwa\":\"" + szukane + "\"}";
    var msg = "data=" + encodeURIComponent(json_data);
    var url = "index.php?sub=baza&action=searchPlatformy";
    resp = function (response) {
        document.getElementById("response").innerHTML = response;
    }
    console.log(resp);
    xmlhttpPost(url, msg, resp);

}
//Wyszukiwanie wg Oceny
function searchOcena(){
    var szukane = document.getElementById("name").value;
    var json_data = "{\"nazwa\":\"" + szukane + "\"}";
    var msg = "data=" + encodeURIComponent(json_data);
    var url = "index.php?sub=baza&action=searchOceny";
    resp = function (response) {
        document.getElementById("response").innerHTML = response;
    }
    console.log(resp);
    xmlhttpPost(url, msg, resp);

}
//Usuwanie gry z bazy
function deleteGra(){
    var szukane = document.getElementById("name").value;
    var json_data = "{\"nazwa\":\"" + szukane + "\"}";
    var msg = "data=" + encodeURIComponent(json_data);
    var url = "index.php?sub=baza&action=deleteGry";
    resp = function (response) {
        document.getElementById("response").innerHTML = response;
    }
    console.log(resp);
    xmlhttpPost(url, msg, resp);

}
//Usuwanie kategorii z bazy
function deleteKat(){
    var szukane = document.getElementById("name").value;
    var json_data = "{\"nazwa\":\"" + szukane + "\"}";
    var msg = "data=" + encodeURIComponent(json_data);
    var url = "index.php?sub=baza&action=deleteKat";
    resp = function (response) {
        document.getElementById("response").innerHTML = response;
    }
    console.log(resp);
    xmlhttpPost(url, msg, resp);

}
//Usuwanie platformy z bazy
function deletePlat(){
    var szukane = document.getElementById("name").value;
    var json_data = "{\"nazwa\":\"" + szukane + "\"}";
    var msg = "data=" + encodeURIComponent(json_data);
    var url = "index.php?sub=baza&action=deletePlat";
    resp = function (response) {
        document.getElementById("response").innerHTML = response;
    }
    console.log(resp);
    xmlhttpPost(url, msg, resp);

}
//Funkcja do obsługi metody POST
function xmlhttpPost(strURL, mess, respFunc) {
    var self = this;
    // Mozilla/Safari
    if (window.XMLHttpRequest) {
        self.xmlHttpReq = new XMLHttpRequest();
    }
    // IE
    else if (window.ActiveXObject) {
        self.xmlHttpReq = new ActiveXObject("Microsoft.XMLHTTP");
    }
    self.xmlHttpReq.onreadystatechange = function() {
        if(self.xmlHttpReq.readyState == 4){
            if ( self.xmlHttpReq.status == 200 ) {
                respFunc( self.xmlHttpReq.responseText ) ;
            }
            else if ( self.xmlHttpReq.status == 401 ) {
                window.location.reload() ;
            }
        }
    }
    self.xmlHttpReq.open('POST', strURL);
    self.xmlHttpReq.setRequestHeader("X-Requested-With","XMLHttpRequest");
    self.xmlHttpReq.setRequestHeader("Content-Type","application/x-www-form-urlencoded; ");
    self.xmlHttpReq.setRequestHeader("Content-length", mess.length);
    self.xmlHttpReq.send(mess);
}