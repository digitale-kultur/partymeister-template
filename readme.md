## About PartyMeister

## Installation

### Docker standalone

1. Copy .env.docker.standalone to .env and adjust settings if necessary

2. Go to ./docker/standalone

3. Copy .env.example to .env and adjust the settings if necessary

4. Run the following command


    docker-compose up --build --force-recreate -d

5. After the images are running successfully, run the following script to create the database


    ./after-build.sh

6. After that, run the last command (this will populate the database get everything ready)


    ./installation.sh


7. Go to http://localhost and the frontend page should show up
8. You can find the backend on http://localhost/backend and log in with
   1. User: motor@esmaili.info
   2. Password: admin

9. Go nuts!

### CronJob

To correctly populate release files and files for the competition organizers to work with, set this in your crontab.

    * * * * * php /path-to-your-pm3-installation/artisan schedule:run >> /dev/null 2>&1

## rough dev setup

```
partymeister:
	clone partymeister-template
	cd partymeister-template/
	mkdir packages/
	clone 
		motor-cms/motor-core
		motor-cms/motor-backend
		motor-cms/motor-media
		motor-cms/motor-cms
		motor-cms/motor-docs
		partymeister/partymeister-core
		partymeister/partymeister-accounting
		partymeister/partymeister-slides
		partymeister/partymeister-competitions
		partymeister/partymeister-frontend
	
	-> steps from above
	
	./update_dev.sh
	
	start chrome webdriver in container: 
		su application -c "php /app/artisan partymeister:slides:webdriver start"
		/chromedriver/chromedriver &
		mkdir /app/entries
		make cronjob run in docker
			echo "* * * * * php /app/artisan schedule:run >> /tmp/partymeister-cron.log" >> /etc/cron.d/partymeister
			/etc/init.d/cron restart
```
