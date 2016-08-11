What decisions were made:

1. FOSRestBundle for Symfony3 was used to simplify RESTful API routes generation.
2. PHPUnit was used for unit-testing back-end code.
3. ArticleController was covered with functional tests to ensure that RESTful API works properly.
4. AngularJS 1.5 was used for front-end part, because I am the best familiar with it and it helps to write application's code in well separated manner, e.g. with controllers, DIC, services. Also it has good integration with Jasmine unit testing framework that can help to ensure code's stable work.
5. Front-end and back-end parts were done absolutely separately, and communicate via interface defined in `docs/design/Routing.docx`. This greatly improves modularity of software, so front-end/back-end parts can be changed internally with no problem while they keep communicating via same interface.
6. Stylesheets for front-end's views were done in SCSS.

REST API routes names have `/api/v{version}/...` prefix to ensure some flexibility in changing API versions (i.e., to switch API version is as simple as to create another Symfony bundle with APIs code and change version string in front-end).

Routes naming convention `/api/v{version}/{requests-group}/{request-subgroup}` was accepted to ensure that features are separated into logical packages, e.g all CRUD operations for entities are on `/api/v0.1/entities/{entity-class}` routes, authentication operations on `/api/v0.1/auth/{operation}` routes and so on.

`RESTfulResponseGeneratorService` was created to ensure that later it may be possible to switch response format from JSON to other (xml or other). Also, it attaches status codes to APIs results, which can be helpful in future when there will be input values validation in back-end.

Routing component was used in AngularJS front-end code to enable partial page loading (i.e. loading of parts of the pages without refreshing whole page).

What to do next:

1. [front-end] Cover more code with unit tests.
2. [front-end] Move REST APIs code from controllers to separate service and refine `editor_test.js` tests.
3. [html/css] Use Twitter Bootstrap or some other UI framework for front-end part to improve graphical design of application.
4. [front-end] Realize public routes of application.
5. [back-end, front-end] Realize authorization and authetication (see `docs/design/Routing.docx`).
6. [back-end, front-end] Realize tags part (see `docs/design/Routing.docx`).
7. [deployment] Enable deployment of code to Travis-CI server or other staging server.
8. [deployment] Write gulp script or use webpack to concat and compress front-end's css and js files.
9. [devops] Configure caching, so public parts of front-end could be transmited lightning fast.
10. [front-end] Document existing and new code.
11. [front-end, back-end] Add input values validation.
12. [front-end] Routing can be switched to use HTML5 pushState standard.