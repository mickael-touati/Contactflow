export default function() {
    return `
        <h1>Liste des contacts</h1>

        <a href="/create">Ajouter un contact</a>

        <input type="text" id="search" placeholder="Rechercher...">
        <div id="suggestions"></div>

        <div id="liste-contacts">chargement...</div>
    `
}


export function afterRender() {
console.log('icic')
    let search = document.getElementById("search");
    let suggestions = document.getElementById("suggestions");

    search.addEventListener("input", async function () {

        let value = search.value;

        if (value === "") {
            suggestions.innerHTML = "";
            return;
        }
        console.log('la')
        let response = await fetch("http://localhost/Contactflow/api/public/index.php?action=search&name=" + value);
        // let data = await response.json();

        const data = [
            {
                nom: "Gabriel",
                prenom:"Gabriel"
            },
            {
                nom: "Wassa",
                prenom:"Mohamed"
            }
        ]
        suggestions.innerHTML = "";

        for (let i = 0; i < data.length; i++) {

            let contact = data[i];

            let div = document.createElement("div");
            div.textContent = contact.nom + " " + contact.prenom;

            div.onclick = function () {
                search.value = contact.nom + " " + contact.prenom;
                suggestions.innerHTML = "";
            };

            suggestions.appendChild(div);
        }
    });
}

setTimeout(()=>{
afterRender()
},500)
