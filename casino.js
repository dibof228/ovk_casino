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
            document.getElementById('monet').innerHTML = jsonObject.money;
            document.getElementById('wins').innerHTML = jsonObject.wins;
        }
    }
    http.send(params);
}

document.addEventListener('DOMContentLoaded', function() {
    loading();
    
});

const tick = new Audio('tick.mp3');
    const tickk = new Audio('2tick.mp3');
    const start = new Audio('start.mp3');
    
    tick.loop = true;
    tickk.loop = false;
    start.loop = false;

async function dep(price, item) {
    try {
        const result = await VKAPI.buy(parseInt(price), item);
        
        const user = await VKAPI.getUser();
        
        var http = new XMLHttpRequest();
        var url = 'dep.php';
        var params = 'id=' + encodeURIComponent(user.user.marketing_id) + '&sum=' + encodeURIComponent(result['outSum']) + '&signature=' + encodeURIComponent(result['signature']);
    
        http.open('POST', url, true);
    
        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        http.onreadystatechange = function() {
            if(http.readyState == 4 && http.status == 200) {
                jsonObject = JSON.parse(http.responseText);
                document.getElementById('monet').innerHTML = jsonObject.money;
            }
        }
        
        http.send(params);
    } catch (error) {
        if (error.error === 'User cancelled payment') {
            console.log('Вы отменили платеж');
        } else {
            console.log('Ошибка платежа: ' + error.error);
        }
    }
}

async function out(price) {
        const user = await VKAPI.getUser();
        console.log(user);
        
        var http = new XMLHttpRequest();
        var url = 'out.php';
        var params = 'id=' + encodeURIComponent(user.user.marketing_id) + '&sum=' + encodeURIComponent(price);
    
        http.open('POST', url, true);
    
        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        http.onreadystatechange = function() {
            if(http.readyState == 4 && http.status == 200) {
                const div = document.getElementById('body2');
                
                div.innerHTML = '<p>Вывод средств успешен!</p>';
            } else if(http.status == 400) {
                const div = document.getElementById('body2');
                
                div.innerHTML = '<p>Недостаточно средств, либо ещё не прошло 24 часа с вашего последнего вывода</p>';
            } else if(http.status == 500) {
                const div = document.getElementById('body2');
                
                div.innerHTML = '<p>Я рукожоп, сообщите автору</p>';
            }
        }
        
        http.send(params);
}

async function spin(){
    start.play();
    document.getElementById('spin').disabled = true;
    tick.play();
    document.getElementById('1').src = "baraban1.gif";
    document.getElementById('2').src = "baraban2.gif";
    document.getElementById('3').src = "baraban3.gif";
    
    document.getElementById('monet').innerHTML = document.getElementById('monet').innerHTML - document.getElementById('stabvka').value;
    const user = await VKAPI.getUser();
    
    var jsonObject;
    var http = new XMLHttpRequest();
    var url = 'spin.php';
    var params = 'id=' + encodeURIComponent(user.user.marketing_id) + '&sum=' + encodeURIComponent(document.getElementById('stabvka').value);
    http.open('POST', url, true);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.onreadystatechange = function() {
        if(http.readyState == 4 && http.status == 200) {
            jsonObject = JSON.parse(http.responseText);
        
            setTimeout(() => {
                document.getElementById('1').src = jsonObject.slots[0] + ".png";
                tickk.play();
        
                setTimeout(() => {
                    document.getElementById('2').src = jsonObject.slots[1] + ".png";
                    tickk.play();
                }, 1000);
        
                setTimeout(() => {
                    document.getElementById('3').src = jsonObject.slots[2] + ".png";
                    tickk.play();
                    tick.pause();
                    tick.currentTime = 0;
                    document.getElementById('spin').disabled = false;
                    document.getElementById('monet').innerHTML = jsonObject.money;
                    document.getElementById('wins').innerHTML = jsonObject.wins;
                }, 2000);
            }, 3000);
        } else if(http.status == 400) {
            tick.pause();
                    tick.currentTime = 0;
            document.getElementById('1').src = "0.png";
    document.getElementById('2').src = "0.png";
    document.getElementById('3').src = "0.png";
            document.getElementById('spin').disabled = false;
            
        }
    }
    http.send(params);
    
    
}