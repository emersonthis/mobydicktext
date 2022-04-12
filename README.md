# Moby Dick Text

http://mobydicktext.com

## Usage

[coming soon]

## Development

### Install vendor libs

`php composer.phar install`

### Run local server

`php -S localhost:8080 -t ./`

(Point browser to localhost:8080)

### Deploy

Hosted on Heroku free dyno (which sleeps and takes 30s to wake up)

`git push origin master` will automatically deploy to Heroku

### TODO

[ ] Nicer error reseponses
[ ] Test code?
[ ] Check accuracy of word endoing
[ ] Support ranges or keywords? Ex: paragraph, title, name?
