<?php
    // 로그인 액션 페이지
    session_start(); // 세션 시작
    include_once("../DB/DB_Connection.php"); // DB 연결하는 클래스 읽어오기

    $id = $_POST["id"]; // id 받아오기
    $pw = $_POST["pw"]; // pw 받아오기

    $connection = new DB_Connection(); // 객체 생성
    $result = $connection->execute("select idx, id, pw from user where id ='".$id."'");  //쿼리문 실행 후 result 변수에 결과 저장

    $row = mysqli_fetch_array($result); // $row에 결과 저장
    $hashedPassword = $row['pw']; // DB에서 받아온 pw를 변수에 저장

    $passwordResult = password_verify($pw, $hashedPassword); // 폼에서 받아온 pw와 DB에서 받아온 pw가 일치하는지 변수에 저장  
    if($passwordResult === true) { // 일치한다면
        $_SESSION['idx'] = $row['idx']; // idx 세션 생성
        $_SESSION['id'] = $id; // id 세션 생성
        $_SESSION['pw'] = $pw; // pw 세션 생성
        echo "success"; // success
    } else { // 일치하지 않는다면
        echo "fail"; // fail
    }