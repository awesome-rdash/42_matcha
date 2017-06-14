<div id="chatMainWindow">
	<?php
	if (isset($currentProfile)) {
		include("view/chat/messages.chat.view.php");
	} else {
		include("view/chat/userlist.chat.view.php");
	}
	?>
</div>