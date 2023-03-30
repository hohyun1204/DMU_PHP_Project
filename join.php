<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"  href="resources/css/user.css">
    <title>회원가입 페이지</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="resources/js/join.js"></script>
    <script src="resources/js/capslock_check.js"></script>
</head>
<body>
<div class="all">
    <div class="divlogo">
        <h1 class="text2">회원가입</h1>
        <a href="main.php"><img class="dmulogo" src="resources/img/logo.jpg" alt="로고"/></a>
    </div>
    <section>
        <div class="box">
            <form name="join">
                <h4>아이디(학번)</h4>
                <input type="text" id="id" class="idbox" placeholder="아이디를 입력해주세요" maxlength="8"
                       oninput="this.value = this.value.replace(/[^0-9]/g, '');"/> <!-- 아이디 입력 란-->
                <div class="message" id='message1'></div>
                <h4>비밀번호</h4>
                <input type="password" id="pw" class="pasbox" placeholder="비밀번호를 입력해주세요" maxlength="20" onkeypress="checkCapsLock(event, 'message2')"/> <!-- 비밀번호 입력 란-->
                <div class="message" id='message2'></div>
                <h4>비밀번호 확인</h4>
                <input type="password" id="pw2" class="pasbox" placeholder="다시 한번 입력해주세요" maxlength="20" onkeypress="checkCapsLock(event, 'message3')"/> <!-- 비밀번호 입력 란-->
                <div class="message" id='message3'></div>
                <input type="button" class="bt" value="가입하기"> <!-- 로그인 버튼 -->
            </form>
        </div>
    </section>
</div>
</body>
</html>