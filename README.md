# DMU_PHP_Project
PHP 학교 근처 맛집 제보 및 리뷰 사이트

## 💻 프로젝트 소개
대학교 근처에 있는 맛집을 제보하고 리뷰를 작성하는 사이트입니다.

## ⏰ 개발 기간
- 22.11.02 ~ 22.12.12

### ⚙ 개발 환경
- Xampp
- Apache
- PHP
- MySQL

## 📌 주요 기능
#### 로그인
- 회원 DB 검증
#### 회원가입
- ID 중복 체크
#### 메인 페이지
- 맛집 랜덤 추천
#### 맛집 찾기 페이지
- 카테고리 선택
- 지도 API 연동
- 리뷰 작성
#### 맛집 제보 페이지
- 지도 API 연동
- 맛집 DB 검증
- 리뷰 작성
#### 학식 페이지
- 학식 데이터 크롤링

## 📢 실행 방법
- MySQL UTF-8 설정 (my.ini)
- 데이터베이스와 테이블 생성 (query.sql)
- DB 연결 구문 확인 (DB_Connection.php)
- 이미지 파일 저장 경로 확인 (request_action.php)
- 현재 페이지 확인을 위한 substr 구문 확인 (header.php)
- 폰트 다운 (/fonts)
- 이전 학식 데이터 삽입 페이지 실행 (insert_univ_menu.php)