<!-- <style>
    .cookie-disclaimer {
        background: #000000;
        color: #FFF;
        opacity: 0.8;
        width: 100%;
        bottom: 0;
        left: 0;
        z-index: 5;
        height: 150px;
        position: fixed;
    }

    .cookie-disclaimer .container {
        text-align: center;
        padding-top: 20px;
        padding-bottom: 20px;
    }

    .cookie-disclaimer .cookie-close {
        float: right;
        padding: 10px;
        cursor: pointer;
    }

    .cookie-disclaimer a {
        color: orange;
    }

    .cookie-disclaimer a:hover {
        color: greenyellow;
    }
</style> -->

<div class="cookie-disclaimer">
    <div class="cookie-close accept-cookie"><i class="fa fa-times"></i></div>
    <div class="container">
        <p>เว็บไซต์ของคณะฯ มีการใช้งานคุ๊กกี้ (Cookies) โดยเราใช้คุกกี้เพียงเพื่อปรับปรุงการใช้งานให้เหมาะสม วิเคราะห์การเข้าใช้เว็บไซต์ และเพิ่มประสบการร์ใช้งานของท่าน
            <br>ถ้าท่านยังใช้งานต่อไปโดยไม่ปฏิเสธคุกกี้ คณะฯ จะเก็บคุกกี้เพื่อวัตถุประสงค์ข้างต้น ทั้งนี้ ท่านสามารถศึกษารายละเอียดที่เกี่ยวกับการใช้คุกกี้ของคณะฯ ได้ที่นี่ <a href="https://arch.mju.ac.th/policy/cookies/">นโยบายการใช้คุ๊กกี้</a>
        </p>
        <button type="button" class="btn btn-success accept-cookie">ยอมรับการใช้งานคุ๊กกี้</button>
    </div>
</div>

<!-- * cookies concent -->
<script>
        $(document).ready(function() {
            var cookie = false;
            var cookieContent = $('.cookie-disclaimer');

            checkCookie();

            if (cookie === true) {
                cookieContent.hide();
            }

            function setCookie(cname, cvalue, exdays) {
                var d = new Date();
                d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
                var expires = "expires=" + d.toGMTString();
                document.cookie = cname + "=" + cvalue + "; " + expires;
            }

            function getCookie(cname) {
                var name = cname + "=";
                var ca = document.cookie.split(';');
                for (var i = 0; i < ca.length; i++) {
                    var c = ca[i].trim();
                    if (c.indexOf(name) === 0) return c.substring(name.length, c.length);
                }
                return "";
            }

            function checkCookie() {
                var check = getCookie("acookie");
                if (check !== "") {
                    return cookie = true;
                } else {
                    return cookie = false; //setCookie("acookie", "accepted", 365);
                }

            }
            $('.accept-cookie').click(function() {
                setCookie("acookie", "accepted", 365);
                cookieContent.hide(500);
            });
        });
    </script>