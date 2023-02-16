# Mission de stage de la formation Concepteur Développeur d'Application.

## Projet 1

Créer une extension qui parcourt le projet Symfony et génère un diagramme de classe avec PlantUML.  

## Projet 2

Gesfluid est une application web.

### La gestion des utilisateurs
La page d'accueil doit donner une vision synthétique de tous les utilisateurs par le dashboard.
#### Le dashboard
* Afficher la liste des groupes ;  
    * ajouter un stagiaire dans le groupe que l'on veut ;
    * Dans un second temps (permettre de modifier et supprimer);
    * un booléen permet de savoir si l'utilisateur est actif ou nom (s'il n'y a pas de nom prénom et mot de passse ; il est inactif).
#### La gestion des groupes
* inscrire un groupe de stagiaire :  
    * créer l'identifiant (e-mail) ;
        * le stagiaire reçoit un e-mail qui revoit un formulaire (1 mini, 2 maxi) ;
    * le stagiaire renseigne son e-mail (pas forcément utile grâce au lien ou pré-écrire) :  
        * un écran demande :  
            * le nom,  
            * le prénom,  
            * le mot de passe et la confirmation.
    * les groupes sont modifiables à volonté ;  
    _mention 'Enregistrement terminé' (voir mieux formulé)_  
    **_[ Réfléchir au type d'interface ]_**

#### Le formulaire CERFA
* doit être modifiable à volonté lors de sa création (utilisation d'un 'count') ;
* et n'est plus modifiable après (grâce au 'count') ;  


#### Others improvements
* modifier les routes via React-router-dom ;  
* en ce qui concerne ...._submit_scriscriber.php, mettre une partie de ce code dans un service, car ce fichier est trop chargé;    
* l'appli deviendra à terme multi-AFPA ;