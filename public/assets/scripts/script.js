const areas = document.getElementsByClassName('area');
const image = document.getElementById('Image-Maps-Com-image-maps');
const cardImage = document.getElementById('card-img');
const cardText = document.getElementById('card-text');
const addBadgeButton = document.getElementById('addBadgeButton');
const uploadForm = document.getElementById('uploadForm');


for (const area of areas) {
    area.addEventListener('mouseenter',event =>{
        image.src =`/assets/images/maps/${event.target.alt}.png`;
        cardImage.src= `/assets/images/departments/${event.target.id}.jpg`;
        cardText.innerHTML = event.target.title;
    })
    area.addEventListener('mouseleave',() =>{
        image.src ='/assets/images/maps/met.png';
    })

}
window.addEventListener('resize',initSize);

function initSize(){
    let scale = window.innerWidth/1920;
    let step = (0);
    if (window.innerWidth < 1500) step = (window.innerWidth-1500);
    image.style.transform = `scale(${scale}) translate(${step}px)`;
}
addBadgeButton.addEventListener('click',()=>{
    uploadForm.classList.toggle('d-none');
})

initSize();

