What decisions were made:

1. FOSRestBundle for Symfony3 was used to simplify RESTful API routes generation.
2. PHPUnit was used for unit-testing back-end code.
3. ArticleController was covered with functional tests to ensure that RESTful API works properly.
4. AngularJS 1.5 was used for front-end part, because I am the best familiar with it and it helps to write application's code in well separated manner, e.g. with controllers, DIC, services.
5. Front-end and back-end parts were done absolutely separately, and communicate via interface defined in `docs/design/Routing.docx`.
6. Stylesheets for front-end's views were done in SCSS.

What to do next:

1. [front-end] Cover more code with unit tests.
2. [front-end] Move REST APIs code from controllers to service named something like `articlesService` and refine `editor_test.js` tests.
3. [html/css] Use Twitter Bootstrap or some other UI framework for front-end part to improve graphical design of application.
4. [front-end] Realize public routes of application.
5. [back-end, front-end] Realize authorization and authetication (see `docs/design/Routing.docx`).
6. [back-end, front-end] Realize tags part (see `docs/design/Routing.docx`).
7. [deployment] Enable deployment of code to Travis-CI server or other staging server.
8. [deployment] Write gulp script or use webpack to concat and compress front-end's css and js files.
9. [devops] Configure caching, so public parts of front-end could be transmited lightning fast.
10. [front-end] Document existing and new code.