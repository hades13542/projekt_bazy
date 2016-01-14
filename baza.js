/**
 * Created by atar1x on 05.01.16.
 */
function fn_save() {
    var fname = document.getElementById("idtable_01").value;
    var lname = document.getElementById("name").value;
    document.getElementById("data").style.display = "none";
    var json_data = "{\"idtable_01\":\"" + fname + "\",\"name\":\"" + lname + "\"}";
    var msg = "data=" + encodeURIComponent(json_data);
    var url = "index.php?sub=baza&action=saveRec";
    resp = function (response) {
        // alert ( response ) ;
        document.getElementById("response").innerHTML = response;
    }
    xmlhttpPost(url,msg,resp);
}
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
//zapisywanie kategorii
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

function handleButtonKolejny(){
    location.reload();
}
function checkSimple(ocena){

    var is_ocena = /[1-9]|10/;
    var flag = 1;
    if(!is_ocena.test(ocena)){
        flag=0;
    }
    return flag;
}

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

function search(){
    var szukane = document.getElementById("name").value;
    var json_data = "{\"nazwa\":\"" + szukane + "\"}";
    var msg = "data=" + encodeURIComponent(json_data);
    var url = "index.php?sub=baza&action=searchFunc";
    resp = function (response) {
        document.getElementById("response").innerHTML = response;
    }
    console.log(json_data);
    xmlhttpPost(url, msg, resp);
    document.getElementById("ocena_div").style.display = "block";
    document.getElementById("szukaj").style.display = "none";
}

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

