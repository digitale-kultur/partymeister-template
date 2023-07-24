## About PartyMeister

## Installation

see readme.md, then

mkdir packages/
git clone git@github.com:digitale-kultur/partymeister-competitions.git
git clone git@github.com:digitale-kultur/partymeister-core.git
git clone git@github.com:digitale-kultur/partymeister-frontend.git
git clone git@github.com:digitale-kultur/partymeister-slides.git

in every of these: git checkout evoke2023

./update-dev.sh
./dump-autoload-dev.sh

goto: http://localhost:10082

## maybe

start chrome webdriver in container:
    su application -c "php /app/artisan partymeister:slides:webdriver start"
    /chromedriver/chromedriver &
    mkdir /app/entries
    make cronjob run in docker
        echo "* * * * * php /app/artisan schedule:run >> /tmp/partymeister-cron.log"

## on live
install chromium-browser FROM NON SNAP REPO
check chromium-version
get fitting chromedriver
update supervisord config with wherever you put chromedriver
add something like APP_URL_INTERNAL=https://pm2023.evoke-net.de to .env
symlink storage/app/media into public/media


