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

function sort_notifs(a, b) {
   if (a["timestamp"] < b["timestamp"]) return -1;
   if (a["timestamp"] > b["timestamp"]) return 1;
   return 0;
 }

function reload_notifs() {
    var ajax;

    if (window.XMLHttpRequest) {
        ajax = new XMLHttpRequest();
    } else {
        alert("Il semble que votre navigateur ne supporte pas AJAX. :(");
        return false;
    }

    if (typeof reload_notifs.lastCallTime == 'undefined') {
        var d = new Date();
        var n = d.getTime();
        reload_notifs.lastCallTime = n;
    }
    var data = {};
    data["lastCallTime"] = reload_notifs.lastCallTime;
    data["info"] = "count";

    var formData = new FormData();

    formData.append('action', "notification");
    formData.append('data', JSON.stringify(data));
    ajax.open('post', "action.php", true);
    ajax.send(formData);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var reply = ajax.responseText;
            console.log(reply);
            var toShow = JSON.parse(reply);

            if (toShow['output'] == "ok") {
                if (toShow["info"] == "count") {
                    document.getElementById("unreadNotificationsCounter").innerHTML = toShow['count'].toString();
                    reload_notifs.lastCallTime = toShow['time'];
                    if (toShow['count'] == 0 && document.getElementById("headerNotifications").style.display != "block") {
                        document.getElementById("notificationButton").style.display = "none";
                    } else if (toShow['count'] != 0){
                        document.getElementById("notificationButton").style.display = "block";
                        console.log(toShow['notifications']);
                        var arrayContent = JSON.parse(toShow['notifications']);
                        arrayContent.sort(sort_notifs);

                        for (var i = 0, len = arrayContent.length; i < len; i++) {
                            var div = document.createElement('div');
                            div.id = 'notification' + arrayContent[i]['id'];
                            div.className = 'notifInList';

                            var p = document.createElement('p');
                            p.innerHTML = unescape(arrayContent[i]['content']);

                            div.appendChild(p);
                            document.getElementById('headerNotifications').insertBefore(div, headerNotifications.childNodes[0]);
                        }
                    }
                } else {
                    alert(toShow["err_msg"]);
                }
            }
        }
    }
    return ajax;
}

reload_notifs();
setInterval(reload_notifs, 5000);

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