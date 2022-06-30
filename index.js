const button = document.getElementById("test");
button.addEventListener("click", function () {
    console.log("test");
    $.ajax({
        method: "GET",
        url: "./backend2.php",
    }).done(function (data) {
        console.log(data);
    })
});
