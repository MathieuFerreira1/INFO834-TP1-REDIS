# INFO834 – TP1 – Un cache Redis pour EtuServices

Vous venez d’être recruté pour faire une mission auprès d’une startup EtuServices qui propose aux
étudiants 2 services : la vente et l'achat d'articles (DVD, livres...). La startup commence à être victime
de son succès avec une utilisation de plus en plus soutenue de ses services via son application web.
L'objectif de la mission est de limiter le nombre de connexions au site de l'entreprise.
Vous allez pour cela devoir consigner le nombre de connexions par utilisateur enregistré et
connecté. La startup considère qu’il est possible de requêter leurs services à raison de 10
appels par fenêtre de 10 minutes.
Les outils/langages à utiliser sont PHP (pages web), MySQL (gestion des utilisateurs), Python avec
l'interface Redis (pour la gestion du nombre des connexions et des appels de services ).

## Installation du Projet

Pour installer le projet, suivez ces étapes :

1. Clonez le dépôt sur votre machine locale.
2. Naviguez jusqu'au répertoire du projet.

## Utilisation du Projet

Pour utiliser le projet, suivez ces étapes :

1. Démarrez votre serveur PHP. Si vous utilisez WAMP, vous pouvez le démarrer à partir du panneau de contrôle de WAMP.
2. Ouvrez votre navigateur web et naviguez jusqu'à `localhost/<répertoire_de_votre_projet>/accueil.php`.
3. Lancer le serveur redis avec redis-server
4. Modifier le fichier login.php au niveau de la variable "$cmd" en modifiant le path de python et du script python en le mettant en brut
    (ATTENTION : bien laisser le "$userId")
5. Utilisez l'application en naviguant dans les pages
