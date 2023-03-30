$(function() {
    let reg = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d$@$!%*#?&]{6,}$/;
    $("#id").on("focusout", function() {
        let idval = $('#id').val();
        let id = document.getElementById('message1');
        if (!idval) {
            id.className = "message";
            id.innerText = "필수 항목입니다.";
        } else if (idval.length == 8){
            $.ajax({
                url: "action/id_check_action.php",
                method: "POST",
                data: {
                    id : idval
                },
                success: function(res) {
                    if(res == 'success') {
                        id.classList.add('ok');
                        id.innerText = "사용 가능한 아이디입니다.";
                    } else {
                        id.className = "message";
                        id.innerText = "중복된 아이디입니다.";
                    }
                }
            });
        } else {
            id.className = "message";
            id.innerText = "8자리 학번(숫자)을 입력하세요.";
        }
    });
    $("#pw").on("focusout", function() {
        let pw = $('#pw').val();
        let id = document.getElementById('message2');
        if (!pw) {
            id.className = "message";
            id.innerText = "필수 항목입니다.";
        } else if (reg.test(pw)) {
            id.classList.add('ok');
            id.innerText = "사용 가능한 비밀번호입니다.";
            if(pw == $('#pw2').val() ) {
                document.getElementById('message3').classList.add('ok');
                document.getElementById('message3').innerText = "비밀번호가 일치합니다.";
            } else if($('#pw2').val().length > 0) {
                document.getElementById('message3').className = "message";
                document.getElementById('message3').innerText = "비밀번호가 일치하지 않습니다.";
            }
        } else {
            id.className = "message";
            id.innerText = "6~20자 영어 대 소문자, 숫자를 사용하세요.";
        }
    });
    $("#pw2").on("focusout", function() {
        let pw = $('#pw2').val();
        let id = document.getElementById('message3');
        if (!pw) {
            id.className = "message";
            id.innerText = "필수 항목입니다.";
        } else if ($('#pw').val() == pw) {
            id.classList.add('ok');
            id.innerText = "비밀번호가 일치합니다.";
        }  else {
            id.className = "message";
            id.innerText = "비밀번호가 일치하지 않습니다.";
        }
    });
    $(".bt").click(function() {
        if(!$('#message1').hasClass('ok')) {
            focus();
            $('#id').focus();
        } else if (!$('#message2').hasClass('ok')) {
            focus();
            $('#pw').focus();
        } else if (!$('#message3').hasClass('ok')) {
            focus();
            $('#pw2').focus();
        } else {
            $.ajax({
                url: "action/join_action.php",
                type: "POST",
                data: {
                    id : $('#id').val(),
                    pw : $('#pw').val()
                },
                success: function(res) {
                    if(res == 'success') {
                        alert("회원가입 축하합니다!!");
                        location.href = "login.php";
                    } else {
                        alert("관리자에게 문의하세요.");
                    }
                }
            });
        }
    });
});
function focus() {
    $('#id').focus();
    $('#pw').focus();
    $('#pw2').focus();
}