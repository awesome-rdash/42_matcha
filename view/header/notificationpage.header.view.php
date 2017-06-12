<?php
	$notificationManager = new NotificationManager($db);
	$unreadCount = $notificationManager->getUnreadNotificationsCount($currentUser->getId());
	$unreadNotifications = $notificationManager->getUnreadNotificationsToUser($currentUser->getId());
?>

<script>

function changeNotificationsVisibility() {
    if (document.getElementById("headerNotifications").style.display == "none") {
       document.getElementById("headerNotifications").style.display = "block";
       document.getElementById("showNotifsText").innerHTML = "Masquer";
        var ajax;

        if (window.XMLHttpRequest) {
            ajax = new XMLHttpRequest();
        } else {
            alert("Il semble que votre navigateur ne supporte pas AJAX. :(");
            return false;
        }
        var data = {};
        data["info"] = "markAllAsRead";
        var formData = new FormData();
        formData.append('action', "notification");
        formData.append('data', JSON.stringify(data));
        ajax.open('post', "action.php", true);
        ajax.send(formData);
    } else {
       document.getElementById("headerNotifications").style.display = "none";
       document.getElementById("showNotifsText").innerHTML = "Afficher";
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
                    if (toShow['count'] == 0 && document.getElementById("headerNotifications").style.display != "block") {
                        document.getElementById("notificationButton").style.display = "none";
                    } else {
                        document.getElementById("notificationButton").style.display = "block";
                    }
                }
            } else {
                alert(toShow["err_msg"]);
            }
        }
    }
    return ajax;
}, 5000)

</script>
<div id="notificationButton" <?php if ($unreadCount == 0) { echo "style=\"display: none\""; } ?> >

<p id="showNotifs"><a href="#" onClick="changeNotificationsVisibility()"><span id="showNotifsText">Afficher</span> les notifications</a></p>
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