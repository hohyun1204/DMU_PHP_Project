<!doctype html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="resources/css/common.css" rel="stylesheet" type="text/css" />
    <link href="resources/css/review.css" rel="stylesheet" type="text/css" />
    <link href="resources/css/star.css" rel="stylesheet" type="text/css" />
    <link href="resources/css/page.css" rel="stylesheet" type="text/css" />
    <title>DMU 맛집</title>
    <script src="resources/js/go_store.js"></script>
</head>
<body>
<div class="main">
    <header>
        <?php include_once("header.php");?>
    </header>
    <section>
        <div class="review">
            <div class="review_header">
                <img src="resources/img/review_info.png">
                <div class="review_header_sub">
                    <span>최신순</span>
                </div>
            </div>
            <div class="review_section">
                <?php
                include_once("DB/DB_Connection.php"); // DB 연결하는 클래스 읽어오기

                $connection = new DB_Connection(); // 객체 생성
                $result = $connection->execute("select count(*) from review"); //쿼리문 실행 후 result 변수에 결과 저장
                $row = mysqli_fetch_array($result);
                $review_count = $row[0];
                if($review_count > 0) {
                ?>
                    <table class="review_table">
                <?php
                    $page_size = ceil($review_count/10);
                    $page_set = 10;
                    $page = 1;
                    if(isset($_GET['page'])) {
                        $page = $_GET['page'];
                    }
                    $limit_start = ($page - 1) * $page_set;

                    $connection = new DB_Connection(); // 객체 생성
                    $result = $connection->execute("select s.idx, name, rating, review, date_format(date,'%Y-%m-%d %H:%i') from store s join review r where s.idx = r.store_idx order by date desc limit ".$limit_start.", ".$page_set); //쿼리문 실행 후 result 변수에 결과 저장
                    while($row = mysqli_fetch_array($result)) { //결과가 존재한다면 반복
                        $rating = $row['rating'] * 20;
                ?>
                        <tr class="review_table_row">
                            <td class="review_table_col review_table_col_1"><a onclick="store(<?=$row[0]?>);"><?=$row['name']?></a></td>
                            <td class="review_table_col review_table_col_2">
                                <span class="star">
                                    ★★★★★
                                    <span style="width:<?=$rating?>%">★★★★★</span>
                                </span>
                            </td>
                            <td class="review_table_col review_table_col_3"><?=$row['review']?></td>
                            <td class="review_table_col review_table_col_4"><?=$row[4]?></td>
                        </tr>
                <?php
                    }
                ?>
                    </table>
                    <div class="page_div">
                        <?php
                            if($page <= 1) {
                        ?>
                            <span class="page_span"><</span>
                        <?php
                            } else {
                        ?>
                            <span class="page_span" onclick="javascript:location.href='?page=<?=$page-1?>'"><</span>
                        <?php
                            }
                            if($page_size > 10 && $page > 5) {
                                if($page_size > $page+5) {
                                    for($i = $page-4; $i <= $page+5; $i++) {
                                        ?>
                                        <span class="page_span<?php if($i == $page) { echo " on"; }?>" <?php if($i != $page) {?>onclick="javascript:location.href='?page=<?=$i?>'"<?php }?>><?=$i?></span>
                                        <?php
                                    }
                                } else {
                                    for($i = $page_size-9; $i <= $page_size; $i++) {
                                        ?>
                                        <span class="page_span<?php if($i == $page) { echo " on"; }?>" <?php if($i != $page) {?>onclick="javascript:location.href='?page=<?=$i?>'"<?php }?>><?=$i?></span>
                                        <?php
                                    }
                                }
                            } else {
                                if($page_size >= 10) {
                                    for($i = 1; $i <= 10; $i++) {
                                        ?>
                                        <span class="page_span<?php if($i == $page) { echo " on"; }?>" <?php if($i != $page) {?>onclick="javascript:location.href='?page=<?=$i?>'"<?php }?>><?=$i?></span>
                                        <?php
                                    }
                                } else {
                                    for($i = 1; $i <= $page_size; $i++) {
                                ?>
                                        <span class="page_span<?php if($i == $page) { echo " on"; }?>" <?php if($i != $page) {?>onclick="javascript:location.href='?page=<?=$i?>'"<?php }?>><?=$i?></span>
                                <?php
                                    }
                                }
                            }
                            if($page < $page_size) {
                        ?>
                            <span class="page_span" onclick="javascript:location.href='?page=<?=$page+1?>'">></span>
                        <?php
                            } else {
                        ?>
                            <span class="page_span">></span>
                        <?php
                            }
                        ?>
                    </div>
                <?php
                } else {
                ?>
                    <table class="review_table">
                        <tr class="review_table_row">
                            <td class="review_table_col" style="font-size:1.25em; font-weight: 400">리뷰가 존재하지 않습니다.</td>
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