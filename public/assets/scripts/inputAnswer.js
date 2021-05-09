const answer = document.getElementById('answer');
const footer =document.getElementById('footer');
answer.addEventListener('focusin',()=>{
    if (window.innerWidth <= 768){
        footer.classList.add('d-none');
    }
})
answer.addEventListener('focusout',()=>{
    if (window.innerWidth <= 768){
        footer.classList.remove('d-none');
    }
})