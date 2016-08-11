Installation steps:

0. You must have NodeJS, PHP and composer installed.
1. `cd backend`.
2. Install back-end dependencies by running `composer update`.
3. Configure `app/config/parameters.yml`. It must contain your database settings.
4. Run `php bin/console doctrine:schema:update --force --env=prod` and `php bin/console doctrine:schema:update --force --env=test` to generate Doctrine database schema.
5. Run `vendor/bin/phpunit` (or `vendor\bin\phpunit.bat` on Windows) to check that tests are executed correctly.
6. `cd ../frontend`.
7. `npm install`.
8. `node-sass app/ -o app/css/` to build .css files from .scss.
9. Set back-end's API base url in `app/config/config.js`. Ensure that both frontend and backend are located on same domain, so AJAX requests won't break (http://stackoverflow.com/questions/15005500/loading-cross-domain-html-page-with-ajax/17299796#17299796).
10. Run `npm test` to unit test front-end.

Or if you are using Windows. You can run `scripts/install-dependencies.bat` to install dependencies for you. It is interactive and will ask you details for parameters.yml and open config.js in notepad to change backend API base url.

`http://localhost/simple-blog-task/frontend/app/` is entry point for frontend, if you cloned this project into your `localhost` domain root folder.
