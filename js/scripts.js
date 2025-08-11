function validateRegister(){
    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    const phone = document.getElementById('phone').value.trim();
    const pass = document.getElementById('password').value.trim();
    if(!name || !email || !phone || !pass){
        alert('Please fill all required fields');
        return false;
    }
    const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\\.,;:\s@\"]+\.)+[^<>()[\]\\.,;:\s@\"]{2,})$/i;
    if(!re.test(email)){
        alert('Enter a valid email');
        return false;
    }
    return true;
}

function validateLogin(){
    const email = document.getElementById('email').value.trim();
    const pass = document.getElementById('password').value.trim();
    if(!email || !pass){ alert('Please enter login credentials'); return false; }
    return true;
}

function validateAppointment(){
    const doctor = document.getElementById('doctor_id').value;
    const date = document.getElementById('appointment_date').value;
    const time = document.getElementById('appointment_time').value;
    if(!doctor || !date || !time){ alert('Select doctor, date and time'); return false; }
    return true;
}
