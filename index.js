const button = document.getElementById("test");
button.addEventListener("click", function () {
    $.ajax({
        method: "GET",
        url: "./backend.php?id=1",
    }).done(function (data) {
        console.log(data);
    });
});
