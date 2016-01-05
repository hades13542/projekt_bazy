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
    $.ajax({
        type: "POST",
        url: url,
        data: msg,
    }).done(function (response) {
        console.log("DZIAŁAM KURWA i wypisuję" + response);
        console.log(json_data);
    });
}
/*
function xmlhttpPost(strURL, mess, respFunc) {
    var xmlHttpReq = false;
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
            // alert ( self.xmlHttpReq.status ) ;
            if ( self.xmlHttpReq.status == 200 ) {
                // document.getElementById("data").innerHTML = http_request.responseText;
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

*/