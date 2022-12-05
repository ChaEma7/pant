// åbner og lukker popup ved at tilføje klassen active på id'et
function togglePopup() {
  document.getElementById("popup-delete").classList.toggle("active");
}

// sørger for, at kun en chekbox i en gruppe kan være chekket
function onlyOne(checkbox) {
  var checkboxes = document.getElementsByName("pickup");
  checkboxes.forEach((item) => {
    if (item !== checkbox) item.checked = false;
  });
}
