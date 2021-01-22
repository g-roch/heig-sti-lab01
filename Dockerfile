FROM arubinst/sti:project2018

RUN echo "error_reporting = E_ALL" >> /etc/php5/fpm/php.ini
RUN echo "display_errors = On" >> /etc/php5/fpm/php.ini
RUN echo "display_startup_errors = On" >> /etc/php5/fpm/php.ini
RUN echo "expose_php = off" >> /etc/php5/fpm/php.ini

RUN cat /etc/php5/fpm/php.ini


