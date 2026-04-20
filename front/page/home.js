import { getContacts } from "../js/api.js"

export default function () {
    return `
        <h1>Liste des contacts</h1>

        <a href="/Contactflow/front/create">Ajouter un contact</a>

        <input type="text" id="search" placeholder="Rechercher...">
        <div id="suggestions"></div>

        <div id="liste-contacts"></div>
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

    const contacts = await getContacts()
    const list = document.getElementById("liste-contacts")

    list.innerHTML = contacts.map(c => `
        <p>
            ${c.nom} ${c.prenom}
            <a href="/Contactflow/front/detail?id=${c.id}">voir</a>
        </p>
    `).join("")
}