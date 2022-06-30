const button = document.getElementById("test");
button.addEventListener("click", ()=>{
    console.log("test");
    $.ajax({
        method: "GET",
        url: "./backend",
    }).done(function (data) {
        console.log(data);
    });
});
