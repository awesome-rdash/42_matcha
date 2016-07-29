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
		<div id="comments">
			<?php
			foreach($comments as $element) {
				$comment = new Comment(0);
				$comment->hydrate($element);
				?>
				<p class="comment"><?php echo $comment->getContent();?></p>
				<?php
			}

			if (isUserLogged()) {
			?>
				<input type="text" id="comment_content" maxlength="255" ><button id="comment">Comment</button>
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

			    ajax.onreadystatechange = function() {
			        if (ajax.readyState == 4 && ajax.status == 200) {
			            console.log(ajax.responseText);
			        }
			    }

			    var formData = new FormData();
		        formData.append('id_picture', <?php echo $pic->getId();?>);
		        if (like == false) {
			        formData.append('content', document.getElementById('comment_content').value);
			        formData.append('action', "comment_picture");
			    } else {
			    	formData.append('action', "like_picture");
			    }

			    ajax.open("POST", "action.php", true);
			    ajax.send(formData);
			    
			    return ajax;
			}

			document.getElementById('comment').addEventListener('click', function() {
    				comment(false);
				}, false);
		</script>
	</body>
</html>