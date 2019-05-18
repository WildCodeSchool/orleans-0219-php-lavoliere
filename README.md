# Project 3 - Starter Kit - Symfony 4.2.8

This starter kit is here to easily start a repositry for your students.

It's symfony website-skeleton project with some additionnal tools to validate code standards.

* GrumPHP, as pre-commit hook, will run 2 tools when `git commi` is run :
  
    * PHP_CodeSniffer to check PSR2 
    * PHPStan will check PHP recomendation
     
  If tests fail, the commit is canceled and a warning message is displayed to developper.

* Travis CI, as Continuated integration will be run when a branch with active pull request is updated on github. It will run :

    * Tasks to check if vendor, .idea, env.local are not versionned,
    * PHP_CodeSniffer to check PSR2,
    * PHPStan will check PHP recomendation.
 

## Getting Started

Before your students can code, you have some work to do !

### Prerequisites

Create a repository on Github in WildCodeSchool organization following this exemple :
**ville-session-language-project** as **bordeaux-0219-php-servyy"

### Get starter kit

1. Clone this project
2. Remove `.git` folder to remove history
3. `git init`
4. Link to your project repository you'll give to your students : `git remote add origin ...`
5. Edit `.travis.yml` file to change default e-mails settings to get notification checking tasks end
5. `git add .`
6. `git commit -m "init project repository"`
7. `git push -u origin master`

### Check on Travis

1. Go on [https://travis-ci.com](https://travis-ci.com).
2. Sign up if you don't have account,
3. Look for your project in search bar on the left,
4. As soon as your repository have a `.travis.yml` in root folder, Travis should detect it and run test.


### Configure you repository - Settings options

1. Disallow both on 'dev' and 'master' branches your students writing credentials. 
3. Add your students team as contributor .


## Deployment

Add additional notes about how to deploy this on a live system

## Built With

* [Symfony](https://github.com/symfony/symfony)
* [GrumPHP](https://github.com/phpro/grumphp)
* [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer)
* [PHPStan](https://github.com/phpstan/phpstan)
* [Travis CI](https://github.com/marketplace/travis-ci)

## Contributing

Please read [CONTRIBUTING.md](https://gist.github.com/PurpleBooth/b24679402957c63ec426) for details on our code of conduct, and the process for submitting pull requests to us.

## Versioning


## Authors

## License

## Acknowledgments

