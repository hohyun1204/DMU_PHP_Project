<?php
    include('simple_html_dom.php'); // 데이터 크롤링 파일 읽어오기
    include("DB/DB_Connection.php"); // DB 연결하는 클래스 읽어오기

    //오늘 날짜 출력 ex) 2022-12-10
    $today_date = date('Y-m-d');
    //오늘의 요일 출력 ex) 수요일 = 6
    $day_of_the_week = date('w');
    //이번 주의 첫째 요일인 날짜 출력(기준 월요일) ex) 2022-12-05(월)
    $week_start = date('Y-m-d', strtotime($today_date." -".($day_of_the_week - 1)."days"));
    //이번 주의 마지막 요일인 날짜 출력(기준 월요일) ex) 2022-12-11(일)
    $week_end = date('Y-m-d', strtotime($week_start." +6days"));
    if(isset($_POST['move'])) { //페이지 이동이 있다면
        $week_start = $_POST['day']; // 이동 전 첫째 요일 받아오기
        if($_POST['move'] == "pre") { // 전주로 이동이라면
            $week_start = date('Y-m-d', strtotime($week_start." -7days")); // 7일 빼기
        } else { // 다음주로 이동이라면
            $week_start = date('Y-m-d', strtotime($week_start." +7days")); // 7일 더하기
        }
        $week_end = date('Y-m-d', strtotime($week_start." +6days")); // 이동 후 마지막 요일 저장
    }
?>
<!doctype html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="resources/css/common.css" rel="stylesheet" type="text/css" />
    <link href="resources/css/univ_menu.css" rel="stylesheet" type="text/css" />
    <title>DMU 맛집</title>
    <script src="resources/js/univ_menu.js"></script>
</head>
<body>
<div class="main">
    <header>
        <?php include("header.php");?>
    </header>
    <section>
        <div class="univ_menu">
            <div class="univ_menu_header">
                <img src="resources/img/menu_info.png">
            </div>
            <div class="univ_menu_section">
                <table class="univ_menu_section_table">
                    <tr>
                        <th class="univ_menu_table_head univ_menu_table_1">구분</th>
                        <th class="univ_menu_table_head univ_menu_table_2">월</th>
                        <th class="univ_menu_table_head univ_menu_table_2">화</th>
                        <th class="univ_menu_table_head univ_menu_table_2">수</th>
                        <th class="univ_menu_table_head univ_menu_table_2">목</th>
                        <th class="univ_menu_table_head univ_menu_table_2">금</th>
                    </tr>
                    <?php

                        $connection = new DB_Connection(); // 객체 생성
                        $result = $connection->execute("select menu1, menu2 from univ_menu where date >= '".$week_start."' and date <= '".$week_end."'");
                        $food_arr = array();
                        while ($row = mysqli_fetch_array($result)) { //결과가 존재한다면 반복
                            $food_arr[] = $row['menu1'];
                            $food_arr[] = $row['menu2'];
                        }
                        if(count($food_arr) > 0) {
                            $mon_food1 = $food_arr[0];
                            $mon_food2 = $food_arr[1];
                            $tue_food1 = $food_arr[2];
                            $tue_food2 = $food_arr[3];
                            $wed_food1 = $food_arr[4];
                            $wed_food2 = $food_arr[5];
                            $thu_food1 = $food_arr[6];
                            $thu_food2 = $food_arr[7];
                            $fri_food1 = $food_arr[8];
                            $fri_food2 = $food_arr[9];
                        } else {
                            $mon_food1 = "-";
                            $mon_food2 = "-";
                            $tue_food1 = "-";
                            $tue_food2 = "-";
                            $wed_food1 = "-";
                            $wed_food2 = "-";
                            $thu_food1 = "-";
                            $thu_food2 = "-";
                            $fri_food1 = "-";
                            $fri_food2 = "-";
                        }
                    ?>
                    <tr>
                        <td class="univ_menu_table_col univ_menu_table_1">한식</td>
                        <td class="univ_menu_table_col univ_menu_table_2"><?=$mon_food1?></td>
                        <td class="univ_menu_table_col univ_menu_table_2"><?=$tue_food1?></td>
                        <td class="univ_menu_table_col univ_menu_table_2"><?=$wed_food1?></td>
                        <td class="univ_menu_table_col univ_menu_table_2"><?=$thu_food1?></td>
                        <td class="univ_menu_table_col univ_menu_table_2"><?=$fri_food1?></td>
                    </tr>
                    <tr>
                        <td class="univ_menu_table_col univ_menu_table_1">일품</td>
                        <td class="univ_menu_table_col univ_menu_table_2"><?=$mon_food2?></td>
                        <td class="univ_menu_table_col univ_menu_table_2"><?=$tue_food2?></td>
                        <td class="univ_menu_table_col univ_menu_table_2"><?=$wed_food2?></td>
                        <td class="univ_menu_table_col univ_menu_table_2"><?=$thu_food2?></td>
                        <td class="univ_menu_table_col univ_menu_table_2"><?=$fri_food2?></td>
                    </tr>
                </table>
                <div class="univ_menu_section_top">
                    <span class="page_span" onclick="move_date('pre')"><</span>
                    <h4><?=$week_start?> ~ <?=$week_end?></h4>
                    <span class="page_span" onclick="move_date('next')">></span>
                </div>
                <form action="univ_menu.php" id="day_form" method="post">
                    <input type="hidden" id="day" name="day" value="<?=$week_start?>" />
                    <input type="hidden" id="move" name="move" value="" />
                </form>
            </div>
        </div>
    </section>
</div>
</body>
</html>