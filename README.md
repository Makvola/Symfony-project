# Auteur : GABA Maktoum

## Thème du projet : Collection de cartes de légendes du football africain

L'application permet d'héberger une communauté de personnes souhaitant partager en ligne, et dans le monde physique, un ensemble de cartes de légendes africaines du football en leur possession.

## Avancement du projet dans le fichier TODO.txt

### La page est accessible à l'adresse http://localhost:8000/

#### Section 'Exposition' 
- **Description** : affichage de galeries rendues publiques par leur propriétaire
- **Accessibilité en lecture** : Tout le monde
- **Accessibilité en écriture** : Seul le propriétaire d'une exposition peut y accéder en écriture une fois connecté.

#### Section 'Membres' 
- **Description** : affichage de la liste des membres de la communauté ainsi que des liens vers leur espace personnel respectif
- **Accessibilité en lecture/écriture** : La liste des membres est visible pour tous les membres de la communauté, mais l'espace personnel de chaque membre n'est accessible qu'à son propriétaire

#### Identifiant et rôle des membres 

| Email              | Mot de passe | Rôle         |
|--------------------|--------------|--------------|
| 'louis@localhost'  | 'louis'      | 'ROLE_ADMIN' |
| 'leo@localhost'    | 'leo'        | 'ROLE_USER'  |
| 'thomas@localhost' | 'thomas'     | 'ROLE_USER'  |

## Ce qui ne fonctionne pas!
- L'ajout d'entités avec Easyadmin ne fonctionne pas. En revanche, l'affichage et la suppression d'entités fonctionnent. L'accès est réservé à l'administrateur uniquement.(Membre "louis" dans notre cas)

## Nomenclature

### 1) Inventaire -> MaCollection

#### Description
Inventaire ou collection de cartes des légendes africaines de footballeurs.

#### Propriétés
- `nomCollect` : nom de la collection
- `descriptCollect` : description de la collection
- `member` : propriétaire de la collection
- `relation`: liste de cartes présentes dans la collection

### 2) Objet -> CarteJoueur

#### Description
Carte de la légende du football africain.

#### Propriétés
- `nomJoueur` : nom de la légende
- `pays` : pays de la légende
- `poste` : poste de la légende sur le terrain
- `maCollection` : collection à laquelle appartient la carte
- `expo` : exposition à laquelle appartient la carte

### 3) Membres -> Membre

#### Description
Les membres de la communauté.

#### Propriétés
- `nomMembre` : nom
- `descriptMembre` : description du membre
- `paysMembre` : pays du membre
- `collection` : liste des collections du membre
- `expos` : liste des expositions du membre

### Galerie -> Exposition

#### Description
Exposition de certaines cartes d'une collection.

#### Propriétés
- `descriptExpo` : description de l'exposition
- `publiee` : état de publication de la galerie
- `createur` : membre propriétaire de l'exposition
- `cartes`: liste des cartes présentes dans la galerie

### User

#### Description

#### Propriétés
- `email` : email de l'utilisateur 
- `roles` : rôle attribué à l'utilisateur
- `password` : mot de passe de l'utilisateur
- `member`: membre associé à l'utilisateur

