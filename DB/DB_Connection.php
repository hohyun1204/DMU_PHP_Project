<?php

class DB_Connection { // DB 연결하는 클래스
    private $con; // connection 저장하는 변수

    private function conn () { // DB 연결하는 메소드
        $this->con = mysqli_connect("localhost", "root", "", "store") or die ("Can't access DB"); // DB 연결 명령어
    }

    public function execute ($query) { // DB 쿼리문 실행하는 메소드
        try { // 실행 시마다 연결하고 실행하고 종료하기 위함.
            $this->conn(); // 메소드 호출해서 DB 연결

            return mysqli_query($this->con, $query); // DB 쿼리 실행 결과 반환
        } catch (Exception $e) {
            echo $e->getMessage() . ' (오류코드:' . $e->getCode() . ')'; // 오류 내용 출력
        } finally {
            mysqli_close($this->con); // DB 연결 종료 명령어
        }
    }
}