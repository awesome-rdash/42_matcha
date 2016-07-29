<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $pageTitle; ?></title>
		<meta charset="utf-8">
		<?php
			foreach($pageStylesheets as $cssPage) {
				echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"assets/css/" . $cssPage . "\">";
			}
		?>
	</head>
	<body>
		<?php 
			include("view/header.view.php");
		?>
		<div id="picture">
			<img src="data/userpics/<?php echo $pic->getId();?>.jpeg" class="userpicture" />
		</div>
		<p id="likeCounter"><?php echo $likeManager->getCountFromPicture($pic->getId()); ?> likes</p>
		<?php if (isUserLogged()) { ?><button id="like"><?php if ($likeManager->ifUserLikePicture($currentUser->getId(), $pic->getId())) { ?>Dislike<?php } else { ?>Like<?php } ?></button>
		<?php } ?>
		<div id="comments">
			<?php
			if (isUserLogged()) {
			?>
				<input type="text" id="comment_content" maxlength="255" ><button id="comment">Comment</button>
			<?php
			}
			foreach($comments as $element) {
				$comment = new Comment(0);
				$comment->hydrate($element);
				?>
				<p class="comment"><?php echo $comment->getContent();?></p>
				<?php
			}
			?>
		</div>
		<script>
			function comment(like)
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

			    var formData = new FormData();
		        formData.append('id_picture', <?php echo $pic->getId();?>);
		        if (like == false) {
			        formData.append('content', document.getElementById('comment_content').value);
			        formData.append('action', "comment_picture");

			        ajax.onreadystatechange = function() {
				        if (ajax.readyState == 4 && ajax.status == 200) {
						var newItem = document.createElement("P");
						newItem.className = "comment";
						newItem.appendChild(document.createTextNode(ajax.responseText));

						var c_div = document.getElementById("comments");
						c_div.appendChild(newItem, c_div.childNodes[0]);
				        }
				    }

			    } else {
			    	formData.append('action', "like_picture");

				    ajax.onreadystatechange = function() {
				        if (ajax.readyState == 4 && ajax.status == 200) {
				            document.getElementById("likeCounter").innerHTML = ajax.responseText + " likes";
				            if (document.getElementById("like").innerHTML == "Like") {
				            	document.getElementById("like").innerHTML = "Dislike"
				            } else {
				            	document.getElementById("like").innerHTML = "Like"
				            }
				        }
				    }

			    }

			    ajax.open("POST", "action.php", true);
			    ajax.send(formData);
			    
			    return ajax;
			}

			document.getElementById('comment').addEventListener('click', function() {
    				comment(false);
				}, false);
			document.getElementById('like').addEventListener('click', function() {
    				comment(true);
				}, false);
		</script>
	</body>
</html>