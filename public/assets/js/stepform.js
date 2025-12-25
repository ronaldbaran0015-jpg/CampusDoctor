

const steps = Array.from(document.querySelectorAll(".form-step"));
const transitions = [
    { trigger: "nextBtn", from: 0, to: 1, out: "slideOutLeft", in: "slideInRight", duration: 500 },
    { trigger: "prevBtn", from: 1, to: 0, out: "slideOutRight", in: "slideInLeft", duration: 600 },
    { trigger: "nextBtn2", from: 1, to: 2, out: "slideOutLeft", in: "slideInRight", duration: 500 },
    { trigger: "prevBtn2", from: 2, to: 1, out: "slideOutRight", in: "slideInLeft", duration: 600 }
];

const validateForm = ()=>{
    const fields = document.querySelectorAll('.required');
    let isValid = true;
    fields.forEach(field=>{
       
        const value = field.value.trim();
        if(value==''){
            isValid=false;
           
            
        }else{
            isValid=true;
           

        }
    
    });
    if (!isValid) {
        
        Swal.fire({
            position: "top",
            toast: true,
            showConfirmButton: false,
            timer: 1000,
            timerProgressBar: true,
            icon: "warning",
            title: "Please fill the required fields"
        });
       
    }
    return isValid;
}


function animateStep(from, to, outAnim, inAnim, duration) {
    steps[from].style.animation = `${outAnim} ${duration / 1000}s forwards`;
    setTimeout(() => {
        steps[from].classList.remove("active");
        steps[to].classList.add("active");
        steps[to].style.animation = `${inAnim} ${duration / 1000}s forwards`;
    }, duration);
}
// Function to validate the form inputs
function validateInputs(inputs) {
    let isValid = true;
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    const phoneRegex = /^(\+63|0)9\d{9}$/; // Philippine phone number pattern

    inputs.forEach(input => {
        const value = input.value.trim();
        if (!value) {
            isValid = false;
            input.style.border = '1px solid #ef4444';
        } else {
            if (input.type === 'email' && !emailRegex.test(value)) {
                isValid = false;
                input.style.border = '1px solid #ef4444';
                Swal.fire({
                    position: "top",
                    toast: true,
                    showConfirmButton: false,
                    timer: 1000,
                    timerProgressBar: true,
                    icon: "warning",
                    title: "Invalid email format"
                });
            } else if (input.type === 'tel' && !phoneRegex.test(value)) {
                isValid = false;
                input.style.border = '1px solid #ef4444';
                Swal.fire({
                    position: "top",
                    toast: true,
                    showConfirmButton: false,
                    timer: 1000,
                    timerProgressBar: true,
                    icon: "warning",
                    title: "Invalid phone number format"
                });
            } else {
                input.style.border = '';
            }
        }
    });
    return isValid;
}

// Function to handle the button clicks
function handleButtonClick(trigger, from, to, out, inAnim, duration) {
    const currentStep = steps[from];
    const inputs = currentStep.querySelectorAll('input, select');

    if (trigger.includes('next')) {
        if (!validateInputs(inputs)) {
            Swal.fire({
                position: "top",
                toast: true,
                showConfirmButton: false,
                timer: 1000,
                timerProgressBar: true,
                icon: "warning",
                title: "Please Fill all required fields"
            });
            return;
        }
    }

    animateStep(from, to, out, inAnim, duration);
}

// Add event listeners to the buttons
transitions.forEach(({ trigger, from, to, out, in: inAnim, duration }) => {
    const btn = document.getElementById(trigger);
    if (btn) {
        btn.addEventListener("click", () => handleButtonClick(trigger, from, to, out, inAnim, duration));
    }
});