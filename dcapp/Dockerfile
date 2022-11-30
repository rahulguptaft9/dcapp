#FROM docker pull ubuntu:20.04
#RUN apt-get update -y
#RUN apt install php7.2 php7.2-cli php7.2-common libapache2-mod-php -y
#RUN apt-get install php
#RUN apt-get install -y libapache2-mod-php7.4
#RUN apt-get update && apt-get -y install software-properties-common && add-apt-repository ppa:ondrej/php && apt-get update && apt-get install -y apache2 && apt-get install -y php7.2 && apt-get install -y libapache2-mod-php7.2 php7.2-curl php7.2-json
#FROM php:7.2-apache
#RUN docker-php-ext-install pdo pdo_mysql mysqli a2enmod authnz_ldap

#Start services
#CMD /usr/sbin/apache2ctl -D FOREGROUND

#Copy files to webserver 
#COPY . /var/www/html/

#EXPOSE 80

FROM php:7.2-apache

RUN apt-get update -y \
 && apt-get install -y libcurl4-openssl-dev pkg-config libssl-dev vim

# Configure MongoDB.
#RUN pecl install mongodb \
# && docker-php-ext-enable mongodb
RUN docker-php-ext-install pdo pdo_mysql
# Configure MySQL.
RUN docker-php-ext-install mysqli

# Configure LDAP.
RUN apt-get update \
 && apt-get install libldap2-dev -y \
 && rm -rf /var/lib/apt/lists/* \
 && docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ \
 && docker-php-ext-install ldap

RUN a2enmod rewrite && service apache2 restart

# Python 2.7 and modules
#RUN apt install python2.7 python-pip -y \
# && python2.7 -m pip install pymysql pymongo redis

# We must reconfigure here the CMD directive.
CMD apache2-foreground

COPY . /var/www/html/

EXPOSE 80
