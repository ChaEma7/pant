// åbner og lukker popup ved at tilføje klassen active på id'et
function togglePopup() {
  document.getElementById("popup-delete").classList.toggle("active");
}

function togglePopupReleaseTask() {
  document.getElementById("popup-frigiv").classList.toggle("active");
}

function togglePopupBookTask() {
  document.getElementById("popup-book").classList.toggle("active");
}

// sørger for, at kun en chekbox i en gruppe kan være chekket
function onlyOne(checkbox) {
  var checkboxes = document.getElementsByName("pickup");
  checkboxes.forEach((item) => {
    if (item !== checkbox) item.checked = false;
  });
}

//søger for at fremvise den ønskede section under opgaver
// function btn_allTasks() {
//   const x = document.getElementById("allTasks");
//   if (x.style.display === "block") {
//     x.style.display = "none";
//     document.getElementById("all-tasks-btn").classList.remove("active-btn");
//   } else {
//     x.style.display = "block";
//     document.getElementById("yourTasks").style.display = "none";
//     document.getElementById("your-tasks-btn").classList.remove("active-btn");
//     document.getElementById("all-tasks-btn").classList.add("active-btn");
//   }
// }

// // function btn_yourTasks() {
// //   const x = document.getElementById("yourTasks");
// //   if (x.style.display === "block") {
// //     x.style.display = "none";
// //     document.getElementById("your-tasks-btn").classList.remove("active-btn");
// //   } else {
// //     x.style.display = "block";
// //     document.getElementById("allTasks").style.display = "none";
// //     document.getElementById("all-tasks-btn").classList.remove("active-btn");
// //     document.getElementById("your-tasks-btn").classList.add("active-btn");
// //   }
// // }

// // document.querySelector("#all-tasks-btn").onclick = () => btn_allTasks();
// // document.querySelector("#your-tasks-btn").onclick = () => btn_yourTasks();
