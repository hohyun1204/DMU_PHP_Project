<?php
    // 로그아웃 액션 페이지
    session_start(); // 세션 시작
    session_destroy(); // 세션 삭제
?>
<!-- 세션 삭제 후 메인 페이지로 이동 -->
<script>
    location.href="../main.php";  
</script>