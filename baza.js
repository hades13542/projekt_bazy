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

//zapisywanie kategorii
function fn_saveKategorie(){
    var kategoria = document.getElementById("kategoria").value;
    document.getElementById("kategoria").style.display = "none";
        var json_data = "{\"nazwa\":\"" + kategoria + "\"}";
        var msg = "data=" + encodeURIComponent(json_data);
        var url = "index.php?sub=baza&action=saveKategotrie";
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

