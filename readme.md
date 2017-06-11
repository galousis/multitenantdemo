Backbone interview task demo app


## Installation & Configuration
- Clone the repo.
- Install npm, node.js, gulp
- Install dependencies: ```composer install``` (also, ```npm install```, if you need).
- Configure environment variables- ```.env``` (follow intruction from .env.example file).
- Generate application key: ```php artisan key:generate```.
- Run Laravel migrations: see bellow.

Migration & seeding steps:

    Run these into tour mysql server :
    
    - CREATE SCHEMA `backbone_master` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
    - CREATE SCHEMA `backbone_GR` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ;
    - CREATE SCHEMA `backbone_UK` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ;
    - CREATE SCHEMA `backbone_US` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

  
- Migrate all databases command : ```php artisan migrate:tenant:all mysql backbone_```
- Seed all databases command : ```php artisan db:tenant:seed mysql DatabaseSeeder```