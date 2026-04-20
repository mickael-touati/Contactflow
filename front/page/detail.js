import { getContact, deleteContact } from "../js/api.js"
import { router } from "../js/router.js"

export default function() {
    return `
        <h1>Détail du contact</h1>
        <a href="/Contactflow/front/">Retour</a>
        <div id="detail-contact">chargement...</div>
        <a href="/Contactflow/front/edit">Modifier ce contact</a>
        <button type="button" id="btnSupprimer">Supprimer</button>
    `
}

export async function afterRender() {
    //recuperer l'id dans l'URL
    const params = new URLSearchParams(location.search)
    const id = params.get("id")

    // Charger le contact
    const contact = await getContact(id)

    document.getElementById("detail-contact").innerHTML = `
        <p>Nom : ${contact.nom}</p>
        <p>Prénom : ${contact.prenom}</p>
        <p>Email : ${contact.email}</p>
        <p>Téléphone : ${contact.phone}</p>
    `

    document.querySelector("a[href='/Contactflow/front/edit']").href = "/Contactflow/front/edit?id=" + id

    // Supprimer
    document.getElementById("btnSupprimer").addEventListener("click", async function() {
        await deleteContact(id)
        history.pushState({}, "", "/Contactflow/front/")
        router()
    })
}