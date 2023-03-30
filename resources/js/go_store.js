function store(store_idx) {
    let form = document.createElement("form");
    form.setAttribute("charset", "UTF-8");
    form.setAttribute("method", "post");  //Post 방식
    form.setAttribute("action", "store.php"); //요청 보낼 주소

    let hiddenField = document.createElement("input");
    hiddenField.setAttribute("type", "hidden");
    hiddenField.setAttribute("name", "store_idx");
    hiddenField.setAttribute("value", store_idx);
    form.appendChild(hiddenField);

    document.body.appendChild(form);
    form.submit();
}