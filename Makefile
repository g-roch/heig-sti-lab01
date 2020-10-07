
IMAGENAME=sti
PORT=8080

all:
	@echo USAGE start server: 
	@echo make start PORT=$(PORT) IMAGENAME=$(IMAGENAME)
	@echo 
	@echo USAGE stop server: 
	@echo make stop
	@echo 
	@echo USAGE open shell command in server
	@echo make shell
	@echo 
	@echo USAGE restart server: 
	@echo make start PORT=$(PORT) IMAGENAME=$(IMAGENAME)

restart:
	$(MAKE) stop; $(MAKE) start

start:
	docker build --tag $(IMAGENAME) .
	chmod a+w site/databases/database.sqlite site/databases/
	docker run -t -v "$$PWD/site":/usr/share/nginx/ -d -p $(PORT):80 --name sti_project --hostname sti $(IMAGENAME)
	docker exec -u root sti_project service nginx start
	docker exec -u root sti_project service php5-fpm start

stop:
	docker stop sti_project; docker rm sti_project

shell:
	docker exec -itu root sti_project /bin/bash
