Bonjour, voici les technologies dont je me sert :

- Symfony 6.2, https://symfony.com/ ;
- PHP 8.1 https://www.php.net/ ;
- Composer @latest https://getcomposer.org/download/ ;
- Scoop https://scoop.sh/ ;
- Créer la BDD avec les lignes de commandes (php bin/console d:d:c) ;
- Faire la migration des entités (php bin/console make:migration) ;
- Executer la migration (bin/console migration:migrate) ; 
- Remplir la BDD (php bin/console d:f:l) ;

Veuillez vérifier si toutes les technologies nécessaires aux lignes de commandes se trouvent dans les variables d'environnement.

Avant de démarrer le serveur, faites un : composer update ou install.

Pour démarrer un serveur, utilisez la commande : symfony server:start -d (le -d permet d'avoir toujours accès à la console).
