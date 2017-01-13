FROM php:5.6-apache
ENV DEBIAN_FRONTEND noninteractive
RUN apt-get update
RUN apt-get install -y mysql-server php5-mysql
COPY . /var/www/html
ADD run.sh /run.sh
RUN chmod 755 /*.sh

EXPOSE 80 
VOLUME ["/etc/mysql", "/var/lib/mysql" ]
CMD /run.sh
