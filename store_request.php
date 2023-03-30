<!doctype html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="resources/css/common.css" rel="stylesheet" type="text/css" />
    <link href="resources/css/store_request.css" rel="stylesheet" type="text/css" />
    <link href="resources/css/star.css" rel="stylesheet" type="text/css" />
    <title>DMU 맛집</title>
</head>
<body onload="session_check()">
<div class="main">
    <header>
        <?php
            include("header.php");
        ?>
    </header>
    <section>
        <div class="store_request">
            <div class="store_request_header">
                <img src="resources/img/request_info.png">
                <div class="store_request_header_submit">
                    <input type="button" id="submit" class="store_request_header_button" value="작성완료">
                </div>
            </div>
            <div class="store_request_section">
                <div class="store_request_section_scroll">
                    <div class="store_request_section_content">
                        <form name="store_request" id="store_request" enctype="multipart/form-data" method="post">
                            <h2 id="name_title">맛집이름 *</h2>
                            <div class="form_div">
                                <input type="text" id="name" class="box name_box">
                                <select id="type" class="box type_box">
                                    <option value="한식" seleceted>한식</option>
                                    <option value="중식">중식</option>
                                    <option value="일식">일식</option>
                                    <option value="양식">양식</option>
                                    <option value="패스트푸드">패스트푸드</option>
                                    <option value="카페&디저트">카페&디저트</option>
                                    <option value="술집">술집</option>
                                    <option value="기타">기타</option>
                                </select>
                            </div>
                            <div class="form_div" id="review_title">
                                <h2 style="display: inline-block;">리뷰 *</h2>
                                <div class="star_div">
                                    <span class="star">
                                      ★★★★★
                                      <span>★★★★★</span>
                                      <input type="range" id="rating" oninput="drawStar(this)" value="2" step="1" min="2" max="10">
                                    </span>
                                </div>
                            </div>
                            <textarea id="review" class="box review_box" maxlength="150" placeholder="0/150"></textarea>
                            <h2 id="location_title">위치 *</h2>
                            <div class="form_div3">
                                <input type="hidden" id="map_x" value="">
                                <input type="hidden" id="map_y" value="">
                                <input type="hidden" id="map_name" value="">
                                <input type="text" id="location" class="box location_box" placeholder="주소" disabled>
                                <input type="button" class="location_button" onclick="sample5_execDaumPostcode()" value="주소 검색">
                            </div>
                            <div id="map" class="box map_box">
                            </div>
                            <div class="menu_div" id="menu_title">
                                <div class="menu_list_div">
                                    <h2>메뉴판 *</h2>
                                    <label for="menu_list" class="box list_file_box"><img class="list_img" id="list_img" src="resources/img/list.jpg"></label>
                                    <input type="file" id="menu_list" accept="image/*">
                                    <input type="hidden" id="list_file">
                                </div>
                                <div class="menu_menu_div">
                                    <h2>대표메뉴 *</h2>
                                    <div class="form_div2">
                                        <input type="text" id="menu_name" class="box menu_name_box" placeholder="메뉴 이름">
                                        <input type="text" id="menu_price" class="box menu_price_box" placeholder="메뉴 가격"
                                               oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                    </div>
                                    <label for="menu_image" class="box menu_file_box"><img class="menu_img" id="menu_img" src="resources/img/menu.jpg"></label>
                                    <input type="file" id="menu_image" class="box menu_file_box" accept="image/*">
                                    <input type="hidden" id="menu_file">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="resources/js/store_request.js"></script>
<script>
    function session_check() {
        let check;
        <?php
        if(!isset($_SESSION['id'])) {
        ?>
        check = confirm("로그인이 필요합니다.\n로그인을 하시겠습니까?");
        if(check) {
            location.href = "login.php";
        } else {
            location.href = "main.php";
        }
        <?php
        }
        ?>
    }
    const drawStar = (target) => {
        document.querySelector(`.star span`).style.width = `${target.value * 10}%`;
    }
</script>
<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script src="//dapi.kakao.com/v2/maps/sdk.js?appkey=ba89a4b698092452d37cd2306f5f8e0b&libraries=services"></script>
<script>
    var mapContainer = document.getElementById('map'), // 지도를 표시할 div
        mapOption = {
            center: new daum.maps.LatLng(37.4999957879198, 126.868169656727), // 지도의 중심좌표
            level: 2 // 지도의 확대 레벨
        };

    //지도를 미리 생성
    var map = new daum.maps.Map(mapContainer, mapOption);
    //주소-좌표 변환 객체를 생성
    var geocoder = new daum.maps.services.Geocoder();
    //마커를 미리 생성
    var marker = new daum.maps.Marker({
        position: new daum.maps.LatLng(37.4999957879198, 126.868169656727),
        map: map
    });


    function sample5_execDaumPostcode() {
        new daum.Postcode({
            oncomplete: function(data) {
                var addr = data.address; // 최종 주소 변수


                // 주소 정보를 해당 필드에 넣는다.
                document.getElementById("location").value = addr;
                // 주소로 상세 정보를 검색
                geocoder.addressSearch(data.address, function(results, status) {
                    // 정상적으로 검색이 완료됐으면
                    if (status === daum.maps.services.Status.OK) {

                        var result = results[0]; //첫번째 결과의 값을 활용

                        // 해당 주소에 대한 좌표를 받아서
                        var coords = new daum.maps.LatLng(result.y, result.x);
                        document.getElementById("map_y").value = result.y;
                        document.getElementById("map_x").value = result.x;

                        // 지도를 보여준다.
                        mapContainer.style.display = "block";
                        map.relayout();
                        // 지도 중심을 변경한다.
                        map.setCenter(coords);
                        // 마커를 결과값으로 받은 위치로 옮긴다.
                        marker.setPosition(coords)

                    }
                });
            }
        }).open();
    }
</script>
</body>
</html>