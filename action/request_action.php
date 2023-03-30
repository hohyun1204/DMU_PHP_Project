<?php
    //식당과 메뉴 등록하는 액션 페이지
    include_once("../DB/DB_Connection.php"); // DB 연결하는 클래스 읽어오기

    $name = trim($_POST["name"]); // name 받아와서 앞뒤 공백 제거
    $type = trim($_POST["type"]); // type 받아와서 앞뒤 공백 제거
    $location = trim($_POST["location"]); // location 받아와서 앞뒤 공백 제거
    $map_x = trim($_POST["map_x"]); // map_x 받아와서 앞뒤 공백 제거
    $map_y = trim($_POST["map_y"]); // map_y 받아와서 앞뒤 공백 제거
    $menu_name = trim($_POST["menu_name"]); // menu_name 받아와서 앞뒤 공백 제거
    $menu_price = trim($_POST["menu_price"]); // menu_price 받아와서 앞뒤 공백 제거

    $list_file_dir = "D:/xampp/htdocs/Project/resources/img/menu_list/"; // 메뉴판 이미지 저장할 경로
    $list_file_type = explode(".",$_FILES["menu_list"]["name"]); // .을 기준으로 변수에 저장
    $uniq_list_file = uniqid("list_", true).".".$list_file_type[count($list_file_type)-1]; // uniqid를 이용한 랜덤 파일 이름 생성 후 확장자 붙이기 
    $list_file_path = $list_file_dir.$uniq_list_file; // 전체 파일 경로와 이름 변수에 저장
    move_uploaded_file($_FILES["menu_list"]["tmp_name"], $list_file_path); // 첨부한 메뉴판 이미지를 전체 파일 경로에 이름으로 저장 

    $menu_file_dir = "D:/xampp/htdocs/Project/resources/img/menu/"; // 대표메뉴 이미지 저장할 경로
    $menu_file_type = explode(".",$_FILES["menu_image"]["name"]); // .을 기준으로 변수에 저장
    $uniq_menu_file = uniqid("menu_", true).".".$menu_file_type[count($menu_file_type)-1]; // uniqid를 이용한 랜덤 파일 이름 생성 후 확장자 붙이기 
    $menu_file_path = $menu_file_dir.$uniq_menu_file; // 전체 파일 경로와 이름 변수에 저장
    move_uploaded_file($_FILES["menu_image"]["tmp_name"], $menu_file_path); // 첨부한 메뉴판 이미지를 전체 파일 경로에 이름으로 저장 

    $connection = new DB_Connection(); // 객체 생성
    $result = $connection->execute("select idx, name, location from store where name = '".$name."' and location = '".$location."'"); //쿼리문 실행 후 result 변수에 결과 저장
    if($row = mysqli_fetch_array($result)) { // 이미 식당이 존재한다면
        echo $row['idx']; // 식당의 idx값 출력
    } else { // 존재하지 않는다면
        $connection = new DB_Connection(); // 객체 생성
        $result = $connection->execute("insert into store (name, type, menu, location, map_x, map_y) values 
                                    ('".$name."', '".$type."', '".$uniq_list_file."', '".$location."', '".$map_x."', '".$map_y."')"); //쿼리문 실행 후 result 변수에 결과 저장

        $connection = new DB_Connection(); // 객체 생성
        $result = $connection->execute("select idx, name, location from store where name = '".$name."' and location = '".$location."'"); //쿼리문 실행 후 result 변수에 결과 저장
        $row = mysqli_fetch_array($result); // $row에 결과 저장
        $store_idx = $row['idx']; // 입력한 store_idx 변수에 저장 (메뉴 DB 등록하는 용도)

        $connection = new DB_Connection(); // 객체 생성
        $result = $connection->execute("insert into menu (store_idx, name, price, image) values 
                                        ('".$store_idx."', '".$menu_name."', '".$menu_price."', '".$uniq_menu_file."')"); //쿼리문 실행 후 result 변수에 결과 저장
        if($result) { // 성공했다면
            echo "success.".$store_idx; // success와 store_idx (store_idx를 이용해 리뷰 등록)
        } else { // 실패했다면
            echo "fail"; // fail
        }
    }