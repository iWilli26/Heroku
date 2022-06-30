const button = document.getElementById("test");
button.addEventListener("click", function () {
    $.ajax({
        method: "GET",
        url: "./backend.php",
    }).done(function (data) {
        console.log(data);
    });
});
