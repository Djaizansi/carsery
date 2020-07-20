# CMS CARSERY

Projet annuel permettant la création d'un CMS pour concessionaire from scratch.

## Pour commencer

Ce CMS permet de créer votre propre site complet en fonction de vos choix. Si vous voulez un site vitrine de voiture, vous pouvez. Si vous voulez avoir un panier et acheter des pièces, vous pouvez le mettre en place

### Pré-requis

Pour pouvoir commencer avec notre projet, il vous faudra : 

- Docker
- MySQL
- PHP
- Apache

### Installation

Pour pouvoir installer notre projet, télécharger le repository avec la commande ``git clone`` ou cliquez [ici](https://github.com/Djaizansi/carsery/archive/master.zip) :

```git
git clone https://github.com/Djaizansi/carsery
```
Puis tapez la commande suivante afin de créer les différents conteneurs

```docker
docker-compose up -d
```

## Démarrage

Pour lancer le projet, il faut tout simplement taper la commande pour lancer le projet : 

```docker
docker-compose up -d
```

Faites un docker-compose build si vous voulez modifiez votre DockerFile

```docker
docker-compose build
```

Une fois ceci fait, vous tomberez sur l'installeur du CMS pour initialiser toutes les données et les charger directement dans le fichier ```.env```

<img width="773" alt="Capture d’écran 2020-02-01 à 17 02 22" src="https://user-images.githubusercontent.com/52085560/87892526-9338a400-ca3d-11ea-835e-8e7321e94f1e.png">

Il faudra changer l'adresse de la base de donnée et mettre ```database```
Ne pas oublier de créer la base de donnée avant !

<img width="773" alt="Capture d’écran 2020-02-01 à 17 02 22" src="https://user-images.githubusercontent.com/52085560/87892855-86688000-ca3e-11ea-9ff3-1f3811004ed4.png">

Dès que l'installation s'est faite avec succès, supprimez le dossier installeur pour commencer
Vous tomberez directement sur l'accueil

<img width="773" alt="Capture d’écran 2020-02-01 à 17 02 22" src="https://user-images.githubusercontent.com/52085560/87891836-a6e30b00-ca3b-11ea-97f6-710a38f91910.png">


## Fabriqué avec

Ce projet a été fabriqué avec les différents programmes/langages : 

* [Visual Studio Code](https://code.visualstudio.com) - Editeur de textes
* [Docker](https://docs.docker.com/docker-for-mac/install/) - Déploiement d’applications dans des conteneurs

## Contributing

Si vous souhaitez contribuer, lisez le fichier [CONTRIBUTING.md](https://github.com/Djaizansi/git_projet/blob/master/CONTRIBUTING.md) pour savoir comment le faire.

## Versions
**Dernière version stable :** 1.0
Liste des versions : [Cliquer pour afficher](https://github.com/Djaizansi/git_projet/tags)

## Auteurs
Listez le(s) auteur(s) du projet ici !
* **JALLALI Youcef** _alias_ [@Djaizansi](https://github.com/Djaizansi)
* **BOUADDELLAH Marwane** _alias_ [@BOUABDELLAHM](https://github.com/BOUABDELLAHM)
* **WELLE Guillaume** _alias_ [@gwelle](https://github.com/gwelle)
* **TEBAILI Nesrine** _alias_ [@Nesnes9](https://github.com/Nesnes9)
* **DISPAGNE Mel** _alias_ [@lumay](https://github.com/lumay)

Lisez la liste des [contributeurs](https://github.com/Djaizansi/git_projet/blob/master/CONTRIBUTORS.md) pour voir qui ont aidé au projet !
