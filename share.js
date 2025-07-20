async function loading() {
    const profile = await VKAPI.getUser();
    
    var http = new XMLHttpRequest();
    var url = 'check.php';
    var params = 'id=' + encodeURIComponent(profile.user.marketing_id) + '&name=' + encodeURIComponent(profile.user.name.first) + '&ava=' + encodeURIComponent(profile.user.ava);
    http.open('POST', url, true);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.onreadystatechange = function() {
        if(http.readyState == 4 && http.status == 200) {
            jsonObject = JSON.parse(http.responseText);
            document.getElementById('out').value = jsonObject.money;
        }
    }
    http.send(params);
}
document.addEventListener("DOMContentLoaded", function(){
    loading();
});