const axios = require("axios");
const button = document.getElementByCLass("button");
button.addEventListener("click", function () {
    console.log("test");
    axios.get("./backend.php").then((resp) => {
        console.log(resp.data);
    });
});
