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
id : Identifiant unique de l'utilisateur.
nom : Nom de l'utilisateur.
prenom : Prénom de l'utilisateur.
email : Adresse email de l'utilisateur.
password : Mot de passe de l'utilisateur.
last_interaction : Dernière interaction de l'utilisateur avec le système.
consent : Consentement de l'utilisateur aux conditions générales.

Table Post :
Id : Identifiant unique du post.
user_id : Lien vers la Table User (identifiant de l'utilisateur qui a créé le post).
title : Titre du post.
likes : Nombre de "likes" du post.
content : Contenu du post.
created_at : Date et heure de création du post.
draft : Statut du post (brouillon ou publié).

Table Thème :
id : Identifiant unique du thème.
nom : Nom du thème.

Table PostTheme (pour la relation many to many entre Post et Thème) :
post_id : Lien vers la Table Post (identifiant du post).
theme_id : Lien vers la Table Thème (identifiant du thème).

## Initialiser le projet :

### Créer le projet Symfony :

```bash
symfony new mini_blog --webapp
```

```bash
cd mini_blog
```

Ajout d'un .env.local :

```env
DATABASE_URL=mysql://root:root@127.0.0.1:8889/mini_blog?charset=utf8mb4
```

Et création de la database :

```bash
symfony console doctrine:database:create 
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

## Mise en place des entités :

### Créons l'entity User :

```bash
symfony console make:user
```

```bash
The name of the security user class (e.g. User) [User]:
 > User

 Do you want to store user data in the database (via Doctrine)? (yes/no) [yes]:
 > yes

 Enter a property name that will be the unique "display" name for the user (e.g. email, username, uuid) [email]:
 > email

 Will this app need to hash/check user passwords? Choose No if passwords are not needed or will be checked/hashed by some other system (e.g. a single sign-on server).

 Does this app need to hash/check user passwords? (yes/no) [yes]:
 > yes
```

Nous ajoutons aussi le name (varchar), surname (varchar), last_interaction (date), is_verified(boolean)

Nous avons créé l'entity User, un utilisateur se connectera avec son email, et nous avons décidé de hasher le mot de passe.

### Créons l'entity Post :

```bash
symfony console make:entity Post
```

```bash
New property name (press <return> to stop adding fields):
 > title

 Field type (enter ? to see all types) [string]:
 > 

 Field length [255]:
 > 

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/Post.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > content 

 Field type (enter ? to see all types) [string]:
 > text

 Can this field be null in the database (nullable) (yes/no) [no]:
 > yes

 updated: src/Entity/Post.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > created_at

 Field type (enter ? to see all types) [datetime_immutable]:
 > 

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/Post.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > draft

 Field type (enter ? to see all types) [string]:
 > boolean

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/Post.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > likes

 Field type (enter ? to see all types) [string]:
 > integer

 Can this field be null in the database (nullable) (yes/no) [no]:
 > yes

 updated: src/Entity/Post.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > user

 Field type (enter ? to see all types) [string]:
 > relation

 What class should this entity be related to?:
 > User

What type of relationship is this?
 ------------ ----------------------------------------------------------------- 
  Type         Description                                          
 ------------ ----------------------------------------------------------------- 
  ManyToOne    Each Post relates to (has) one User.                 
               Each User can relate to (can have) many Post objects.  
                                                                    
  OneToMany    Each Post can relate to (can have) many User objects.  
               Each User relates to (has) one Post.                 
                                                                    
  ManyToMany   Each Post can relate to (can have) many User objects.  
               Each User can also relate to (can also have) many Post objects.  
                                                                    
  OneToOne     Each Post relates to (has) exactly one User.         
               Each User also relates to (has) exactly one Post.    
 ------------ ----------------------------------------------------------------- 

 Relation type? [ManyToOne, OneToMany, ManyToMany, OneToOne]:
 > ManyToOne

 Is the Post.user property allowed to be null (nullable)? (yes/no) [yes]:
 > 

 Do you want to add a new property to User so that you can access/update Post objects from it - e.g. $user->getPosts()? (yes/no) [yes]:
 > 

 A new property will also be added to the User class so that you can access the related Post objects from it.

 New field name inside User [posts]:
 > 


```

### Créons l'entity Theme :

```bash
symfony console make:entity Theme
```

```bash
 New property name (press <return> to stop adding fields):
 > nom

 Field type (enter ? to see all types) [string]:
 > 

 Field length [255]:
 > 

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/Theme.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > post

 Field type (enter ? to see all types) [string]:
 > relation

 What class should this entity be related to?:
 > Post

What type of relationship is this?
 ------------ ------------------------------------------------------------------ 
  Type         Description                                           
 ------------ ------------------------------------------------------------------ 
  ManyToOne    Each Theme relates to (has) one Post.                 
               Each Post can relate to (can have) many Theme objects.  
                                                                     
  OneToMany    Each Theme can relate to (can have) many Post objects.  
               Each Post relates to (has) one Theme.                 
                                                                     
  ManyToMany   Each Theme can relate to (can have) many Post objects.  
               Each Post can also relate to (can also have) many Theme objects.  
                                                                     
  OneToOne     Each Theme relates to (has) exactly one Post.         
               Each Post also relates to (has) exactly one Theme.    
 ------------ ------------------------------------------------------------------ 

 Relation type? [ManyToOne, OneToMany, ManyToMany, OneToOne]:
 > ManyToMany

 Do you want to add a new property to Post so that you can access/update Theme objects from it - e.g. $post->getThemes()? (yes/no) [yes]:
 > 

 A new property will also be added to the Post class so that you can access the related Theme objects from it.

 New field name inside Post [themes]:
 > 

```

Nous devons désormais créer un fichier de migration :

```bash
symfony console make:migration 
```

Il est important de commenter notre fichier afin de garder une bonne lisibilité :

```php
public function getDescription(): string  
{  
    return 'Création des tables post, theme, theme_post, user';  
}
```

Maintenant, nous allons effectuer la migration pour mettre à jour notre base de données :
(Note : Nous utiliserons d:m:m pour doctrine:migration:migrate) :

```bash
symfony console d:m:m
```

Ça y est, notre base de donnée est prête.

Nous allons maintenant créer un fichier de Fixture, qui va nous permettre de remplir notre base de données de fausses données.

### Faker :

Mettons en place un fichier Faker afin de créer de fausse données, cela nous permettra de tester notre structure.

```bash
composer require --dev orm-fixtures
```

```bash
composer require fakerphp/faker
```

Nous allon créer 3 themes,   5 utilisateurs, et chaques utilisateurs aura aléatoirement entre  2 et 5 posts. TODO

```php
<?php  
  
namespace App\DataFixtures;  
  
  
use App\Entity\Post;  
use App\Entity\Theme;  
use Doctrine\Bundle\FixturesBundle\Fixture;  
use Faker\Factory;  
  
use App\Entity\User;  
  
use Doctrine\Persistence\ObjectManager;  
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;  
  
class AppFixtures extends Fixture  
{  
    protected $encoder;  
    //nous avons besoin de l'encodeur pour encoder les mots de passe  
    public function __construct(UserPasswordHasherInterface $encoder)  
    {  
        $this->encoder = $encoder;  
    }  
    public function load(ObjectManager $manager): void  
    {  
        //Nous créons une instance de Faker en français  
        $faker = Factory::create('fr_FR');  
  
        // Nous créons 3 themes  
        $themes = [];  
        for ($t = 0; $t < 3; $t++) {  
            $theme = new Theme();  
            $theme->setNom($faker->sentence());  
            $manager->persist($theme);  
            $themes[] = $theme; // Nous les enregistrons dans un tableau  
        }  
        // Nous créons 5 utilisateurs  
        for ($u = 0; $u < 5; $u++) {  
            $user = new User;  
            $hash = $this->encoder->hashPassword($user, "password");  
            $user->setRoles(["ROLE_USER"])  
                ->setSurname($faker->lastName())  
                ->setName($faker->firstName())  
                ->setEmail($faker->email())  
                ->setConsent(true)  
                ->setLastInteraction(new \DateTime())  
                ->setEmail($faker->email())  
                ->setPassword($hash);  
            $manager->persist($user);  
            //Pour chaque utilisateur, nous créons entre 2 et 5 articles  
            for ($p = 0; $p < mt_rand(2, 5); $p++) {  
                $post = new Post();  
                $post->setTitle($faker->sentence())  
                    ->setContent($faker->paragraph(5))  
                    ->setCreatedAt(new \DateTimeImmutable())  
                    ->setDraft(false)  
                    ->setLikes(0)  
                    ->setUser($user);  
                //Et nous affectons les themes au post aléatoirement  
                $randomThemes = (array)array_rand($themes, mt_rand(1, 3));  
                foreach ($randomThemes as $themeIndex) {  
                    $post->addTheme($themes[$themeIndex]);  
                }  
                $manager->persist($post);  
            }  
        }  
        // Nous enregistrons le tout en base de données  
        $manager->flush();  
  
    }  
}
```

#### Lançons  notre fixture :

```bash
symfony doctrine:fixtures:load
```

La base de données est désormais peuplé de fausses données test.

## FRONT :

Un peu de front et du crud avec nos contrôleurs  :

### Authentification :

Nous allons maintenant créer une authentification avec :

```bash
symfony console make:auth
```

```bash
 What style of authentication do you want? [Empty authenticator]:
  [0] Empty authenticator
  [1] Login form authenticator
 > 1

 The class name of the authenticator to create (e.g. AppCustomAuthenticator):
 > AppAuthentification

 Choose a name for the controller class (e.g. SecurityController) [SecurityController]:
 > 

 Do you want to generate a '/logout' URL? (yes/no) [yes]:
 > 

 Do you want to support remember me? (yes/no) [yes]:
 > no


```

### Enregistrement :

Nous allons créer un formulaire de création de compte et gérer la vérification de mail. pour ce faire, nous allons utiliser la configuration proposé par Symfony.

Afin de tester nos emails, nous allons utiliser un fichier compose.yaml :

```yaml
version: '3'  
  
services:  
  ###> symfony/mailer ###  
  mailer:  
    image: axllent/mailpit  
    ports:  
      - "1025:1025"  # Port SMTP  
      - "8025:8025"  # Port webmail  
    environment:  
      MP_SMTP_AUTH_ACCEPT_ANY: 1  
      MP_SMTP_AUTH_ALLOW_INSECURE: 1  
  ###< symfony/mailer ###
```

Nous configurons aussi notre .env.local en ajoutant :

```
MAILER_DSN=smtp://localhost:1025
```

Installation le bundle nécessaire pour la confirmation par mail :

```bash
composer require symfonycasts/verify-email-bundle  
```

Pour créer notre formulaire d'enregistrement :

```bash
symfony console make:registration
```

```bash

 Do you want to add a #[UniqueEntity] validation attribute to your User class to make sure duplicate accounts aren't created? (yes/no) [yes]:
 >  yes

 Do you want to send an email to verify the user's email address after registration? (yes/no) [yes]:
 > yes

 Would you like to include the user id in the verification link to allow anonymous email verification? (yes/no) [no]:
 > no

 What email address will be used to send registration confirmations? (e.g. mailer@your-domain.com):
 > test@test.com

 What "name" should be associated with that email address? (e.g. Acme Mail Bot):
 > BlogBot

 Do you want to automatically authenticate the user after registration? (yes/no) [yes]: yes
 > 

```

Note : Nous devons ajouter un setIsVerified à notre fixture :

```php
$user->setRoles(["ROLE_USER"])  
    ->setIsVerified(true)
```

Modifions notre formulaire d'enregistrement afin de coller aux besoins de notre entity :

```php
public function buildForm(FormBuilderInterface $builder, array $options): void  
{  
    $builder  
        ->add('email')  
        ->add('name', TextType::class,[  
            'label' => 'Prénom',  
            'attr' => [  
                'placeholder' => 'Votre prénom'  
            ]  
        ])  
        ->add('surname', TextType::class,[  
            'label' => 'Nom',  
            'attr' => [  
                'placeholder' => 'Votre nom'  
            ]  
        ])  
        ->add('agreeTerms', CheckboxType::class, [  
                            'mapped' => false,  
            'constraints' => [  
                new IsTrue([  
                    'message' => 'You should agree to our terms.',  
                ]),  
            ],  
        ])  
        ->add('plainPassword', PasswordType::class, [  
            // instead of being set onto the object directly,  
            // this is read and encoded in the controller            'mapped' => false,  
            'attr' => ['autocomplete' => 'new-password'],  
            'constraints' => [  
                new NotBlank([  
                    'message' => 'Please enter a password',  
                ]),  
                new Length([  
                    'min' => 6,  
                    'minMessage' => 'Your password should be at least {{ limit }} characters',  
                    // max length allowed by Symfony for security reasons  
                    'max' => 4096,  
                ]),  
            ],  
        ])  
        ->add('submit', SubmitType::class, [  
            'label' => 'S\'inscrire',  
            'attr' => [  
                'class' => 'btn btn-primary'  
            ]  
        ]);  
}

```

Et dans le contrôleur, il nous faut gérer la gestion du lastIntercation :

```php
$user->setLastInteraction(new \DateTime())
```

Mais n'oublions pas aussi de traiter le consentement :

```php
if($form->get('agreeTerms')->getData() === true)  
{  
    $user->setConsent(true);  
}
```

Les mails étant envoyé en asynchrone, il est parfois utile, pour pouvoir les visualiser d'utiliser cette commande :

```bash
symfony console messenger:consume 
```

Cette commande est utilisée pour démarrer le processus de traitement des messages en attente dans la file d'attente de messagerie. Cela exécute les handlers associés aux messages de manière asynchrone.

Nous désactivons la connexion automatique après l'enregistrement.
Dans RegistrationController.php :

```php
//            return $userAuthenticator->authenticateUser(  
//                $user,  
//                $authenticator,  
//                $request  
//            );  
                return $this->redirectToRoute('app_login');

```

Vérifions aussi si l'utilisateur est vérifié après la connection et laissons lui un message.
Dans mon controller app_home :

```php
if(!$this->getUser()->isverified() === true)  
{  
    $this->addFlash('warning', 'Veuillez confirmer votre adresse e-mail pour accéder à votre compte.');  
}
```

Et dans le template :

```html

{% for message in app.flashes('warning') %}  
    <div class="warning">  
        {{ message }}  
    </div>  
{% endfor %}


```

Dans notre home page, listons pour commencer les noms de nos 3 thèmes.
Dans le contrôleur il faut d'abord que l'on récupère le liste dans notre BDD.

```php
$themes = $themeRepository->findAll();  
return $this->render('home/index.html.twig', [  
    'themes' => $themes  
]);
```

Dans notre template home nous pouvons boucler avec Twig sur nos thèmes :

```html
<ul>  
{% for theme in themes %}  
    <li> {{ theme.nom }}</li>  
{% endfor %}  
</ul>
```

C'est une premiere étape, mais il serait intéressant de pouvoir ajouter des liens et d'afficher la page du thème avec les posts associés.

Pour cela nous allons retravailler dans notre HomeController.php.

```php
#[Route('/theme/{id}', name: 'app_theme')]  
public function theme(Theme $theme): Response  
{  
    $themeName = $theme->getNom();  
    $posts = $theme->getPost();  
    return $this->render('theme/theme.html.twig', [  
        'theme' => $themeName,  
        'posts' => $posts  
    ]);  
}
```

```html
{% block body %}  
        <h1>{{ theme }}</h1>  
        <ul>    
        {% for post in posts %}  
                <article>  
                        <header>{{ post.title }}</header>  
                        {{ post.content }}  
                        <footer>Créé par {{ post.user.name }}  le {{ post.getCreatedAt()|date('Y-m-d') }}</footer>  
                </article>  
        {% endfor %}  
        </ul>  
{% endblock %}

```

Et changeons notre template home avec les liens :

```html
<ul>  
{% for theme in themes %}  
    <li>  
        <a href="{{ path('app_theme', {'id': theme.id}) }}">{{ theme.nom }}</a>  
    </li>  
{% endfor %}  
</ul>
```


Pour finir avec nos liens thème, il serait préférable d'utiliser des slugs plutôt que l'id

Dans notre entity theme ajoutons :

```php

#[ORM\Column(length: 255)]  
private ?string $slug = null;

public function getSlug(): ?string  
{  
    return $this->slug;  
}  
  
public function setSlug(string $slug): static  
{  
    $this->slug = $slug;  
  
    return $this;  
}

```

Nous allons évidement créer un fichier de migration et faire la migration

Puis nous modifions notre Fixture :

```php
use Symfony\Component\String\Slugger\SluggerInterface;
```

```php
public function __construct(UserPasswordHasherInterface $encoder,private SluggerInterface $slugger)  
{  
    $this->encoder = $encoder;  
}

for ($t = 0; $t < 3; $t++) {  
    $theme = new Theme();  
    $theme->setNom($faker->sentence());  
    $theme->setSlug($this->slugger->slug($theme->getNom())->lower());  
    $manager->persist($theme);  
    $themes[] = $theme;  
}
```

Modifions le configuration de notre route :

```php
#[Route('/theme/{slug}', name: 'app_theme')]
```

et notre template :

```php
<ul>  
{% for theme in themes %}  
    <li>  
        <a href="{{ path('app_theme', {'slug': theme.slug}) }}">{{ theme.nom }}</a>  
    </li>  
{% endfor %}  
</ul>
```

Désormais notre route ne ressemble plus à /theme/12 mais à /theme/nom-du-theme
