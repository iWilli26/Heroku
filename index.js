import axios from "axios";
const button = document.getElementById("button");
button.addEventListener("click", function () {
    axios.get("https://hdm-fpdf.herokuapp.com").then((resp) => {
        console.log(resp.data);
    });
});
