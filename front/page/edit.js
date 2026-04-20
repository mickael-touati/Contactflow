import { getContact, updateContact } from "../js/api.js"
import { router } from "../js/router.js"

export default function() {
    return `
        <h1>Modifier le contact</h1>
        <a href="/Contactflow/front/">Retour</a>
        <form>
            <input type="text" id="nom" placeholder="Nom" />
            <input type="text" id="prenom" placeholder="Prénom" />
            <input type="text" id="email" placeholder="Email" />
            <input type="text" id="phone" placeholder="Téléphone" />
            <button type="button" id="btnModifier">Modifier</button>
        </form>
    `
}

export async function afterRender() {
    //recuperer l'id dans l'URL
    const params = new URLSearchParams(location.search)
    const id = params.get("id")

    // Pré-remplir le formulaire
    const contact = await getContact(id)
    document.getElementById("nom").value = contact.nom
    document.getElementById("prenom").value = contact.prenom
    document.getElementById("email").value = contact.email
    document.getElementById("phone").value = contact.phone

    // Modifier
    document.getElementById("btnModifier").addEventListener("click", async function() {
        const contactModifie = {
            nom: document.getElementById("nom").value,
            prenom: document.getElementById("prenom").value,
            email: document.getElementById("email").value,
            phone: document.getElementById("phone").value
        }

        await updateContact(id, contactModifie)
        history.pushState({}, "", "/Contactflow/front/")
        router()
    })
}