function checkCapsLock(event, msg)  {
    message = document.getElementById(msg);
    if (event.getModifierState("CapsLock")) {
        message.className = "message";
        message.innerText = "Caps Lock이 켜져 있습니다.";
    }else {
        message.innerText = "";
    }
}