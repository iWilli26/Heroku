import axios from "axios";
const button = document.getElementById("button");
button.addEventListener("click", function () {
    console.log("test");
    axios.get("./backend.php").then((resp) => {
        console.log(resp.data);
    });
});
