import axios from "axios";
const button = document.getElementById("button");
button.addEventListener("click", function () {
    axios.get("./backend.php").then((resp) => {
        console.log(resp.data);
    });
});
