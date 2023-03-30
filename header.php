<?php
    // 발급된 세션 id가 있다면 세션의 id를, 없다면 false 반환
    if(!session_id()) {
    // id가 없을 경우 세션 시작
        session_start();
    }
    $page_url = substr($_SERVER['REQUEST_URI'],9); // /Project/페이지명 - 프로젝트 경로 제거하고 파일명만 가져오기 - 페이지명  
    $img_src = "";

    if($page_url == "main.php" || $page_url == "univ_menu.php") {
        $img_src = "header_main.png";
    } else if(explode('?',$page_url)[0] == "review.php") {
        $img_src = "header_review.png";
    } else if($page_url == "store_request.php") {
        $img_src = "header_request.png";
    } else {
        $img_src = "header_search.png";
    }
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <link rel="stylesheet" href="resources/css/header.css" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        function over_change(src) {
            document.getElementById("header_img").src = "resources/img/" + src;
        }
        function out_change() {
            document.getElementById("header_img").src = "resources/img/<?=$img_src?>";
        }
        function go_page(url) {
            let check;
            let go_url = url;
            if(go_url == "store_request.php") {
            <?php
                if(!isset($_SESSION['id'])) {
            ?>
                check = confirm("로그인이 필요합니다.\n로그인을 하시겠습니까?");
                if(check) {
                    location.href = "login.php";
                }
            <?php
                } else {
            ?>
                    location.href = go_url;
            <?php
                }
            ?>
            } else {
                location.href = go_url;
            }
        }
    </script>
</head>
<body>
    <div class="headerWrap">
        <img src="resources/img/<?=$img_src?>" id="header_img" class="header_img" usemap="#HeaderMap">
        <map name="HeaderMap" id="HeaderMap">
            <area shape="rect" coords="1,24,172,181" onclick="go_page('main.php')">
            <area shape="rect" coords="333,79,361,112" onmouseover="over_change('header_main.png');" onmouseout="out_change();" onclick="go_page('main.php')">
            <area shape="rect" coords="545,79,662,112" onmouseover="over_change('header_search.png');" onmouseout="out_change();" onclick="go_page('store_category.php')">
            <area shape="rect" coords="844,79,964,112" onmouseover="over_change('header_request.png');" onmouseout="out_change();" onclick="go_page('store_request.php')">
            <area shape="rect" coords="1140,79,1197,112" onmouseover="over_change('header_review.png');" onmouseout="out_change();" onclick="go_page('review.php')">
        </map>
    </div>
</body>
</html>