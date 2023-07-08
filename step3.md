### Tools for quality code

To test the quality of the code I'll start by using PHP CS (Code Sniffer), setting it to comply with PSR 1, 2 and 12 standards.
An analysis tool such as PHPStan or Codacy can provide information on the quality of the code and possible improvements. 
For performance, I would use a tool like Blackfire.

### ci/cd process

The first step is, of course, to version the code on a platform such as GitLab.
GitLab includes a continuous integration tool, GitLab CI/CD. 
The steps will be configured in a .gitlab-ci.yml file: integration steps, tests, code analysis, etc.
Then configure the builds during pushes at regular intervals. Tests should be run automatically during builds. 
A production environment will be configured (initialisation of dependencies, etc.), using Docker will make things easier.

