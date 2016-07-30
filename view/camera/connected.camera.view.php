<script>
function upload_picture(webcam, data)
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
        ajax.send("action=upload_camera_image&filter=" + currentFilter + "&data=" + data);
    }
    else {
        var formData = new FormData();
        formData.append('filter', currentFilter);
        formData.append('action', "upload_file_image");
        formData.append('image_file', image_file.files[0]);

        ajax.open('post', "action.php", true);
        ajax.send(formData);
    }
    return ajax;

}

function takeCamera(){
    var canvas = document.getElementById('canvas');
    canvas.width = videoElement.videoWidth;
    canvas.height = videoElement.videoHeight;
    canvas.getContext('2d').drawImage(video, 0, 0);
    var data = canvas.toDataURL('image/jpeg');
    upload_picture(true, encodeURIComponent(data));

}

var currentFilter = 0;

function selectFilter(id) {
    if (currentFilter != 0) {
        document.getElementById('filter-' + currentFilter).className = "filter";
    }
    document.getElementById('filter-' + id).className = "filter selected";
    document.getElementById('preview').src="data/userfilters/" + id + ".png";
    currentFilter = id;
}

</script>


<div id="upload_box">
    <div id="camera_box">
        <div id="video_container">
            <img id="preview" />
            <video autoplay="true" id="videoElement">
            </video>
        </div>

        <canvas id="canvas" style="display:none;"></canvas>
    </div>
    <div id="filters">
        <?php
        foreach($filters as $element) {
            $filter = new Filter(0);
            $filter->hydrate($element);
            ?>
            <div class="filter" id="filter-<?php echo $filter->getId();?>">
                <a onclick="selectFilter(<?php echo $filter->getId();?>)" href="#"><img src="data/userfilters/<?php echo $filter->getId();?>.png" class="filter_image" /></a>
            </div>
        <?php
        }
        ?>
    </div>
    <button id="take" onclick="takeCamera()">Take a photo</button><br />

    <div id="upload_file">
        <input type="file" id="image_file">
        <button id="upload" onclick="upload_picture(false, image_file)">Upload picture</button><br />
    </div>
</div>

<section id="previous_pics">
    
</section>

<script>
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
</script>