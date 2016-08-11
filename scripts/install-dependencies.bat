@echo off
REM Check if user tried to run script from root directory of project

SET CURRENT_DIR = %cd:~-8%
IF NOT CURRENT_DIR == "\scripts" cd scripts

REM Back-end part goes first

cd ../backend
call composer update
call php bin/console doctrine:schema:update --force --env=prod
call php bin/console doctrine:schema:update --force --env=test
call vendor\bin\phpunit.bat

REM Let's continue to front-end part

cd ../frontend
call npm install
call node-sass app/ -o app/css/
call notepad app/config/config.js
npm test
