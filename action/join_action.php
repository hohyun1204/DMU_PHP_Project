<?php
    // 회원가입 액션 페이지
    include_once("../DB/DB_Connection.php"); // DB 연결하는 클래스 읽어오기

    $id = $_POST["id"]; //id 받아오기
    $hashedPassword = password_hash($_POST["pw"], PASSWORD_DEFAULT); // pw 받아와서 간단한 해시 처리 (암호화를 위해)

    $connection = new DB_Connection(); // 객체 생성
    $result = $connection->execute("insert into user (id, pw) values ('".$id."', '".$hashedPassword."')"); //쿼리문 실행 후 result 변수에 결과 저장
    if($result) { // 성공했다면
        echo "success"; // success
    } else { // 실패했다면
        echo "fail"; // fail
    }
