$(function() {
    $(".bt").click(function () {
        form = document.login;
        if (form.id.value == "") {
            alert("아이디를 입력해주세요");
            form.id.focus();
        } else if (form.pw.value == "") {
            alert("비밀번호를 입력해주세요");
            form.pw.focus();
        } else {
            $.ajax({
                url: "action/login_action.php",
                type: "POST",
                data: {
                    id: $('#id').val(),
                    pw: $('#pw').val()
                },
                success: function (res) {
                    if (res == 'success') {
                        location.href = "main.php";
                    } else {
                        alert("아이디 또는 비밀번호가 틀렸습니다.");
                    }
                }
            });
        }
    });
});