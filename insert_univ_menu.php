<?php
include('simple_html_dom.php');
include_once("DB/DB_Connection.php"); // DB 연결하는 클래스 읽어오기

function insert($url) {
    $html = file_get_html($url);
    for($i = 1; $i <= 9; $i+=2) {
        $date = preg_split('/<br[^>]*>/i', $html->find('table tr', $i)->find('th', 0)->innertext)[0];
        $food1 = "";
        $food2 = "";
        if($html->find('table tr', $i)->find('td', 1)->innertext == '-') {
            $food1 = "-";
            $food2 = "-";
        } else {
            if(strpos(preg_split('/<br[^>]*>/i', $html->find('table tr', $i)->find('td', 2)->innertext)[0], '[') !== false) {
                $food1 = trim(explode('-', preg_replace('/\s+/', '-', preg_split('/<br[^>]*>/i', $html->find('table tr', $i)->find('td', 2)->innertext)[0], 1), 2)[1]);
                $food2 = trim(explode('-', preg_replace('/\s+/', '-', preg_split('/<br[^>]*>/i', $html->find('table tr', $i)->find('td', 2)->innertext)[1], 1), 2)[1]);
            } else {
                $food1 = trim(explode(' ', preg_split('/<br[^>]*>/i', $html->find('table tr', $i)->find('td', 2)->innertext)[0], 2)[1]);
                $food2 = trim(explode(' ', preg_split('/<br[^>]*>/i', $html->find('table tr', $i)->find('td', 2)->innertext)[1], 2)[1]);
            }
        }
        $connection = new DB_Connection(); // 객체 생성
        $connection->execute("insert into univ_menu values ('".$date."', '".$food1."', '".$food2."')");
    }
}

insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjEyLjEyJTI2d2VlayUzRHByZSUyNg%3D%3D');
insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjEyLjA1JTI2d2VlayUzRHByZSUyNg%3D%3D');
insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjExLjI4JTI2d2VlayUzRHByZSUyNg%3D%3D');
insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjExLjIxJTI2d2VlayUzRHByZSUyNg%3D%3D');
insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjExLjE0JTI2d2VlayUzRHByZSUyNg%3D%3D');
insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjExLjA3JTI2d2VlayUzRHByZSUyNg%3D%3D');
insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjEwLjMxJTI2d2VlayUzRHByZSUyNg%3D%3D');
insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjEwLjI0JTI2d2VlayUzRHByZSUyNg%3D%3D');
insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjEwLjE3JTI2d2VlayUzRHByZSUyNg%3D%3D');
insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjEwLjEwJTI2d2VlayUzRHByZSUyNg%3D%3D');
insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjEwLjAzJTI2d2VlayUzRHByZSUyNg%3D%3D');
insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjA5LjI2JTI2d2VlayUzRHByZSUyNg%3D%3D');
insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjA5LjE5JTI2d2VlayUzRHByZSUyNg%3D%3D');
insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjA5LjEyJTI2d2VlayUzRHByZSUyNg%3D%3D');
insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjA5LjA1JTI2d2VlayUzRHByZSUyNg%3D%3D');
insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjA4LjI5JTI2d2VlayUzRHByZSUyNg%3D%3D');
insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjA4LjIyJTI2d2VlayUzRHByZSUyNg%3D%3D');
insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjA4LjE1JTI2d2VlayUzRHByZSUyNg%3D%3D');
insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjA4LjA4JTI2d2VlayUzRHByZSUyNg%3D%3D');
insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjA4LjAxJTI2d2VlayUzRHByZSUyNg%3D%3D');
insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjA3LjI1JTI2d2VlayUzRHByZSUyNg%3D%3D');
insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjA3LjE4JTI2d2VlayUzRHByZSUyNg%3D%3D');
insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjA3LjExJTI2d2VlayUzRHByZSUyNg%3D%3D');
insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjA3LjA0JTI2d2VlayUzRHByZSUyNg%3D%3D');
insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjA2LjI3JTI2d2VlayUzRHByZSUyNg%3D%3D');
insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjA2LjIwJTI2d2VlayUzRHByZSUyNg%3D%3D');
insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjA2LjEzJTI2d2VlayUzRHByZSUyNg%3D%3D');
insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjA2LjA2JTI2d2VlayUzRHByZSUyNg%3D%3D');
insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjA1LjMwJTI2d2VlayUzRHByZSUyNg%3D%3D');
insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjA1LjIzJTI2d2VlayUzRHByZSUyNg%3D%3D');
insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjA1LjE2JTI2d2VlayUzRHByZSUyNg%3D%3D');
insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjA1LjA5JTI2d2VlayUzRHByZSUyNg%3D%3D');
insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjA1LjAyJTI2d2VlayUzRHByZSUyNg%3D%3D');
insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjA0LjI1JTI2d2VlayUzRHByZSUyNg%3D%3D');
insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjA0LjE4JTI2d2VlayUzRHByZSUyNg%3D%3D');
insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjA0LjExJTI2d2VlayUzRHByZSUyNg%3D%3D');
insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjA0LjA0JTI2d2VlayUzRHByZSUyNg%3D%3D');
insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjAzLjI4JTI2d2VlayUzRHByZSUyNg%3D%3D');
insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjAzLjIxJTI2d2VlayUzRHByZSUyNg%3D%3D');
insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjAzLjE0JTI2d2VlayUzRHByZSUyNg%3D%3D');
insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjAzLjA3JTI2d2VlayUzRHByZSUyNg%3D%3D');
insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjAyLjI4JTI2d2VlayUzRHByZSUyNg%3D%3D');
insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjAyLjIxJTI2d2VlayUzRHByZSUyNg%3D%3D');
insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjAyLjE0JTI2d2VlayUzRHByZSUyNg%3D%3D');
insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjAyLjA3JTI2d2VlayUzRHByZSUyNg%3D%3D');
insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjAxLjMxJTI2d2VlayUzRHByZSUyNg%3D%3D');
insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjAxLjI0JTI2d2VlayUzRHByZSUyNg%3D%3D');
insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjAxLjE3JTI2d2VlayUzRHByZSUyNg%3D%3D');
insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjAxLjEwJTI2d2VlayUzRHByZSUyNg%3D%3D');
insert('https://www.dongyang.ac.kr/dongyang/130/subview.do?enc=Zm5jdDF8QEB8JTJGZGlldCUyRmRvbmd5YW5nJTJGMSUyRnZpZXcuZG8lM0Ztb25kYXklM0QyMDIyLjAxLjAzJTI2d2VlayUzRHByZSUyNg%3D%3D');

echo "학식 데이터 DB에 저장 완료";