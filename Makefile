
IMAGE=arubinst/sti:project2018
IMAGE=sti

all:

restart:
	$(MAKE) stop; $(MAKE) start

start:
	docker build --tag $(IMAGE) .
	chmod a+w site/databases/database.sqlite site/databases/
	docker run -t -v "$$PWD/site":/usr/share/nginx/ -d -p 28080:80 --name sti_project --hostname sti $(IMAGE)
	docker exec -u root sti_project service nginx start
	docker exec -u root sti_project service php5-fpm start

stop:
	docker stop sti_project; docker rm sti_project

shell:
	docker exec -itu root sti_project /bin/bash
