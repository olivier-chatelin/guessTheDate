
const addBadgeButton = document.getElementById('addBadgeButton');
const uploadForm = document.getElementById('uploadForm');
addBadgeButton.addEventListener('click',()=>{
    uploadForm.classList.toggle('d-none');
})