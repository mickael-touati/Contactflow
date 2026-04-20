import { createContact } from "../js/api.js"
import { router } from "../js/router.js"

export default function() {
    return `
        <h1>Créer un contact</h1>
        <a href="/Contactflow/front/">Retour</a>
        <form>
            <input type="text" id="nom" placeholder="Nom" />
            <input type="text" id="prenom" placeholder="Prénom" />
            <input type="text" id="email" placeholder="Email" />
            <input type="text" id="phone" placeholder="Téléphone" />
            <button type="button" id="btnCreer">Créer</button>
        </form>
    `
}

export async function afterRender() {
    document.getElementById("btnCreer").addEventListener("click", async function() {
        const contact = {
            nom: document.getElementById("nom").value,
            prenom: document.getElementById("prenom").value,
            email: document.getElementById("email").value,
            phone: document.getElementById("phone").value
        }

        await createContact(contact)
        
        // Retour à l'accueil après création
        history.pushState({}, "", "/Contactflow/front/")
        router()
    })
}