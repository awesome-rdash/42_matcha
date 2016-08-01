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
            var id_image = ajax.responseText;

            if (id_image == "error" || Number.isInteger(parseInt(id_image)) != true) {
                alert("Erreur. Le fichier doit etre une image PNG ou JPEG valide.");
            }
            else {
                var container = document.createElement("DIV");
                container.className = "ppic";

                var image_link = document.createElement("A");
                image_link.setAttribute("href", "picture.php?pic=" + id_image);
                container.appendChild(image_link);

                var image = document.createElement("IMG");
                image.className = "ppic_image";
                image.src = "data/userpics/" + id_image + ".jpeg";
                image_link.appendChild(image);

                var c_div = document.getElementById("previous_pics");
                c_div.insertBefore(container, c_div.firstChild);
            }
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

function upload_filter()
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
            var id_filter = ajax.responseText;
            if (id_filter == "error" || Number.isInteger(parseInt(id_filter)) != true) {
                alert("Erreur. Le fichier doit etre une image .png valide.");
            }
            else {
                var link = document.createElement("A");
                link.setAttribute("onclick", "selectFilter(" + id_filter + ")");
                link.href = "#";

                var container = document.createElement("DIV");
                container.className = "filter";
                container.id = "filter-" + id_filter;
                link.appendChild(container);

                var image = document.createElement("IMG");
                image.className = "filter_image";
                image.src = "data/userfilters/" + id_filter + ".png";
                container.appendChild(image);

                var c_div = document.getElementById("filters");
                c_div.insertBefore(link, c_div.firstChild);
            }
        }
    }

    var formData = new FormData();
    formData.append('action', "upload_filter");
    formData.append('filter_file', filter_file.files[0]);

    ajax.open('post', "action.php", true);
    ajax.send(formData);

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
    } else {
        document.getElementById("take").disabled = false;
        if (document.getElementById("image_file").value != "" ) {
            document.getElementById("upload").disabled = false;
        }
    }
    document.getElementById('filter-' + id).className = "filter selected";
    document.getElementById('preview').src="data/userfilters/" + id + ".png";
    currentFilter = id;
}

</script>

<div id="page">
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
            <a onclick="selectFilter(<?php echo $filter->getId();?>)" href="#"><div class="filter" id="filter-<?php echo $filter->getId();?>">
                <img src="data/userfilters/<?php echo $filter->getId();?>.png" class="filter_image" />
            </div></a>
        <?php
        }
        ?>
        
    </div>
    <div id="upload_filter">
            <h1>Uploader votre filtre</h1>
            <p>Seul les fichiers PNG sont acceptes. Pour le meilleur rendu possible, utilisez une image de 1280x720px avec transparence.</p>
            <input type="file" id="filter_file">
            <button id="upload_filter_button" disabled onclick="upload_filter()">Upload filter</button><br />
        </div>
    <div id="upload_picture">
        <h1>Prendre la photo</h1>
        <button id="take" onclick="takeCamera()" disabled>Utiliser la webcam</button><br />

        <div id="upload_file">
        <h2>Envoyer un fichier</h2>
            <input type="file" id="image_file">
            <button id="upload" onclick="upload_picture(false, image_file)" disabled>Utiliser le fichier</button><br />
        </div>
    </div>
</div>

<section id="previous_pics">
    <?php
    foreach($lastPictures as $element) {
        $picture = new UserPicture(0);
        $picture->hydrate($element);
        ?>
        <div class="ppic" id="picture-<?php echo $picture->getId();?>">
            <a href="picture.php?pic=<?php echo $picture->getId(); ?>"><img src="data/userpics/<?php echo $picture->getId(); ?>.jpeg" class="ppic_image" /></a>
        </div>
    <?php
    }
    ?>
</section>
</div>

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

    document.getElementById("filter_file").onchange = function() {
        document.getElementById("upload_filter_button").disabled = false;
    };

    document.getElementById('image_file').onchange = function() {
        if (currentFilter != 0) {
            document.getElementById("upload").disabled = false;

        }
    };
</script>