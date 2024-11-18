# Plugin de visualisation des liens internes

## Objectif

Ce plugin permet de :
1. Saisir une URL via une interface utilisateur.
2. Scanner la page d'accueil du site spécifié pour récupérer tous les liens internes présents dans son contenu.
3. Visualiser ces liens via une interface d'administration.

---

## Fonctionnalités principales

- **Page `/`** : Saisie d'une URL à scanner dans la recherche.
- **Page `/admin`** : Les liens récupérés sont affichés dans une liste.

---

## Choix techniques

1. **Node.js** : Choisi pour sa rapidité de mise en place.
2. **Express** : Utilisé pour gérer les routes et les vues.
3. **EJS** : Un moteur de templates pour afficher rapidement les résultats.
4. **Axios** : Effectuer des requêtes HTTP rapidement.
5. **Cheerio** : Permet la manipulation du DOM pour extraire facilement les liens de la page HTML.

---

## Structure du projet

```
harsene-test/
├── server.js          # Serveur principal
├── crawler.js         # Fonction de scraping des liens
├── views/             # Templates EJS
│   ├── index.ejs      # Vue pour entrer une URL
│   └── admin.ejs      # Vue pour afficher les liens
├── package.json       # Dépendances du projet
└── README.md          # Documentation du projet
```