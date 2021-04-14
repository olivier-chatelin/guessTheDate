const areas = document.getElementsByClassName('area');
const image = document.getElementById('Image-Maps-Com-image-maps');
const cardImage = document.getElementById('card-img');
const cardText = document.getElementById('card-text');


console.log(cardImage);
for (const area of areas) {
    area.addEventListener('mouseenter',event =>{
        image.src =event.target.alt+'.png';
        cardImage.src= 'departements/'+event.target.id+'.jpg';
        cardText.innerHTML = event.target.title;
    })
    area.addEventListener('mouseleave',() =>{
        image.src ='met.png';
    })

}
window.addEventListener('resize',initSize);

function initSize(){
    let scale = window.innerWidth/1920;
    let step = (0);
    if (window.innerWidth < 1500) step = (window.innerWidth-1500);
    image.style.transform = `scale(${scale}) translate(${step}px)`;
}



initSize();