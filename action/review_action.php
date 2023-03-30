<?php
    // 리뷰 등록하는 액션 페이지
    session_start(); // 세션 시작
    include_once("../DB/DB_Connection.php"); // DB 연결하는 클래스 읽어오기

    $user_idx = trim($_SESSION["idx"]); // 세션(idx) 받아오고 앞뒤 공백 제거
    $store_idx = trim($_POST["store_idx"]); // store_idx 받아오고 앞뒤 공백 제거
    $rating = trim($_POST["rating"]); // rating 받아오고 앞뒤 공백 제거
    $rating = $rating/2; // rating 10점 기준이여서 2로 나누기
    $review = trim($_POST["review"]); // review 받아오고 앞뒤 공백 제거

    $connection = new DB_Connection(); // 객체 생성
    $result = $connection->execute("insert into review (store_idx, user_idx, rating, review) values 
                                        ('".$store_idx."', '".$user_idx."', '".$rating."', '".$review."')"); //쿼리문 실행 후 result 변수에 결과 저장
    if($result) { // 성공했다면
        echo "success"; //  success
    } else { // 실패했다면
        echo "fail"; // fail
    }