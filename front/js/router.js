const base = "/Contactflow/front" 
console.log(base + "edit")

const routes = [
    { path: base + "/",       file: "../page/home.js" },
    { path: base + "/create", file: "../page/create.js" },
    { path: base + "/edit",   file: "../page/Edit.js" },
    { path: base + "/detail",   file: "../page/detail.js" },

];

const router = async () => {
    const currentPath = location.pathname;
    console.log(location.pathname)
    // resultat final
    let match = null;

    for (let i = 0; i < routes.length; i++) {
        const route = routes[i];

        //verifie la correspondance
        if (currentPath === route.path || currentPath === route.path + "/") {
            match = route;
            break;       
        }
        console.log(currentPath , route.path)
    }

    //mettre ajour le conteneur
    const appContainer = document.getElementById("app");

    if (match !== null) {
        try {
            const module = await import(match.file);
            console.log(match.file)
            const render = module.default;
            //le html se charge a l'endroit voulu
            appContainer.innerHTML = render();
        } catch (error) {
            console.error("Erreur de chargement du module", error);
            appContainer.innerHTML = "<h1>Erreur de chargement</h1>";
        }
    } else {
        appContainer.innerHTML = "<h1>404</h1><p>Page introuvable</p>";
    }
};

document.addEventListener("click", (e) => {
    if (e.target.tagName === "A" && e.target.href.startsWith(location.origin)) {
        e.preventDefault(); //empeche la page de se recharger
        history.pushState({}, "", e.target.href);//change l'url
        router();
    }
});

window.addEventListener("popstate", router);

router();
<<<<<<< HEAD
=======

>>>>>>> origin/mickael
