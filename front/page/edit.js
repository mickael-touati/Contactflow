import { getContact, updateContact } from "../js/api.js"
import { router } from "../js/router.js"

export default function () {
    return `
        <h1>Modifier</h1>

        <input id="nom">
        <input id="prenom">
        <input id="email">
        <input id="phone">

        <button id="btn">Modifier</button>
    `
}

export async function afterRender() {

    const id = new URLSearchParams(location.search).get("id")

    const contact = await getContact(id)

    nom.value = contact.nom
    prenom.value = contact.prenom
    email.value = contact.email
    phone.value = contact.phone

    document.getElementById("btn").onclick = async () => {

        await updateContact(id, {
            nom: nom.value,
            prenom: prenom.value,
            email: email.value,
            phone: phone.value
        })

        history.pushState({}, "", "/Contactflow/front/")
        router()
    }
}