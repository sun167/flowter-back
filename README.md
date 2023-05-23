# Prérequis

PHP 8.1
https://windows.php.net/download#php-8.1
https://www.educative.io/answers/how-to-install-php-8-on-windows

Symfony 6.2.10 
https://symfony.com/doc/current/setup.html

1/ Installer composer https://getcomposer.org/download/

2/ Installer Symfony Cli https://symfony.com/download

# Optionnel:
Pour voir la BDD en SQLite https://sqlitebrowser.org/dl/

# Configuration
Dans le dossier d'où installé PHP, changer le php.ini décommenter la ligne suivante 
  extension=pdo_sqlite

# Convention de nommage
https://symfony.com/doc/current/contributing/code/standards.html

Use camelCase for PHP variables, function and method names, arguments (e.g. $acceptableContentTypes, hasSession());

Use snake_case for configuration parameters and Twig template variables (e.g. framework.csrf_protection, http_status_code);

Use SCREAMING_SNAKE_CASE for constants (e.g. InputArgument::IS_ARRAY);

Use UpperCamelCase for enumeration cases (e.g. InputArgumentMode::IsArray);

Use namespaces for all PHP classes, interfaces, traits and enums and UpperCamelCase for their names (e.g. ConsoleLogger);

Prefix all abstract classes with Abstract except PHPUnit *TestCase. Please note some early Symfony classes do not follow this convention and have not been renamed for backward compatibility reasons. However, all new abstract classes must follow this naming convention;

Suffix interfaces with Interface;

Suffix traits with Trait;

Don't use a dedicated suffix for classes or enumerations (e.g. like Class or Enum), except for the cases listed below.

Suffix exceptions with Exception;

Prefix PHP attributes that relate to service configuration with As (e.g. #[AsCommand], #[AsEventListener], etc.);

Prefix PHP attributes that relate to controller arguments with Map (e.g. #[MapEntity], #[MapCurrentUser], etc.);

Use UpperCamelCase for naming PHP files (e.g. EnvVarProcessor.php) and snake case for naming Twig templates and web assets (section_layout.html.twig, index.scss);
