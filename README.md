# Creation d'un blog (En cours de réalisation) :

Ce tutoriel va nous permettre de voir les bases de Symfony. Nous verrons comment initialiser un nouveau projet, comment créer des entités, utiliser un framework CSS via Webpack, gérer un CRUD, créer de fausses données, gérer la gestion des mails, la navigation, les tests, la sécurité, et la mise en production.

## Description du Projet :

* Gestion des Utilisateurs : Les utilisateurs ont la possibilité de créer un compte en utilisant leur adresse email. Ils devront accepter les conditions générales lors de l'inscription.

* Envoi d'Emails : Utilisation du composant Mailer pour envoyer des informations aux utilisateurs.

* Création et Gestion de Posts : Les utilisateurs peuvent créer des posts, y ajouter un titre et un contenu, et gérer leur statut (de brouillon à publié).

* Interaction avec les Posts : Les utilisateurs ont la capacité de 'liker' les posts.
Navigation et Thèmes : La page d'accueil permettra de naviguer entre différents thèmes.

* Gestion des Droits : Utilisation de voters pour vérifier les droits des utilisateurs.
Frontend : Utilisation de Pico CSS (https://picocss.com) pour le design frontend.

Structure de la Base de Données :

    Table User :
        id
        nom
        prenom
        email
        password
        last_interaction
        consent

    Table Post :
        Id
        user_id (lien vers la Table User)
        theme_id (lien vers la Table Thème)
        title
        likes
        content
        created_at
        draft

    Table Thème :
        id
        nom

    Table Image :
        id
        post_id (lien vers la Table Post)
        nom


## Initialiser le projet :

### Créer le projet Symfony  :

```bash
symfony new mini_blog --webapp
```

```bash
cd mini_blog
```

### Installons Webpack ENCORE :

```bash
composer require symfony/webpack-encore-bundle
```

```bash
npm i
```

### Installons PicoCss :


```bash
npm install @picocss/pico
```

#### Configurer base.html.twig :

```html
<!DOCTYPE html>  
<html data-theme="dark">  
    <head>  
        <meta charset="UTF-8">  
        <title>{% block title %}Welcome!{% endblock %}</title>  
        <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 128 128%22><text y=%221.2em%22 font-size=%2296%22>⚫️</text></svg>">  
        <link rel="preconnect" href="https://fonts.googleapis.com">  
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>  
        <link href="https://fonts.googleapis.com/css2?family=Sora:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">  
        <meta name="viewport" content="width=device-width, initial-scale=1">  
  
        {% block stylesheets %}  
            {{ encore_entry_link_tags('app') }}  
        {% endblock %}  
  
        {% block javascripts %}  
            {{ encore_entry_script_tags('app') }}  
        {% endblock %}  
        
    </head>  
    <body>        
	    <html id="theme" data-theme="light">  
            <main class="container">  
                {% block body %}  
                {% endblock %}  
            </main>  
        </html>  
    </body>
```
