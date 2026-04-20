import { getContacts } from "../js/api.js"

let page = 0
const limit = 10

export default function() {
    return `
        <h1>Liste des contacts</h1>

        <a href="/Contactflow/front/create">Ajouter un contact</a>

        <input type="text" id="search" placeholder="Rechercher...">
        <div id="suggestions"></div>

        <div id="liste-contacts">chargement...</div>

        <div id="pagination">
            <button id="btnPrev">Précédent</button>
            <span id="numPage">Page 1</span>
            <button id="btnNext">Suivant</button>
        </div>
    `
}

export async function afterRender() {

    await chargerContacts()

    // Pagination
    document.getElementById("btnNext").addEventListener("click", async function() {
        page++
        document.getElementById("numPage").textContent = "Page " + (page + 1)
        await chargerContacts()
    })

    document.getElementById("btnPrev").addEventListener("click", async function() {
        if (page > 0) {
            page--
            document.getElementById("numPage").textContent = "Page " + (page + 1)
            await chargerContacts()
        }
    })

    // Barre de recherche — ton code existant
    let search = document.getElementById("search");
    let suggestions = document.getElementById("suggestions");

    search.addEventListener("input", async function () {

        let value = search.value;

        if (value === "") {
            suggestions.innerHTML = "";
            return;
        }

        let response = await fetch("http://localhost/Contactflow/api/public/index.php?action=search&name=" + value);
        let data = await response.json();

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

async function chargerContacts() {
    const contacts = await getContacts(limit, page * limit)
    const liste = document.getElementById("liste-contacts")

    if (contacts.length === 0) {
        liste.innerHTML = "<p>Aucun contact trouvé</p>"
        return
    }

    liste.innerHTML = contacts.map(contact => `
        <div>
            <p>${contact.nom} ${contact.prenom}</p>
            <p>${contact.email}</p>
            <p>${contact.phone}</p>
            <a href="/Contactflow/front/detail?id=${contact.id}">Voir</a>
        </div>
    `).join("")
}