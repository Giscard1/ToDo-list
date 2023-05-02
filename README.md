    1 - Clonez ou téléchargez le repository GitHub dans le dossier voulu :

    git clone https://github.com/Giscard1/ToDo-list.git

    2 - Configurez vos variables d'environnement tel que la connexion à la base de données dans le fichier .env qui devra être crée à la racine du projet en réalisant une copie du fichier .env ainsi que la connexion à la base de données de test dans le fichier env.test.

    3 - Téléchargez et installez les dépendances du projet avec Composer :

    composer install

    4 - Créez la base de données, taper la commande ci-dessous en vous plaçant dans le répertoire du projet :

    php bin/console doctrine:database:create

    5 - Créez les différentes tables de la base de données en appliquant les migrations :

    php bin/console doctrine:migrations:migrate

    6 - Charger les fixtures :

    php bin/console doctrine:fixtures:load

    7 - Créez la base de données de test et charger les fixtures :

    php bin/console doctrine:database:create --env=test

    php bin/console doctrine:migrations:migrate -n --env=test
    
    php bin/console doctrine:fixtures:load -n --env=test


    Félicitations le projet est installé correctement, vous pouvez désormais commencer à l'utiliser à votre guise !
