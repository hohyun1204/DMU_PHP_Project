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

    function insert($url, $today_date, $week_start, $week_end) {
        $html = file_get_html($url);
        $start_date = trim(explode('~',$html->find('._dietTerm text', 3)->innertext)[0]);
        $end_date = trim(explode('~',$html->find('._dietTerm text', 3)->innertext)[1]);
        $connection = new DB_Connection(); // 객체 생성
        $result = $connection->execute("select * from univ_menu where date >= '".$start_date."' and date <= '".$end_date."'");
        if($row = mysqli_fetch_array($result)) {
        } else {
            $move = "";
            if(isset($_POST['move'])) {
                $move = $_POST['move'];
            }
            if ($today_date >= $week_start && $today_date <= $week_end && ($html->find('table tr', 1)->find('td', 1)->innertext != '-' ||
                $html->find('table tr', 3)->find('td', 1)->innertext != '-' || $html->find('table tr', 5)->find('td', 1)->innertext != '-' ||
                $html->find('table tr', 7)->find('td', 1)->innertext != '-' || $html->find('table tr', 9)->find('td', 1)->innertext != '-')) {
                for ($i = 1; $i <= 9; $i += 2) {
                    $date = preg_split('/<br[^>]*>/i', $html->find('table tr', $i)->find('th', 0)->innertext)[0];
                    $food1 = "";
                    $food2 = "";
                    if ($html->find('table tr', $i)->find('td', 1)->innertext == '-') {
                        $food1 = "-";
                        $food2 = "-";
                    } else {
                        if (strpos(preg_split('/<br[^>]*>/i', $html->find('table tr', $i)->find('td', 2)->innertext)[0], '[') !== false) {
                            $food1 = trim(explode('-', preg_replace('/\s+/', '-', preg_split('/<br[^>]*>/i', $html->find('table tr', $i)->find('td', 2)->innertext)[0], 1), 2)[1]);
                            $food2 = trim(explode('-', preg_replace('/\s+/', '-', preg_split('/<br[^>]*>/i', $html->find('table tr', $i)->find('td', 2)->innertext)[1], 1), 2)[1]);
                        } else {
                            $food1 = trim(explode(' ', preg_split('/<br[^>]*>/i', $html->find('table tr', $i)->find('td', 2)->innertext)[0], 2)[1]);
                            $food2 = trim(explode(' ', preg_split('/<br[^>]*>/i', $html->find('table tr', $i)->find('td', 2)->innertext)[1], 2)[1]);
                        }
                    }
                    $connection = new DB_Connection(); // 객체 생성
                    $connection->execute("insert into univ_menu values ('" . $date . "', '" . $food1 . "', '" . $food2 . "')");
                }
            }
        }
    }
    insert('https://www.dongyang.ac.kr/dongyang/130/subview.do', $today_date, $week_start, $week_end);
?>
<!doctype html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="resources/css/common.css" rel="stylesheet" type="text/css" />
    <link href="resources/css/main.css" rel="stylesheet" type="text/css" />
    <title>DMU 맛집</title>
    <script src="resources/js/go_store.js"></script>
</head>
<body>
<div class="main">
    <header>
        <?php include("header.php");?>
    </header>
    <section>
        <div class="main_section">
<!--            <div class="main_wrapper">-->
<!--                <div class="main_wel">welcome..!</div>-->
<!--            </div>-->

            <div class="mainlist_wrapper">
                <div class="sub_wrapper store_wrapper">
                    <div class="store_header">
                        <h2>맛집 랭킹</h2>
                    </div>
                    <?php
                        $connection = new DB_Connection(); // 객체 생성
                        $result = $connection->execute("select count(*) from store");
                        $row = mysqli_fetch_row($result);
                        $store_count = $row[0];
                        if($store_count > 0) {
                    ?>
                    <div class="store_main">
                        <div class="store_div_header" style="border-radius: 10px 10px 0 0 / 10px 10px 0 0;">별점 높은 순</div>
                        <?php
                            $number = 1;

                            $connection = new DB_Connection(); // 객체 생성
                            $result = $connection->execute("select s.idx, name, round(avg(rating),1), count(review) from store s inner join review r where s.idx = r.store_idx group by s.idx order by 3 desc, 4 desc, s.name limit 5");
                            while($row = mysqli_fetch_row($result)) {
                                if($number != 5) {
                        ?>
                            <div class="store_div_section">
                                <div class="store_div_section_number">
                                    <?=$number?>
                                </div>
                                <div class="store_div_section_content">
                                    <a onclick="store(<?=$row[0]?>);"><span><?=$row[1]?></span></a>&nbsp;<span style="font-size:13px;">별점 : <?=$row[2]?>&nbsp;(<?=$row[3]?>)</span>
                                </div>
                            </div>
                        <?php
                                } else {
                        ?>
                                    <div class="store_div_section" style="border-bottom: 0">
                                        <div class="store_div_section_number">
                                            <?=$number?>
                                        </div>
                                        <div class="store_div_section_content">
                                            <a onclick="store(<?=$row[0]?>);"><span><?=$row[1]?></span></a>&nbsp;<span style="font-size:13px;">별점 : <?=$row[2]?>&nbsp;(<?=$row[3]?>)</span>
                                        </div>
                                    </div>
                        <?php
                                }
                                $number++;
                            }
                            for($i = $number; $i <= 5; $i++) {
                                if($i != 5) {
                        ?>
                                <div class="store_div_section">
                                    <div class="store_div_section_number">
                                        <?=$i?>
                                    </div>
                                    <div class="store_div_section_content"></div>
                                </div>
                        <?php
                                } else {
                        ?>
                                    <div class="store_div_section" style="border-bottom: 0">
                                        <div class="store_div_section_number">
                                            <?=$i?>
                                        </div>
                                        <div class="store_div_section_content"></div>
                                    </div>
                        <?php
                                }
                            }
                        ?>
                        <div class="store_div_header" style="border-top:1px solid">리뷰 많은 순</div>
                        <?php
                        $number = 1;

                        $connection = new DB_Connection(); // 객체 생성
                        $result = $connection->execute("select s.idx, name, round(avg(rating),1), count(review) from store s inner join review r where s.idx = r.store_idx group by s.idx order by 4 desc, 3 desc, s.name limit 5");
                        while($row = mysqli_fetch_row($result)) {
                            if($number != 5) {
                                ?>
                                <div class="store_div_section">
                                <?php
                            } else {
                                ?>
                                <div class="store_div_section" style="border-bottom: 0">
                                <?php
                            }
                                ?>
                                    <div class="store_div_section_number">
                                        <?=$number?>
                                    </div>
                                    <div class="store_div_section_content">
                                        <a onclick="store(<?=$row[0]?>);"><span><?=$row[1]?></span></a>&nbsp;<span style="font-size:13px;">별점 : <?=$row[2]?>&nbsp;(<?=$row[3]?>)</span>
                                    </div>
                                </div>
                                <?php
                            $number++;
                        }
                        for($i = $number; $i <= 5; $i++) {
                            if($i != 5) {
                                ?>
                                <div class="store_div_section">
                                    <?php
                            } else {
                                ?>
                                <div class="store_div_section" style="border-bottom: 0">
                                    <?php
                            }
                                ?>
                                    <div class="store_div_section_number">
                                        <?=$i?>
                                    </div>
                                    <div class="store_div_section_content"></div>
                                </div>
                                <?php
                        }
                        ?>
                    </div>
                    <?php
                        } else {
                    ?>
                        <div class="blank_div">
                            맛집이 존재하지 않습니다.
                        </div>
                    <?php
                        }
                    ?>
                </div>

                <div class="sub_wrapper review_wrapper">
                    <div class="review_header">
                        <h2>최신 리뷰</h2>
                    </div>
                    <?php
                        if($store_count > 0) {
                    ?>
                    <div class="review_main">
                        <?php
                        $number = 1;

                        $connection = new DB_Connection(); // 객체 생성
                        $result = $connection->execute("select s.idx, s.name, date_format(date,'%m-%d %H:%i'), rating, char_length(review), left(review,20) from store s inner join review r where s.idx = r.store_idx order by date desc limit 8");
                        while($row = mysqli_fetch_row($result)) {
                            if($number == 1) {
                                ?>
                                <div class="review_div" style="border:0;">
                                <?php
                            } else {
                                ?>
                                <div class="review_div">
                                <?php
                            }
                                ?>
                                    <div class="review_div_header">
                                        <a onclick="store(<?=$row[0]?>);"><div class="review_div_header_name"><?=$row[1]?></div></a>
                                        <div class="review_div_header_sub"><?=$row[2]?> 별점 : <?=$row[3]?></div>
                                    </div>
                                    <div class="review_div_content">
                                        <a onclick="location.href='review.php'">
                                            <?php
                                                if($row[4] > 20) {
                                                    echo $row[5]."...";
                                                } else {
                                                    echo $row[5];
                                                }
                                            ?>
                                        </a>
                                    </div>
                                </div>
                                <?php
                            $number++;
                        }
                        for($i = $number; $i <= 8; $i++) {
                            if($i == 1) {
                                ?>
                                    <div class="review_div" style="border:0;">
                                <?php
                            } else {
                                ?>
                                    <div class="review_div">
                                <?php
                            }
                                ?>
                                    <div class="review_div_header">
                                        <div class="review_div_header_name"></div>
                                        <div class="review_div_header_sub"></div>
                                    </div>
                                    <div class="review_div_content">
                                    </div>
                                </div>
                                <?php
                        }
                        ?>
                    </div>
                    <?php
                        } else {
                    ?>
                        <div class="blank_div">
                            리뷰가 존재하지 않습니다.
                        </div>
                    <?php
                        }
                    ?>
                </div>
                        <?php
                            $connection = new DB_Connection(); // 객체 생성
                            $result = $connection->execute("select count(*) from menu");
                            $row = mysqli_fetch_row($result);
                            $menu_count = $row[0];
                            if($menu_count == 0) {
                                $random_menu = "등록된 맛집이<br/>하나도 없어!!";
                            } else {
                                $random_number = rand(1, $menu_count);
                                $connection = new DB_Connection(); // 객체 생성
                                $result = $connection->execute("select s.name, m.name from store s inner join menu m where s.idx = m.store_idx and m.idx = '".$random_number."'");
                                $row = mysqli_fetch_row($result);
                                $random_menu = "오늘의 추천 메뉴는<br/>".$row[0]." ".$row[1]."!!";
                            }
                        ?>
                <div class="sub_wrapper lunch_main_wrapper">
                    <div class="random_text">
                        <?=$random_menu?>
                    </div>
<!--                    <img src="resources/img/main_kitty.jpg" class="main_img" onclick="alert('랜덤메뉴추천')"/>-->
                    <img src="resources/img/main_bonobono.png" class="main_img"/>
                    <div class="lunch_sub_wrapper">
<!--                        <div class="random_lunch">랜메추</div>-->
                        <div class="login">
<!--                            <div class="login_p_div">-->
<!--                                DMU맛집 더 안전하고 편안하게 이용하세요-->
<!--                            </div>-->
                            <?php 
                            if(!isset($_SESSION['id'])) {
                            ?>
                                <div class="login_button_div">
                                    <div class="login_button" onclick="location.href='login.php'">로그인</div>
                                </div>
                                <div class="login_join_div">
                                     <span onclick="location.href='join.php'"><img src="resources/img/main_people.png" class="login_people_img" />회원가입</span>
                                </div>
                            <?php 
                            } else {
                            ?>
                            	<div class="login_button_div">
                                    <div class="login_button" onclick="location.href='action/logout_action.php'">로그아웃</div>
                                </div>
                                <div class="login_join_div">
                                    <!-- <span onclick="location.href='join.php'"><img src="resources/img/main_people.png" class="login_people_img" />회원가입</span> -->
                                </div>
                            <?php 
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                        $connection = new DB_Connection(); // 객체 생성
                        $result = $connection->execute("select menu1, menu2 from univ_menu where date = '".$today_date."'");
                        if ($row = mysqli_fetch_array($result)) { //결과가 존재한다면
                            $today_food1 = $row['menu1'];
                            $today_food2 = $row['menu2'];
                        } else {
                            $today_food1 = "-";
                            $today_food2 = "-";
                        }
                    ?>
                    <div class="lunch">
                        <div class="lunch_header">
                            <h2>금일 식단</h2><span onclick="location.href='univ_menu.php'">더보기</span>
                        </div>
                        <table class="lunch_table">
                            <tr>
                                <td class="lunch_table_col1" style="border-radius: 10px 0 0 0 / 10px 0 0 0;">한식</td>
                                <td class="lunch_table_col2"><?=$today_food1?></td>
                            </tr>
                            <tr style="border-top: 1px solid">
                                <td class="lunch_table_col1" style="border-radius: 0 0 0 10px / 0 0 0 10px; border-top: 1px solid;">일품</td>
                                <td class="lunch_table_col2" style="border-top: 1px solid;"><?=$today_food2?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
</body>
</html>