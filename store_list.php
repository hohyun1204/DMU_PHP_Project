<!doctype html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="resources/css/common.css" rel="stylesheet" type="text/css" />
    <link href="resources/css/page.css" rel="stylesheet" type="text/css" />
    <link href="resources/css/star.css" rel="stylesheet" type="text/css" />
    <link href="resources/css/store_list.css" rel="stylesheet" type="text/css" />
    <title>DMU 맛집</title>
    <script src="resources/js/go_store.js"></script>
    <script> 
    	function category_check() {
    		<?php 
    		if(!isset($_GET['category'])) {
    		?>
                document.getElementById('category0').className = "store_list_span category_0";
    		<?php 
    		} else {
    		    $category = $_GET['category'];
    		?>
    			document.getElementById('category<?=$category?>').className = "store_list_span category_" + <?=$category?>;
    		<?php 
    		}
    		?>
    	}
    </script>
</head>
<body onload="category_check()">
<div class="main">
    <header>
        <?php include_once("header.php");?>
    </header>
    <section>
        <div class="store_list">
            <div class="store_list_header">
                <img src="resources/img/store_info.png">
            </div>
            <div class="store_list_section">
                <div class="store_list_section_top">
                    <span class="store_list_span category_0 no_select" id="category0" onclick="location.href='store_list.php'">전체</span>
                    <span class="store_list_span category_1 no_select" id="category1" onclick="location.href='?category=1'">한식</span>
                    <span class="store_list_span category_2 no_select" id="category2" onclick="location.href='?category=2'">중식</span>
                    <span class="store_list_span category_3 no_select" id="category3" onclick="location.href='?category=3'">양식</span>
                    <span class="store_list_span category_4 no_select" id="category4" onclick="location.href='?category=4'" style="width: 12%;">패스트푸드</span>
                    <span class="store_list_span category_5 no_select" id="category5" onclick="location.href='?category=5'">술집</span>
                    <span class="store_list_span category_6 no_select" id="category6" onclick="location.href='?category=6'" style="width: 14%;">카페&디저트</span>
                    <span class="store_list_span category_7 no_select" id="category7" onclick="location.href='?category=7'">일식</span>
                    <span class="store_list_span category_8 no_select" id="category8" onclick="location.href='?category=8'" style="margin: 0;">기타</span>
                </div>
                <?php 
                    include_once("DB/DB_Connection.php"); // DB 연결하는 클래스 읽어오기
                    
                    $category = "";
                    $category_value = "";
                    $query = "select count(*) from store"; // 전체를 조회하는 쿼리
                    if(isset($_GET['category'])) { // GET으로 category 값이 넘어온게 있다면
                        $category = $_GET['category']; // 변수에 저장
                        switch($category) { // 숫자에 따른 카테고리를 category_value에 저장
                            case 1:
                                $category_value = "한식"; break;
                            case 2:
                                $category_value = "중식"; break;
                            case 3:
                                $category_value = "양식"; break;
                            case 4:
                                $category_value = "패스트푸드"; break;
                            case 5:
                                $category_value = "술집"; break;
                            case 6:
                                $category_value = "카페&디저트"; break;
                            case 7:
                                $category_value = "일식"; break;
                            case 8:
                                $category_value = "기타"; break;
                        }
                        $query = "select count(*) from store where type = '".$category_value."'"; // 카테고리가 있다면 그 카테고리만 조회하는 쿼리
            		}
                    $connection = new DB_Connection(); // 객체 생성
                    $result = $connection->execute($query); //쿼리문 실행 후 result 변수에 결과 저장
                    $row = mysqli_fetch_array($result);
                    $store_count = $row[0]; // 쿼리 실행 후 맛집 수를 변수에 저장
                    if($store_count > 0) { // 맛집 수가 0개보다 많으면 실행
                ?>
                <table class="store_list_section_table">
                    <tr>
                        <th class="store_table_head store_table_1">가게명</th>
                        <th class="store_table_head store_table_2">위치</th>
                        <th class="store_table_head store_table_3">평점</th>
                    </tr>
                <?php
                    $page_size = ceil($store_count/5); // 맛집 수 5로 나눈 후 올림을 이용해 페이지 수 저장
                    $page_set = 5; // 기본 출력 개수 5개
                    $page = 1; // 기본 페이지 1페이지
                    $count = 0; // 열 개수 확인용 변수
                    if(isset($_GET['page'])) { // GET으로 page 값이 넘어온게 있다면
                        $page = $_GET['page']; // 페이지 값 변경
                    }
                    $limit_start = ($page - 1) * $page_set;

                    $query = "select distinct s.idx, name, location, round(avg(rating), 1), count(review) from store s join review r where s.idx = r.store_idx group by s.idx order by s.idx desc limit ".$limit_start.", ".$page_set; // 전체를 조회하는 쿼리
                    if(isset($_GET['category'])) { // GET으로 category 값이 넘어온게 있다면
                        $query = "select distinct s.idx, name, location, round(avg(rating), 1), count(review) from store s join review r where s.idx = r.store_idx and type = '".$category_value."' group by s.idx order by s.idx desc limit ".$limit_start.", ".$page_set;
                    }
                    $connection = new DB_Connection(); // 객체 생성
                    $result = $connection->execute($query); //쿼리문 실행 후 result 변수에 결과 저장
                    while($row = mysqli_fetch_array($result)) { //결과가 존재한다면 반복
                        $rating = $row[3] * 20; // width를 위해서 * 20
                ?>
                        <tr>
                            <td class="store_table_col store_table_1"><a onclick="store(<?=$row[0]?>);"><?=$row['name']?></td>
                            <td class="store_table_col store_table_2"><?=$row['location']?></td>
                            <td class="store_table_col store_table_3">
                                <span class="star">
                                    ★★★★★
                                    <span style="width:<?=$rating?>%">★★★★★</span>
                                </span>
                                <span style="position: fixed; margin-top: 22px; font-size: 13px;">(<?=$row[4]?>)</span>
                            </td>
                        </tr>
                <?php
                        $count++;
                    }
                    for($i = $count; $i < 5; $i++) { // 5개의 열이 만들어지지 않았다면 빈 칸으로 만들기
                ?>
                        <tr>
                            <td class="store_table_col store_table_1"></td>
                            <td class="store_table_col store_table_2"></td>
                            <td class="store_table_col store_table_3"></td>
                        </tr>
                <?php
                    }
                ?>
                    </table>
                    <div class="page_div">
                        <?php
                            $page_url = "?page=";
                            if(isset($_GET['category'])) { // GET으로 category 값이 넘어온게 있다면
                                $page_url = "?category=".$_GET['category']."&page=";
                            }
                            if($page <= 1) {
                        ?>
                            <span class="page_span"><</span>
                        <?php
                            } else {
                        ?>
                            <span class="page_span" onclick="javascript:location.href='<?=$page_url?><?=$page-1?>'"><</span>
                        <?php
                            }
                            if($page_size > 10 && $page > 5) {
                                if($page_size > $page+5) {
                                    for($i = $page-4; $i <= $page+5; $i++) {
                                        ?>
                                        <span class="page_span<?php if($i == $page) { echo " on"; }?>" <?php if($i != $page) {?>onclick="javascript:location.href='<?=$page_url?><?=$i?>'"<?php }?>><?=$i?></span>
                                        <?php
                                    }
                                } else {
                                    for($i = $page_size-9; $i <= $page_size; $i++) {
                                        ?>
                                        <span class="page_span<?php if($i == $page) { echo " on"; }?>" <?php if($i != $page) {?>onclick="javascript:location.href='<?=$page_url?><?=$i?>'"<?php }?>><?=$i?></span>
                                        <?php
                                    }
                                }
                            } else {
                                if($page_size >= 10) {
                                    for($i = 1; $i <= 10; $i++) {
                                        ?>
                                        <span class="page_span<?php if($i == $page) { echo " on"; }?>" <?php if($i != $page) {?>onclick="javascript:location.href='<?=$page_url?><?=$i?>'"<?php }?>><?=$i?></span>
                                        <?php
                                    }
                                } else {
                                    for($i = 1; $i <= $page_size; $i++) {
                                ?>
                                        <span class="page_span<?php if($i == $page) { echo " on"; }?>" <?php if($i != $page) {?>onclick="javascript:location.href='<?=$page_url?><?=$i?>'"<?php }?>><?=$i?></span>
                                <?php
                                    }
                                }
                            }
                            if($page < $page_size) {
                        ?>
                            <span class="page_span" onclick="javascript:location.href='<?=$page_url?><?=$page+1?>'">></span>
                        <?php
                            } else {
                        ?>
                            <span class="page_span">></span>
                        <?php
                            }
                        ?>
                    </div>
                <?php 
                } else { // 맛집 수가 0보다 크지 않으면 실행
                ?>
                	<table class="store_list_section_table">
                        <tr>
                            <td class="store_table_col" style="border: 1px solid #aaaaaa;">맛집이 존재하지 않습니다.</td>
                        </tr>
                    </table>
                <?php 
                }
                ?>
            </div>
        </div>
    </section>
</div>
</body>
</html>