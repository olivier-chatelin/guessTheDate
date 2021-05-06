const likeButton = document.getElementById('heart-logo');
console.log(likeButton);
const options = {
    method: "POST",
    body: likeButton.dataset.tosend,
    headers: {
        'Content-Type': 'application/json'
    }
}

likeButton.addEventListener('click', e => {
    likeButton.classList.toggle('clicked')
    likeButton.classList.toggle('unclicked')
    fetch('/Gallery/action', options)
        .then(response => response.json())
})