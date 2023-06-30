const resetDiv = document.querySelector('.reset-pass-back');
const resetButton = document.querySelector('#reset');
const cancelButton = document.querySelector('#cancel');

resetButton.addEventListener('click', () => {
    resetDiv.style.display = 'flex';
})

cancelButton.addEventListener('click', () => {
    resetDiv.style.display = 'none';
})
