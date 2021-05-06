$(document).ready(function(){
    if(document.getElementById('badgeModal').dataset.shouldreceivebadge !== '0') {
        $("#badgeModal").modal('show');
    }
});