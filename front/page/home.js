export default function render() {
    return `
        <h2>Liste des contacts</h2>

        <input type="text" id="search" placeholder="Rechercher...">

        <button onclick="navigate('/add')">+ Ajouter</button>

        <div id="list"></div>
    `;
}