up:
	sudo docker-compose up -d
build:
	sudo docker-compose build --no-cache --force-rm
init:
	mkdir -p ./docker/php/bash/psysh
	touch ./docker/php/bash/.bash_history
	sudo docker-compose up -d --build
remake:
	@make destroy
	@make init
stop:
	sudo docker-compose stop
down:
	sudo docker-compose down
restart:
	@make down
	@make up
destroy:
	sudo docker-compose down --rmi all --volumes
destroy-volumes:
	sudo docker-compose down --volumes
ps:
	sudo docker-compose ps
logs:
	sudo docker-compose logs
logs-watch:
	sudo docker-compose logs --follow
web:
	sudo docker-compose exec web ash
app:
	sudo docker-compose exec app bash
yarn:
	sudo docker-compose exec web yarn
yarn-dev:
	sudo docker-compose exec web yarn run dev
yarn-watch:
	sudo docker-compose exec web yarn run watch
yarn-watch-poll:
	sudo docker-compose exec web yarn run watch-poll
yarn-hot:
	sudo docker-compose exec web yarn run hot
db:
	sudo docker-compose exec db bash
mysql:
	sudo docker-compose exec db bash -c 'mysql --show-warnings -u $$MYSQL_USER -p$$MYSQL_PASSWORD $$MYSQL_DATABASE'
redis:
	sudo docker-compose exec redis redis-cli
