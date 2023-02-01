
function updateTime() {
    var currentdate = new Date();
    var datetime = currentdate.getDate() + "/"
        + (currentdate.getMonth() + 1) + "/"
        + currentdate.getFullYear() + "  "
        + currentdate.getHours() + ":"
        + currentdate.getMinutes() + ":"
        + currentdate.getSeconds();
    $('#time').html(datetime);
}
$(function () {
    setInterval(updateTime, 1000);
});

function getCookieByName(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}

let kosikInput = document.getElementById('pk_kosik');
let kosikBtn = document.getElementById('vlozit_btn');
let idHolder = document.getElementById('id_holder');

kosikBtn.addEventListener('click', function () {
    let id = idHolder.innerText;
    let pocetKusu = kosikInput.value;
    valOrNull = (document.cookie.match(/^(?:.*;)?\s*v_kosiku\s*=\s*([^;]+)(?:.*)?$/) || [, null])[1];
    console.log(valOrNull);

    if (valOrNull == null) {
        document.cookie = "v_kosiku=" + id + ":" + pocetKusu + "; expires=Thu, 18 Dec 2023 12:00:00 UTC";
    } else {
        document.cookie = "v_kosiku=" + valOrNull + "," + id + ":" + pocetKusu + "; expires=Thu, 18 Dec 2023 12:00:00 UTC";
    }

});