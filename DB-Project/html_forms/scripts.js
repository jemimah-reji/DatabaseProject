// Function to validate required fields
function validateForm() {
    const requiredFields = document.querySelectorAll("[required]");
    let valid = true;

    requiredFields.forEach(field => {
        if (!field.value) {
            field.style.border = "2px solid red";
            valid = false;
        } else {
            field.style.border = "1px solid #ddd";
        }
    });

    if (!valid) {
        alert("Please fill in all required fields.");
    }
    return valid;
}
