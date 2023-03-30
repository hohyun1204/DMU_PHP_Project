<?php
    session_start();
?>
<!doctype html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="resources/css/common.css" rel="stylesheet" type="text/css" />
    <link href="resources/css/star.css" rel="stylesheet" type="text/css" />
    <link href="resources/css/store.css" rel="stylesheet" type="text/css" />
    <title>DMU 맛집</title>
</head>
<body>
    <div class="main">
        <header>
            <?php include("header.php");?>
        </header>
            <?php
                include_once("DB/DB_Connection.php"); // DB 연결하는 클래스 읽어오기

                $store_idx = $_POST['store_idx'];

                $connection = new DB_Connection(); // 객체 생성
                $result = $connection->execute("select s.name, round(avg(rating),1), image, m.name, price, menu, map_x, map_y, count(review)  from store s, review r, menu m where s.idx = r.store_idx and r.store_idx = m.store_idx and s.idx = '".$store_idx."'"); //쿼리문 실행 후 result 변수에 결과 저장
                $row = mysqli_fetch_array($result); // 결과를 $row에 담기

                $store_name = $row[0];
                $store_rating = $row[1];
                $menu_image = $row[2];
                $menu_name = $row[3];
                $menu_price = $row[4];
                $list_image = $row[5];
                $map_x = $row[6];
                $map_y = $row[7];
                $review_count = $row[8];
            ?>
        <section>
            <div class="store">
                <div class="store_header">
                    <h2><?=$store_name?></h2>
                    <span>평점 : <?=$store_rating?></span>
                </div>
                <div class="store_content">
                    <div class="store_content_menu">
                        <div class="store_content_menu_menu">
                            <div class="store_content_menu_menu_img">
                                <img src="resources/img/menu/<?=$menu_image?>">
                            </div>
                            <div class="store_content_menu_menu_info">
                                <h2><?=$menu_name?>&nbsp;&nbsp;&nbsp;<?=$menu_price?>원</h2>
                            </div>
                        </div>
                        <div class="store_content_menu_list">
                            <div class="store_content_menu_list_img">
                                <img src="resources/img/menu_list/<?=$list_image?>">
                            </div>
                            <div class="store_content_menu_list_info">
                                <h2>메뉴판</h2>
                            </div>
                        </div>
                    </div>
                    <div class="store_content_location">
                        <h2>주소</h2>
                        <div class="store_content_location_box" id="map">

                        </div>
                    </div>
                    <div class="store_content_review_box">
                        <h2>리뷰(<?=$review_count?>)</h2>
                        <div class="star_div">
                            <span class="star">
                                ★★★★★
                                <span>★★★★★</span>
                                <input type="range" id="rating" oninput="drawStar(this)" value="2" step="1" min="2" max="10">
                            </span>
                        </div>
                        <textarea class="review_textarea" id="review" maxlength="150" placeholder="솔직한 리뷰를 써주세요"></textarea>
                        <div class="button_div">
                            <input type="button" class="review_button" value="작성완료" onclick="review_action(<?=$store_idx?>);">
                        </div>
                    </div>
                    <?php
                        $connection = new DB_Connection(); // 객체 생성
                        $result = $connection->execute("select date_format(date,'%Y-%m-%d %H:%i'), rating, review from review where store_idx = '".$store_idx."' order by date desc"); //쿼리문 실행 후 result 변수에 결과 저장
                        while($row = mysqli_fetch_array($result)) { // 결과가 존재한다면 반복
                    ?>
                    <div class="store_content_review">
                        <div class="store_content_review_header">
                            <span class="date"><?=$row[0]?></span>
                            <span class="star">
                                ★★★★★
                                <span style="width:<?=$row['rating']*20?>%">★★★★★</span>
                            </span>
                        </div>
                        <div class="store_content_review_section">
                            <p>
                                <?=$row['review']?>
                            </p>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </section>
    </div>
    <script>
        const drawStar = (target) => {
            document.querySelector(`.star span`).style.width = `${target.value * 10}%`;
        }
    </script>
    <script>
        function review_action(idx) {
            let check;
            <?php
            if(isset($_SESSION['id'])) {
            ?>
            if (!$('#review').val()) {
                alert("리뷰를 입력하세요");
                $('#review').focus();
            } else {
                $.ajax({
                    url: "action/review_action.php",
                    type: "POST",
                    data: {
                        store_idx: idx,
                        rating: $('#rating').val(),
                        review: $('#review').val()
                    },
                    success: function (res) {
                        alert("리뷰가 작성되었습니다");
                        window.location.reload();
                    }
                });
            }
            <?php
            } else {

            ?>
            check = confirm("로그인이 필요합니다.\n로그인을 하시겠습니까?");
            if(check) {
                location.href = "login.php";
            }
            <?php
            }
            ?>
        }
    </script>
    <script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=ba89a4b698092452d37cd2306f5f8e0b"></script>
    <script>
        // 이미지 지도에서 마커가 표시될 위치입니다
        var markerPosition  = new kakao.maps.LatLng(<?=$map_y?>, <?=$map_x?>);

        // 이미지 지도에 표시할 마커입니다
        // 이미지 지도에 표시할 마커는 Object 형태입니다
        var marker = {
            position: markerPosition
        };

        var staticMapContainer  = document.getElementById('map'), // 이미지 지도를 표시할 div
            staticMapOption = {
                center: new kakao.maps.LatLng(<?=$map_y?>, <?=$map_x?>), // 이미지 지도의 중심좌표
                level: 2, // 이미지 지도의 확대 레벨
                marker: marker // 이미지 지도에 표시할 마커
            };

        // 이미지 지도를 생성합니다
        var staticMap = new kakao.maps.StaticMap(staticMapContainer, staticMapOption);
    </script>
</body>
</html>