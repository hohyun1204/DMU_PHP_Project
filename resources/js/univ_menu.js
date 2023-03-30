function move_date(direction) {
    if(document.getElementById("day").value == "2021-12-27" && direction == "pre") {
        alert("이전 데이터는 존재하지 않습니다.");
    } else {
        document.getElementById("move").value = direction;
        document.getElementById("day_form").submit();
    }
}