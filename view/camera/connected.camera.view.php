<?php include("view/header/connected.header.view.php"); ?>
<style>
#container {
    margin: 0px auto;
    width: 500px;
    height: 375px;
    border: 10px #333 solid;
}
#videoElement {
    width: 500px;
    height: 375px;
    background-color: #666;
}
</style>

<div id="container">
    <video autoplay="true" id="videoElement">
     
    </video>
</div>

<canvas id="canvas" style="display:none;"></canvas>


<button id="take">Take a photo</button><br />
<img src="" id="photo" alt="photo">

<p id="test"></p>

<script>
function ajax(elementID,filename,str,post)
{
    var ajax;
    if (window.XMLHttpRequest) {
        ajax = new XMLHttpRequest();
    }
    else if (ActiveXObject("Microsoft.XMLHTTP")) {
        ajax = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (ActiveXObject("Msxml2.XMLHTTP")) {
        ajax = new ActiveXObject("Msxml2.XMLHTTP");
    }
    else {
        alert("Il semble que votre navigateur ne supporte pas AJAX. :(");
        return false;
    }
    ajax.onreadystatechange=function() {
        if (ajax.readyState==4&&ajax.status==200) {
            document.getElementById(elementID).innerHTML=ajax.responseText;
        }
    }
    if (post==false) {
        ajax.open("GET",filename+str,true);
        ajax.send(null);
    }
    else {
        ajax.open("POST",filename,true);
        ajax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        ajax.send(str);
    }
    return ajax;
}

var video = document.querySelector("#videoElement");
 
navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia || navigator.oGetUserMedia;
 
if (navigator.getUserMedia) {       
    navigator.getUserMedia({video: true}, handleVideo, videoError);
}
 
function handleVideo(stream) {
    video.src = window.URL.createObjectURL(stream);
}
 
function videoError(e) {
}

document.getElementById('take').addEventListener('click', function(){
    if (video){
        var canvas = document.getElementById('canvas');
        canvas.width = videoElement.videoWidth;
        canvas.height = videoElement.videoHeight;
        canvas.getContext('2d').drawImage(video, 0, 0);
        var data = canvas.toDataURL('image/webp');
        document.getElementById('photo').setAttribute('src', data);
        ajax("test", "action.php", "action=upload_camera_image&image="+data, true);
    }
}, false);

</script>