<?php
	$notificationManager = new NotificationManager($db);
	$unreadCount = $notificationManager->getUnreadNotificationsCount($currentUser->getId());
	$unreadNotifications = $notificationManager->getUnreadNotificationsToUser($currentUser->getId());
?>

<script>

function changeNotificationsVisibility() {
    if (document.getElementById("headerNotifications").style.display == "none") {
       document.getElementById("headerNotifications").style.display = "block";
    } else {
       document.getElementById("headerNotifications").style.display = "none";
    }
}

setInterval(function() {
	var ajax;

    if (window.XMLHttpRequest) {
        ajax = new XMLHttpRequest();
    } else {
        alert("Il semble que votre navigateur ne supporte pas AJAX. :(");
        return false;
    }

    var data = {};
    data["info"] = "count";
    if (isNaN(data["lastCallTime"])) {
    	data["lastCallTime"] = 0;
    }

    var formData = new FormData();

    formData.append('action', "notification");
    formData.append('data', JSON.stringify(data));
    ajax.open('post', "action.php", true);
    ajax.send(formData);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var reply = ajax.responseText;
            var toShow = JSON.parse(reply);

            if (toShow['output'] == "ok") {
                if (toShow["info"] == "count") {
                	document.getElementById("unreadNotificationsCounter").innerHTML = toShow['count'].toString();
                	data['lastCall'] = toShow['time'];
                }
            } else {
                alert(toShow["err_msg"]);
            }
        }
    }
    return ajax;
}, 5000)

</script>
<div id="notificationButton">
<p><a href="#" onClick="changeNotificationsVisibility()">Afficher les notifications</a></p>
</div>

<p>Notifications non lues : <span id="unreadNotificationsCounter"><?php echo $unreadCount; ?></span></p>
<div id="headerNotifications" style="display: none">


<?php

foreach ($unreadNotifications as $notification) {
	?>
	<div id="notification<php echo($notification->getId());?>">
	<p><?php echo $notification->getStringFromNotification($db);?></p>
	</div>
	<?php
}
?>

</div>