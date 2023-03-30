<?php
    // 회원가입 아이디 중복 체크하는 페이지
    include_once("../DB/DB_Connection.php"); // DB 연결하는 클래스 읽어오기

    $id = $_POST["id"]; //id 받아오기

    $connection = new DB_Connection(); // 객체 생성
    $result = $connection->execute("select id from user where id ='".$id."'"); //쿼리문 실행 후 result 변수에 결과 저장
    if($row = mysqli_fetch_array($result)) { // 이미 존재한다면
        echo "fail"; // 중복이여서 fail
    } else { // 존재하지 않는다면
        echo "success"; // 중복이 아니여서 success
    }