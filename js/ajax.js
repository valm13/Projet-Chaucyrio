// Renvoie un objet XMLHttpRequest en fonction du navigateur
// Si NULL renvoyé, on pourra alors désactiver l'AJAX
function getXMLHttpRequest() {
    var xhr = null;

    // Si l'objet existe
    if (window.XMLHttpRequest || window.ActiveXObject)
    {
        // Gestion d'Internet Explorer
        if (window.ActiveXObject)
        {
            // On cherche la bonne version de l'objet
            try
            {
                xhr = new ActiveXObject("Msxml2.XMLHTTP");
            }
            catch(e)
            {
                xhr = new ActiveXObject("Microsoft.XMLHTTP");
            }
        }
        // Si l'objet est un XMLHttpRequest
        else
        {
            xhr = new XMLHttpRequest();
        }
    }
    // Si l'objet n'existe pas
    else
    {
        // On signale l'erreur
        console.log("Votre navigateur ne supporte pas l'objet XMLHttpRequest");
    }

    // On retourne la variable
    return xhr;
}


/**
*   Effectue la requête AJAX passée en paramètre
*   @version 24/12/2017 00:30
*
*   @param
*       page : page PHP cible de la requête
*       requete : type de la requête (GET/POST)
*       type : type de la requête (boutique, contact, etc.) pour le routage par la page cible
*       params : tableau de paramètres additionnels
*       callback : fonction appelée lors de la réception d'une réponse
*   @return void
*/
function requeteAjax(page, requete, type, action, params, callback) {
    // Si le type n'est pas connu, on n'envoie pas la requête
    if (type === undefined) {
        return false;
    }

    // On crée la requête
    var xhttp = getXMLHttpRequest();
    // Si l'objet n'existe pas, on n'utilise pas l'AJAX
    if (xhttp === null) {
        return false;
    }

    xhttp.onreadystatechange = function() {
        // Lorsque la requête est terminée
        if (xhttp.readyState === 4 && (xhttp.status === 200 || xhttp.status === 0))
        {
            // Requête réussie, on effectue donc le callback s'il existe
            if (callback !== null && callback !== undefined)
            {
                callback(xhttp.responseText);
            }
        }
    };

    // On place les paramètres reçus dans une chaîne
    var sendParams = "type=" + encodeURIComponent(type);
    sendParams += "&action=" + encodeURIComponent(action);
    for (var key in params) {
        sendParams += "&" + encodeURIComponent(key);
        sendParams += "=" + encodeURIComponent(params[key]);
    }
    

    // On utilise la méthode demandée
    if (requete === "POST")
    {
        // On effectue la requête en POST vers la page donnée
        xhttp.open("POST", page, true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(sendParams);
    }
    // Dans le cas du GET
    else
    {
        // On effectue la requête en GET vers la page donnée
        xhttp.open("GET", page + "?" + sendParams, true);
        xhttp.send(null);
    }

    return true;
}