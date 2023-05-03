Guide de Contribution

    Obtenir le projet

    Ce projet utilise PHP/Symfony et MySQL. Il nécessite également un conteneur phpMyAdmin pour administrer la base de données.
    Voici les instructions pour obtenir le projet et le faire fonctionner sur une machine de développement :

    • Cloner le dépôt https://github.com/Giscard1/ToDo-list.git
    • Accéder à la racine du projet.
    • Exécuter "composer install" dans votre console.
    • Ouvrir le fichier .env, aller à la ligne 32 et modifier les informations de connexion à la base de données.
    • Exécuter "php bin/console doctrine:database:create" dans votre console.
    • Exécuter "php bin/console doctrine:migrations:migrate" dans votre console.
    
    Directives de codage
    
    Pour garantir la qualité et la maintenabilité du projet, certaines règles de style de codage doivent être suivies :
    
    • Le code doit suivre les recommandations standard de PHP.
    • Le code doit également suivre les normes de codage de Symfony.
    • Pour vous aider à suivre ces règles, Codacy est utilisé pour surveiller la qualité du code lorsqu'une demande de pull est soumise.

    Tests

    Chaque fois que vous ajoutez une nouvelle fonctionnalité ou corrigez un bug, votre code doit être testé avec PHPUnit pour des tests unitaires et fonctionnels. Voici nos normes en matière de tests :
    
    • Les entités doivent être testées avec des tests unitaires.
    • Les contrôleurs doivent être testés avec des tests fonctionnels.
    • Seules les méthodes publiques doivent être testées.
    • Une demande de pull doit être ouverte lorsque le code a réussi tous les tests.
    
    Directives Git
    
    Pour commencer à travailler sur un nouvel élément, vous devez créer une nouvelle branche localement pour cet élément, y effectuer des commits, puis, lorsque c'est prêt, la pousser dans le dépôt et créer une demande de pull.

    Même les messages de commit Git doivent suivre certaines directives :
    
    • L'impératif doit être utilisé pour le sujet.
    • Le sujet doit être capitalisé et le point à la fin doit être supprimé.
    • Le sujet doit être utilisé pour résumer les modifications.
    • Le corps doit être utilisé pour décrire quoi et pourquoi les changements ont été apportés.