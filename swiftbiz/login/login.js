const btns = document.querySelector('.btns');

const form = document.querySelector('.form');
const staff = form.querySelector('.staff');
const student = form.querySelector('.student');
const management = form.querySelector('.management');

const passwordReset = form.querySelector('.form-card p a');
const backdrop = document.getElementById('backdrop');
const resetPassword = document.querySelector('.forgot-password');
const cancel = resetPassword.querySelector('.forgot-password button');
const reset = resetPassword.querySelector('input[type="submit"]');
const pTag = resetPassword.querySelector('p');
console.log(pTag);

function clearAll(){
    backdrop.style.visibility = 'hidden';
    resetPassword.style.display = 'none';
    pTag.textContent= '';
}

passwordReset.addEventListener('click', ()=>{
    backdrop.style.visibility = 'visible';
    resetPassword.style.display = 'block';
});

backdrop.addEventListener ('click', clearAll);
cancel.addEventListener ('click', clearAll);
reset.addEventListener ('click', ()=>{
    pTag.textContent= 'New password sent to email successfully!';
});