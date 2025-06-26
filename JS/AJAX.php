<!DOCTYPE html>
<html>

    <head>
        <link rel="shortcut icon" href="" type="image/x-icon">
        <title>My First AJAX</title>
    </head>

    <body>
        <h2>The XMLHttpRequest Object</h2>
        <h3>Send a Request</h3>
        <p>To send a request to a server, you can use the open() and send() methods of the XMLHttpRequest object:</p>
        <div id="demo">
            <p>Let AJAX change this text.</p>
            <button type="button" onclick="loadDoc()">Change Content</button>
        </div>
        
        <script>
            function loadDoc() {
                const xhttp = new XMLHttpRequest();
                xhttp.onload = function () {
                    document.getElementById("demo").innerHTML = this.responseText;
                }
                xhttp.open("GET", "ajax_info.txt");
                xhttp.send();
            }
        </script>
     

     
    <div id="demo1">
        <h3>The onreadystatechange function is called every time the readyState changes.</h3>
        
        <p>When readyState is 4 and status is 200, the response is ready:</p>
        <button type="button" onclick="loadDoc1()">Change Content</button>
    </div>
    
    <script>
        function loadDoc1() {
            const xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("demo1").innerHTML =
                        this.responseText;
                }
            };
            xhttp.open("GET", "ajax_info.txt");
            xhttp.send();
        }
    </script>

<h3>AJAX XML Example</h3>
<p>The following example will demonstrate how a web page can fetch information from an XML file with AJAX:</p>

<button type="button" onclick="loadxml()">Get my CD collection</button>
<br><br>
<table id="demo2"></table>

<script>
    function loadxml() {
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function () {
            myFunction(this);
        }
        xhttp.open("GET", "cd_catalog.xml");
        xhttp.send();
    }
    function myFunction(xml) {
        const xmlDoc = xml.responseXML;
        const x = xmlDoc.getElementsByTagName("CD");
        let table = "<tr><th>Artist</th><th>Title</th></tr>";
        for (let i = 0; i < x.length; i++) {
            table += "<tr><td>" +
                x[i].getElementsByTagName("ARTIST")[0].childNodes[0].nodeValue +
                "</td><td>" +
                x[i].getElementsByTagName("TITLE")[0].childNodes[0].nodeValue +
                "</td></tr>";
        }
        document.getElementById("demo2").innerHTML = table;
    }
</script>


<h3>AJAX PHP Example</h3>

<p>The following example demonstrates how a web page can communicate with a web server while a user types characters in an
input field:</p>

<h3>Start typing a name in the input field below:</h3>

<p>Suggestions: <span id="txtHint"></span></p>
<p>First name: <input type="text" id="txt1" onkeyup="showHint(this.value)"></p>

<script>
    function showHint(str) {
        if (str.length == 0) {
            document.getElementById("txtHint").innerHTML = "";
            return;
        }
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function () {
            document.getElementById("txtHint").innerHTML =
                this.responseText;
        }
        xhttp.open("GET", "gethint.php?q=" + str);
        xhttp.send();
    }
</script>







    </body>

</html>

</html>