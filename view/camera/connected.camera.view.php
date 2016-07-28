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

<input type="file" id="image_file">
<button id="upload">Upload picture</button><br />

<script>
function upload(webcam, data)
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

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            //console.log(ajax.responseText);
        }
    }

    if (webcam == true) {
        ajax.open("POST", "action.php", true);
        ajax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        ajax.send("action=upload_camera_image&filter=" + 1 + "&data=" + data);
    }
    else {
        var formData = new FormData();
        formData.append('filter', 1);
        formData.append('action', "upload_file_image");
        formData.append('image_file', image_file.files[0]);

        ajax.open('post', "action.php", true);
        ajax.send(formData);
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
        var data = canvas.toDataURL('image/jpeg');
        upload(true, encodeURIComponent(data));
    }
}, false);

document.getElementById('upload').addEventListener('click', function(){
    upload(false, image_file);
}, false);

</script>