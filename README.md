# Plugin de visualisation des liens internes

## Objectif

Ce plugin permet d'identifier et de visualiser les liens internes présents sur la page d’accueil d’un site WordPress, directement depuis l’interface d’administration.

---

## Choix techniques

1. **Récupération des données :** Utilisation de **`wp_remote_get`**, une fonction native de WordPress, pour récupérer le contenu HTML de la page d'accueil.
2. **Analyse des liens :** Utilisation de **`DOMDocument`**, une bibliothèque PHP, pour analyser le HTML et extraire les balises `<a>` avec leurs attributs `href`.
3. **Interface d’administration :** Affichage des liens collectés sous forme de liste dans une page dédiée du panneau d’administration.

---

## Structure du projet

```
harsene-test/
├── crawler.php       # Fichier principal du plugin
└── README.md         # Documentation du projet
```

---

## Instructions d'installation

1. **Créer le plugin :**
    - Placez ce dossier dans le répertoire `wp-content/plugins` de votre site WordPress.

2. **Activer le plugin :**
    - Connectez-vous à l'administration WordPress.
    - Accédez à la section **Plugins**.
    - Activez le plugin nommé **Crawler**.

3. **Visualiser les liens internes :**
    - Dans le menu d’administration, cliquez sur **Crawler**.
    - Consultez la liste des liens internes trouvés sur la page d’accueil.