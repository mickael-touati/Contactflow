export default function() {
    return `
        <h1>Créer un contact</h1>
        <a href="/Contactflow/front/">Retour</a>
        <form>
            <input type="text" id="nom" placeholder="Nom" />
            <input type="text" id="prenom" placeholder="Prénom" />
            <input type="text" id="email" placeholder="Email" />
            <input type="text" id="telephone" placeholder="Téléphone" />
            <button type="button" id="btnCreer">Créer</button>
        </form>
    `
}   