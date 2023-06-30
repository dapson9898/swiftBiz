const backdrop = document.getElementById('backdrop');
// const addBtn = document.querySelector('.add');
const contain = document.querySelector('.container');
const themeToggler = document.querySelector('.icons');
// const activityDiv = document.querySelectorAll('.activity');
const rightAside = document.querySelector('.add-costomer');
const close = document.querySelector('form .head button');
const cancel = document.querySelector('form .bottom .cancel');
// const addCust = document.getElementById('add-cust');
const IGot = document.querySelector('.bal .butt button');
const IGave = document.querySelector('.bal .butt button:last-of-type');
// const addMoney = document.getElementById('add-money');
// const minusMoney = document.getElementById('minus-money');

const customerBtn = document.querySelector('.customer');
const supplierBtn = document.querySelector('.supplier');

const cusBtn = document.querySelector('#cus');
const supBtn = document.querySelector('#sup');

const creditItems = document.querySelectorAll('.credit');

const report = document.querySelector(".report-components");
const account = document.querySelector('.account-component');

const calenderContainer = document.querySelector('.calender');
const calenderBtn = document.querySelector('#calenderBtn');

const creditForm = document.querySelector('#credit-form');
const debitForm = document.querySelector('#debit-form');
const creditBtn = document.querySelector('#credit-btn');
const debitBtn = document.querySelector('#debit-btn');


const filter = document.querySelector('.filter');
const filterBtn = document.querySelector('#filter');

filterBtn.addEventListener('click', () => {
    filter.classList.toggle('hidden');
})

calenderBtn.addEventListener('click', () => {
    calenderContainer.classList.toggle('hidden');
})

// calender variables
const prevBtn = document.querySelector('#prevBtn');
const nextBtn = document.querySelector('#nex-btn');
var monthAndYear = document.querySelector('#month-and-year');
var daysContainer = document.querySelector('.days');

var currentDate = new Date();

// Event listeners for previous and next buttons
prevBtn.addEventListener('click', function() {
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar();
});
    
nextBtn.addEventListener('click', function() {
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderCalendar();
});

        // Render the initial calendar
renderCalendar();

        // Function to render the calendar
function renderCalendar() {
    daysContainer.innerHTML = '';
    monthAndYear.innerHTML = currentDate.toLocaleDateString('en-us', { month: 'long', year: 'numeric' });
    var firstDay = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
    var daysInMonth = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0).getDate();
    var startingDay = firstDay.getDay();
    for (var i = 0; i < startingDay; i++) {
        var cell = document.createElement('div');
        daysContainer.appendChild(cell);
    }

    // Create cells for each day in the month
    for (var i = 1; i <= daysInMonth; i++) {
    var cell = document.createElement('div');
    cell.textContent = i;
    daysContainer.appendChild(cell);
    }
}

creditItems.forEach(function(item) {
    item.addEventListener('click', function(){
        creditItems.forEach(function(conItem) {
            conItem.classList.remove('active');
        });
        
        item.classList.add('active');
        currentClient.innerHTML = item.querySelector('section p').innerHTML;
        
    })
})

// dark theme toggler
themeToggler.addEventListener('click', () => {
    document.body.classList.toggle('dark-theme');
    themeToggler.querySelector('span:nth-child(1)').classList.toggle('active');
    themeToggler.querySelector('span:nth-child(2)').classList.toggle('active');
})

// activityDiv.forEach(activity => {
//     activity.addEventListener('click', () => {
//         let p = activity.querySelector('.p-container');
//         let btn = activity.querySelector('button');
//         if(p.style.display == 'none'){
//             p.style.display = 'block';
//             btn.textContent = '-';
//         }else{
//             p.style.display = 'none';
//             btn.textContent = '+';
//         }
//     })
// })

function addBackdrop(){
    backdrop.classList.add('visible');
}

function removeBackdrop(){
    backdrop.classList.remove('visible');
    addCust.style.display= 'none'
    addMoney.style.display= 'none'
    minusMoney.style.display= 'none'
    creditForm.style.display= 'none'
    debitForm.style.display= 'none'
}
reportBtn.addEventListener('click', ()=>{
    account.style.display = 'none'
    report.style.display = 'flex'
    dashboard.style.display = 'none';
    cashbook.style.display = 'none';
    creditbook.style.display = 'none';
    rightAside.style.display = 'none';
    contain.style.gridTemplateColumns = '1fr 4fr';
    heading.innerHTML= 'REPORTS';
})
accountBtn.addEventListener('click',()=>{
    account.style.display = 'flex'
    report.style.display = 'none'
    dashboard.style.display = 'none';
    cashbook.style.display = 'none';
    creditbook.style.display = 'none';
    rightAside.style.display = 'none';
    contain.style.gridTemplateColumns = '1fr 4fr';
    heading.innerHTML= 'ACCOUNT';
})

addBtn.addEventListener('click', ()=>{
    backdrop.classList.add('visible');
    addCust.style.display= 'flex'
})

IGot.addEventListener('click', ()=>{
    backdrop.classList.add('visible');
    addMoney.style.display= 'flex'
})

IGave.addEventListener('click', ()=>{
    backdrop.classList.add('visible');
    minusMoney.style.display= 'flex'
})

close.addEventListener('click', removeBackdrop)
cancel.addEventListener('click', removeBackdrop)

addMoney.querySelector('.bottom button.cancel').addEventListener('click', removeBackdrop)
addMoney.querySelector('.head button').addEventListener('click', removeBackdrop)

minusMoney.querySelector('.head button').addEventListener('click', removeBackdrop);
minusMoney.querySelector('.bottom .cancel').addEventListener('click', removeBackdrop);


backdrop.addEventListener('click', removeBackdrop)

customerBtn.addEventListener('click', () => {
    supplierBtn.classList.remove('active');
    customerBtn.classList.add('active');
})
supplierBtn.addEventListener('click', () => {
    customerBtn.classList.remove('active');
    supplierBtn.classList.add('active');
})

cusBtn.addEventListener('click', () => {
    supBtn.classList.add('active');
    cusBtn.classList.remove('active');
})
supBtn.addEventListener('click', () => {
    cusBtn.classList.remove('active');
    supBtn.classList.add('active');
})


const demand = document.getElementById('demand')
const supply = document.getElementById('supply')
        
customerBtn.addEventListener('click', ()=>{
    demand.style.display = 'block'
    supply.style.display = 'none'
})
        
        
supplierBtn.addEventListener('click', ()=>{
    demand.style.display = 'none'
    supply.style.display = 'block'
})
        
const currentClient = document.getElementById('current-client')
    const firstLetter = demand.querySelector('section p').innerHTML[0]
    const letter = demand.querySelector('.img')
    console.log(firstLetter)
    letter.innerHTML = firstLetter
        
        // credit and debit form
creditBtn.addEventListener('click', () => {
    backdrop.classList.add('visible');
    creditForm.style.display = 'block';
})

debitBtn.addEventListener('click', () => {
    backdrop.classList.add('visible');
    debitForm.style.display = 'block';
})