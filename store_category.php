<!doctype html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="resources/css/common.css" rel="stylesheet" type="text/css" />
    <link href="resources/css/store_category.css" rel="stylesheet" type="text/css" />
    <title>DMU 맛집</title>
</head>
<body>
<div class="main">
    <header>
        <?php include_once("header.php");?>
    </header>
    <section>
        <div class="store_category">
            <div class="store_category_header">
                <img src="resources/img/store_info.png">
            </div>
            <div class="store_category_section">
                <img src="resources/img/store_category.png" class="store_category_img" usemap="#CategoryMap">
                <map name="CategoryMap" id="CategoryMap">
                    <area shape="poly" coords="44,10,23,21,10,43,12,194,24,211,42,219,268,219,287,206,296,190,296,40,286,23,267,11" onclick="location.href='store_list.php?category=1'">
                    <area shape="poly" coords="342,10,321,21,308,43,310,194,322,211,340,219,566,219,585,206,594,190,594,40,584,23,565,11" onclick="location.href='store_list.php?category=2'">
                    <area shape="poly" coords="639,10,618,21,605,43,607,194,619,211,637,219,863,219,882,206,891,190,891,40,881,23,862,11" onclick="location.href='store_list.php?category=3'">
                    <area shape="poly" coords="937,10,916,21,903,43,905,194,917,211,935,219,1161,219,1180,206,1189,190,1189,40,1179,23,1160,11" onclick="location.href='store_list.php?category=4'">
                    <area shape="poly" coords="44,230,23,241,10,263,12,414,24,431,42,439,268,439,287,426,296,410,296,260,286,243,267,231" onclick="location.href='store_list.php?category=5'">
                    <area shape="poly" coords="342,230,321,241,308,263,310,414,322,431,340,439,566,439,585,426,594,410,594,260,584,243,565,231" onclick="location.href='store_list.php?category=6'">
                    <area shape="poly" coords="639,230,618,241,605,263,607,414,619,431,637,439,863,439,882,426,891,410,891,260,881,243,862,231" onclick="location.href='store_list.php?category=7'">
                    <area shape="poly" coords="937,230,916,241,903,263,905,414,917,431,935,439,1161,439,1180,426,1189,410,1189,260,1179,243,1160,231" onclick="location.href='store_list.php?category=8'">
                </map>
            </div>
        </div>
    </section>
</div>
</body>
</html>