const searchInput = document.getElementById("searchInput");

if(searchInput){

    searchInput.addEventListener("keyup", () => {

        console.log("Searching:", searchInput.value);

    });
}