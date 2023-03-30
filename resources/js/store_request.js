$(function() {
    $('#menu_list').change(function(e) {
        const uploadFiles = [];
        const files = e.currentTarget.files;
        const imagePreview = document.querySelector('#list_img');
        [...files].forEach(file => {
            if (!file.type.match("image/.*")) {
                alert('이미지 파일만 업로드가 가능합니다.');
                if($('#list_file').val()) {;
                    document.getElementById("list_file").value = "";
                    document.getElementById("list_img").src = "resources/img/list.jpg"
                }
                return false;
            } else {
                document.getElementById("list_file").value = document.getElementById("menu_list").value;
                uploadFiles.push(file);
                const reader = new FileReader();
                reader.onload = (e) => {
                    imagePreview.setAttribute("src", e.target.result);
                    imagePreview.setAttribute("data-file", file.name);
                };
                reader.readAsDataURL(file);
            }
        });
        if(!$('#list_file').val()) {
            document.getElementById("menu_list").value = "";
        }
        if($('#menu_list').val() == "" && $('#list_file').val()) {
            document.getElementById("list_img").src = "resources/img/list.jpg";
        }
    });
    $('#menu_image').change(function(e) {
        const uploadFiles = [];
        const files = e.currentTarget.files;
        const imagePreview = document.querySelector('#menu_img');
        [...files].forEach(file => {
            if (!file.type.match("image/.*")) {
                alert('이미지 파일만 업로드가 가능합니다.');
                if($('#menu_file').val()) {;
                    document.getElementById("menu_file").value = "";
                    document.getElementById("menu_img").src = "resources/img/menu.jpg"
                }
                return false;
            } else {
                document.getElementById("menu_file").value = document.getElementById("menu_image").value;
                uploadFiles.push(file);
                const reader = new FileReader();
                reader.onload = (e) => {
                    imagePreview.setAttribute("src", e.target.result);
                    imagePreview.setAttribute("data-file", file.name);
                };
                reader.readAsDataURL(file);
            }
        });
        if(!$('#menu_file').val()) {
            document.getElementById("menu_image").value = "";
        }
        if($('#menu_image').val() == "" && $('#list_file').val()) {
            document.getElementById("menu_img").src = "resources/img/menu.jpg";
        }
    });
    $('#submit').click(function() {
        if(!$('#name').val().trim()) {
            alert("맛집 이름을 입력해주세요");
            $('#name').focus();
        } else if(!$('#review').val().trim()) {
            alert("리뷰를 작성해주세요");
            $('#review').focus();
        } else if(!$('#location').val()) {
            alert("주소를 입력해주세요");
            $("#location_title").attr("tabindex", -1).focus();
        } else if(!$('#menu_list').val() || $('#list_file').val() == "") {
            alert("메뉴판 사진을 올려주세요");
            $("#menu_title").attr("tabindex", -1).focus();
        } else if(!$('#menu_name').val().trim()) {
            alert("메뉴 이름을 입력해주세요");
            $('#menu_name').focus();
        } else if(!$('#menu_price').val().trim()) {
            alert("메뉴 가격을 입력해주세요");
            $('#menu_price').focus();
        } else if(!$('#menu_image').val() || $('#menu_file').val() == "") {
            alert("음식 사진을 올려주세요");
            $("#menu_title").attr("tabindex", -1).focus();
        } else {
            var formData = new FormData();
            formData.append("name", $('#name').val());
            formData.append("type", $('#type').val());
            formData.append("location", $('#location').val());
            formData.append("map_x", $('#map_x').val());
            formData.append("map_y", $('#map_y').val());
            formData.append("menu_name", $('#menu_name').val());
            formData.append("menu_price", $('#menu_price').val());
            formData.append("menu_list", $("#menu_list")[0].files[0]);
            formData.append("menu_image", $("#menu_image")[0].files[0]);
            let ok;
            $.ajax({
                url: "action/request_action.php",
                type: "POST",
                enctype: 'multipart/form-data',
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function(res) {
                    if(res.split('.', 1) == 'success') {
                        review_action(res.substr(8));
                        alert("맛집 제보가 완료되었습니다.\n감사합니다.");
                        location.href = "main.php";
                    } else {
                        ok = confirm("중복된 맛집입니다.\n리뷰만 작성하시겠습니까?");
                        if(ok) {
                            review_action(res);
                            alert("리뷰 작성이 완료되었습니다.\n감사합니다.");
                            location.href = "main.php";
                        } else {
                            location.href = "main.php";
                        }
                    }
                }
            });
        }
    });
});
function review_action(res) {
    $.ajax({
        url: "action/review_action.php",
        type: "POST",
        data: {
            store_idx : res,
            rating : $('#rating').val(),
            review : $('#review').val()
        },
        success: function(res) {
        }
    });
}