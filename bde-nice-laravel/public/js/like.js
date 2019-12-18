console.log('Starting script');

let pageUrl = document.documentURI;
let id = pageUrl.split('/')[4];
let baseUrl = 'http://localhost:8080/';
let element = document.getElementById("likeCount");
let error = document.getElementById("error");


function updateLikes() {

    element.innerText = "J'aime (Chargement...)";

    fetch(baseUrl + 'like/' + id)
        .then(res => res.json())
        .then(data => {
            element.innerText = "J'aime (" + data + ")";
        });
}

element.addEventListener('click', function(event){
    fetch(baseUrl + 'likeEvent/' + id)
        .then(res => res.json())
        .then(data => {
            let message= "";

            switch (data) {
                case '200':
                    message = "J'aime !";
                    break;
                case '403':
                    message = "Déjà aimé !";
                    break;
                case '401':
                    message = "Vous devez être connecté pour aimer un commentaire";
                    break;
                default:
                    message = "Erreur inconnue (" + data + ")";
            }

            error.innerText = message;
        });

    updateLikes();
});

updateLikes();
