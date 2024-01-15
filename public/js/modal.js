let modalId = null

function openModal(id) {
    document.getElementById(id).style.display = "flex";
    modalId = id
    
}

// Fonction pour fermer la modale
function closeModal() {
    document.getElementById(modalId).style.display = "none";
    modalID = null
}


// Fermer la modale si l'utilisateur clique en dehors de celle-ci
window.onclick = function(event) {
    var modal = document.getElementById(modalId);
    
    if (event.target === modal) {
        closeModal();
    }
    
}
