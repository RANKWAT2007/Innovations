function validateForm(){

    const inputs = document.querySelectorAll("input[required]");

    let valid = true;

    inputs.forEach(input => {

        if(input.value.trim() === ""){

            input.style.border = "2px solid red";

            valid = false;

        }else{

            input.style.border = "1px solid #ccc";
        }
    });

    return valid;
}