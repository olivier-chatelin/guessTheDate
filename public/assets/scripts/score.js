const awesomes = document.getElementsByClassName('anon-podium');
for (let awesome of awesomes){
let parent = awesome.parentElement;
console.log(parent);
let parentWidth = parent.offsetWidth;
    awesome.style.fontSize = parentWidth/2-15+"px";
}
