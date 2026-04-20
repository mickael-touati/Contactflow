const BASE_URL = "http://localhost/Contactflow/public/index.php"

// GET - tous les contacts
export async function getContacts(limit = 10, offset = 0, search = "") {
    const response = await fetch(`${BASE_URL}/contacts?limit=${limit}&offset=${offset}&search=${search}`)
    const data = await response.json()
    return data
}

// GET - un seul contact
export async function getContact(id) {
    const response = await fetch(`${BASE_URL}/contacts/${id}`)
    const data = await response.json()
    return data
}

// POST - créer un contact
export async function createContact(contact) {
    const response = await fetch(`${BASE_URL}/contacts`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(contact)
    })
    const data = await response.json()
    return data
}

// PATCH - modifier un contact
export async function updateContact(id, contact) {
    const response = await fetch(`${BASE_URL}/contacts/${id}`, {
        method: "PATCH",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(contact)
    })
    const data = await response.json()
    return data
}

// DELETE - supprimer un contact
export async function deleteContact(id) {
    const response = await fetch(`${BASE_URL}/contacts/${id}`, {
        method: "DELETE"
    })
    const data = await response.json()
    return data
}