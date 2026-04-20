import { getContacts } from "../js/api.js"

let page = 0
const limit = 10

export default function () {
    return `
        <h1>Liste des contacts</h1>

        <a href="/Contactflow/front/create">Ajouter un contact</a>

        <input type="text" id="search" placeholder="Rechercher...">
        <div id="suggestions"></div>

        <div id="liste-contacts"></div>

        <div id="pagination">
            <button id="btnPrev">Précédent</button>
            <span id="numPage">Page 1</span>
            <button id="btnNext">Suivant</button>
        </div>
    `
}

export async function afterRender() {

    const search = document.getElementById("search")
    const suggestions = document.getElementById("suggestions")

    search.addEventListener("input", async () => {

        const value = search.value

        if (value === "") {
            suggestions.innerHTML = ""
            return
        }

        const response = await fetch(
            `http://localhost/Contactflow/api/index.php?action=search&name=${value}`
        )

        const data = await response.json()

        suggestions.innerHTML = ""

        data.forEach(contact => {
            const div = document.createElement("div")
            div.textContent = contact.nom + " " + contact.prenom

            div.onclick = () => {
                search.value = div.textContent
                suggestions.innerHTML = ""
            }

            suggestions.appendChild(div)
        })
    })

    // Pagination
    document.getElementById("btnNext").addEventListener("click", async () => {
        page++
        document.getElementById("numPage").textContent = "Page " + (page + 1)
        await chargerContacts()
    })

    document.getElementById("btnPrev").addEventListener("click", async () => {
        if (page > 0) {
            page--
            document.getElementById("numPage").textContent = "Page " + (page + 1)
            await chargerContacts()
        }
    })

    await chargerContacts()
}

async function chargerContacts() {
    const contacts = await getContacts(limit, page * limit)
    const list = document.getElementById("liste-contacts")

    if (contacts.length === 0) {
        list.innerHTML = "<p>Aucun contact trouvé</p>"
        return
    }

    list.innerHTML = contacts.map(c => `
        <p>
            ${c.nom} ${c.prenom}
            <a href="/Contactflow/front/detail?id=${c.id}">voir</a>
        </p>
    `).join("")
}