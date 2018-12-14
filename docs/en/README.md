
## Quick Start

### Create Project

#### Install

 Install by Composer:

 `composer create-project zacksleo/yii2-app-advanced:^1.1.0 target-directory`

### Use Docker to create the runtime environment

  Use docker-compose to create the runtime environment :

  ```
   docker-compose up
  ```

### Modify the environment variable

  Modify docker-compose.yml in nginx and mysql exposed interfaces such as

  ```
      nginx:
          build: ./services/nginx
          ports:
              - "80:80"
          links:
              - web
          volumes_from:
              - web

      mysql:
          image: mysql:5.6
          ports:
              - "3306:3306"
  ```

  > Note that the development environment, you can expose the database interface to the external network, if it is a formal environment, please close the port

  Modify the port in the service / nginx / nginx.conf list to correspond to the docker-compose.yml: ` listen 886 ssl; `


### Database migration

  Migrate the database

  ```
    docker exec -it yii2appadvanced_web_1 ./yii migrate/up

  ```
> `yii2appadvanced_web_1` Is the name of the container

   Or

   ```
    docker-compose run --rm web ./yii migrate/up

   ```
> If you modify the background administrator account and password

   ```
   Modify `username` and `password_hash` in  console\migrations\m170406_084842_create_admin_account.php to change the background account password

   ```

### Write the interface

  In api/modules under the establishment of the corresponding version of the module, such as v1, controllers in the preparation of controller, providing interface

  If the interface requires authentication, you can inherit `api\modules\v1\controllers`, which implements interface authentication

  > Api directory for the interface directory, modules in the version number to distinguish between the various modules, such as
 `v1`,`v2`

  The access address of the interface is `/api/v1`, v1 is the version number (module name)

### Config URL

  RESTful Apis need to config URL, which file locate at`api\modules\v1\config.php`, one record for one controller

### Backend

  Default backend is  /admin. Default default account is `admin`, use password `admin`


### Debug interface

  You can use Postman to debug the interface

### Write the interface documentation

  Click on the right side of the project `Wiki`, start writing the document, the home page (Home) only write profiles and directories, the specific document written in other files, use markdown format,

### Code Review

  Each code submission will automatically perform a PSR-2 standard format check, and can also be formatted locally in advance

  Execute the following command to perform a local check

  ```
   php vendor/bin/phpcs --standard=PSR2 --ignore=vendor/,packages/,console/migrations/,common/helpers -w --colors ./

  ```

### Continuous Integration

  ![](http://ww1.sinaimg.cn/large/78a9101fgy1ff8f16ldllj21sm0m4whs.jpg)

  Modify the file `.gitlab-ci.yml`, Configure continuous integration.
   The continuous integration in this case is divided into the following stages

  + Preparation: mainly dependence management and installation
  + Testing: including code review, unit testing, functional testing and acceptance testing
  + Build: includes the construction of the Docker image, or the installation of the installation package
  + Deployment: Includes remote automatic deployment and updates
