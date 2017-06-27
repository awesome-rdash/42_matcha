<?php
	$messageManager = new MessageManager($db);
	$messageList = $messageManager->getAllMessagesBetweenTwoUsers($currentProfile->getId(), $currentUser->getId());
?>

<script>

function sort_messages(a, b) {
   if (a["time"] < b["time"]) return -1;
   if (a["time"] > b["time"]) return 1;
   return 0;
 }

function reload_msg() {
	var ajax;

    if (window.XMLHttpRequest) {
        ajax = new XMLHttpRequest();
    } else {
        alert("Il semble que votre navigateur ne supporte pas AJAX. :(");
        return false;
    }

    var data = {};
    data["info"] = "messagesBetweenTwoUsers";
    data["fromUser"] = <?php echo $currentProfile->getId();?>;

    if (typeof reload_msg.lastCallTime == 'undefined') {
    	var d = new Date();
		var n = d.getTime();
    	reload_msg.lastCallTime = n;
        console.log("Initializing");
    }
    data["lastCallTime"] = reload_msg.lastCallTime;

    var formData = new FormData();
    str = JSON.stringify(data, null, 4);
    formData.append('action', "getNewMessagesBetweenTwoUsers");
    formData.append('data', JSON.stringify(data));
    ajax.open('post', "action.php", true);
    ajax.send(formData);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var reply = ajax.responseText;
            console.log(reply);
            var toShow = JSON.parse(reply);

            if (toShow['output'] == "ok") {
            	reload_msg.lastCallTime = toShow["time"];
            	var arrayContent = JSON.parse(toShow['messages']);
            	arrayContent.sort(sort_messages);

            	for (var i = 0, len = arrayContent.length; i < len; i++) {
	            	var div = document.createElement('div');
					div.id = 'msg' + arrayContent[i]['id'];
					div.className = 'msgInList';

					var p = document.createElement('p');
					p.innerHTML = "-> " + unescape(arrayContent[i]['content']);

					div.appendChild(p);
					document.getElementById('messageList').insertBefore(div, messageList.childNodes[0]);
            	}
            } else {
                alert(toShow["err_msg"]);
            }
        }
    }
    return ajax;
}

reload_msg();
setInterval(reload_msg, 5000);

function sendMessage() {
	var ajax;

    if (window.XMLHttpRequest) {
        ajax = new XMLHttpRequest();
    }
    else {
        alert("Il semble que votre navigateur ne supporte pas AJAX. :(");
        return false;
    }

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
        	var reply = ajax.responseText;
        	var out = JSON.parse(reply);
            console.log(out);

            if (out['output'] == "ok" && out['messageId'] != 0) {
            	var div = document.createElement('div');
				div.id = 'msg' + out['messageId'];
				div.className = 'msgInList';

				var p = document.createElement('p');
				p.innerHTML = "<- " + unescape(out['messageContent']);

				div.appendChild(p);
				document.getElementById('messageList').insertBefore(div, messageList.childNodes[0]);
				document.getElementById('SendMessageTextBox').value = "";
            } else {
            	alert("Erreur lors de l'envoi du message.");
            }
        }
    }

    var data = {};
    data['content'] = document.getElementById("SendMessageTextBox").value;
    data['toUser'] = <?php echo $currentProfile->getId();?>;

    var formData = new FormData();

    formData.append('action', "sendMessage");
    formData.append('data', JSON.stringify(data));
    ajax.open('post', "action.php", true);
    ajax.send(formData);

    return ajax;
}

</script>

<p>Vous chattez avec <?php echo $currentProfile->getFirstName() . " " . $currentProfile->getLastName();?>.</p>

<div id="sendMessage">
<input type="text" name="message" id="SendMessageTextBox" placeholder="Tapez votre message ici"><button type="button" id="SendMessageButton" onClick="sendMessage();">Envoyer le message</button><br>
</div>

<div id="messageBox">
    <div id="messageList">
        <?php
        if (empty($messageList)) {
        	echo "<p>Vous n'avez pas encore echange de message.</p>";
        } else {    	foreach($messageList as $message) {
        		$symbol = ($message->getToUser() == $currentUser->getId()) ? "->" : "<-";
        		echo "<div class=\"msgInList\" id=\"msg" . $message->getId() . "\"><p>" . $symbol . " " . html_entity_decode($message->getContent()) . "</p>";
        	}
        }
        ?>
    </div>
</div>