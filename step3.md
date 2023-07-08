### Tools for quality code

To test the quality of the code I'll start by using PHP CS (Code Sniffer), setting it to comply with PSR 1, 2 and 12 standards.
An analysis tool such as PHPStan or Codacy can provide information on the quality of the code and possible improvements. 
For performance, I would use a tool like Blackfire.

### ci/cd process

La première étape est bien sûr de versionner le code sur une plateforme, par exemple GitLab.
GitLab intègre un outil d'intégration continue GitLab CI/CD. 
Les étapes seront configuration dans un fichier .gitlab-ci.yml : étapes d'intégration, tests, analyse du code, etc.
Ensuite configurer les builds lors des pushs à intervalles réguliers. Les tests doivent être exécutés automatiquement lors des builds. 
Un environnement de production sera configuré (initialisation de dépendances, etc), l'utilisation de Docker facilitera les choses. 

