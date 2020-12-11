function deletePopupFunction(id) {
    var popup = document.getElementById("deletePopup"+id);
    popup.classList.toggle("show");
}
function editPopupFunction(id) {
    var popup = document.getElementById("editPopup"+id);
    popup.classList.toggle("show");
}
function shareNotByAnOwnerPopupFunction(id) {
    var popup = document.getElementById("shareNotByAnOwnerPopup"+id);
    popup.classList.toggle("show");
}
function deleteNotByAnOwnerPopupFunction(id) {
    var popup = document.getElementById("deleteNotByAnOwnerPopup"+id);
    popup.classList.toggle("show");
}
function editNotByAnOwnerPopupFunction(id) {
    var popup = document.getElementById("editNotByAnOwnerPopup"+id);
    popup.classList.toggle("show");
}
