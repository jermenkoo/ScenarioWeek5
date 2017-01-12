#!/usr/bin/env bash
sudo apt-add-repository ppa:fish-shell/release-2
sudo apt-get update
sudo apt-get install -y fish
sudo apt-get install -y emacs

# install LAMP
sudo echo "mysql-server-5.5 mysql-server/root_password password root" | debconf-set-selections
sudo echo "mysql-server-5.5 mysql-server/root_password_again password root" | debconf-set-selections
sudo apt-get install -y lamp-server^ phpmyadmin

sudo echo "Include /etc/phpmyadmin/apache.conf" >> /etc/apache2/apache2.conf

# create uploads folder
sudo -i
mkdir /vagrant/src/logic/uploads
chmod 777 /vagrant/src/logic/uploads

# make vagrant default shell
usermod -s /usr/bin/fish vagrant #for the normal user
chsh -s `which fish` # for the root

# change the config of the apache
sed -i '12s#.*#DocumentRoot /vagrant#' /etc/apache2/sites-enabled/000-default.conf
sed -i '164s#.*#<Directory /vagrant>#' /etc/apache2/apache2.conf

make-ssl-cert generate-default-snakeoil --force-overwrite
a2enmod ssl
a2enmod headers
a2ensite default-ssl.conf

# change the ssl folder
sed -i '5s#.*#DocumentRoot /vagrant#' /etc/apache2/sites-available/default-ssl.conf
# security pls
sudo sed -i "/ServerTokens/s/OS/Prod/" /etc/apache2/conf-available/security.conf
sudo sed -i "/ServerSignature/s/On/Off/" /etc/apache2/conf-available/security.conf
sudo sed -i "/expose_php/s/On/Off/" /etc/php5/apache2/php.ini
sudo sed -i "/disable_f/s/\$/exec,passthru,shell_exec,system,proc_open,popen,curl_exec,curl_multi_exec,parse_ini_file,show_source/" /etc/php5/apache2/php.ini
sudo sed -i "/Options/s/Indexes//" /etc/apache2/apache2.conf

# security again please
sudo echo "Header always set X-Frame-Options \"SAMEORIGIN\"" >> /etc/apache2/apache2.conf
sudo echo "Header always set X-XSS-Protection \"1; mode=block\"" >> /etc/apache2/apache2.conf
sudo echo "Header always set X-Content-Type-Options \"nosniff\"" >> /etc/apache2/apache2.conf
sudo echo "Header always set Content-Security-Policy \"default-src 'self'; script-src 'self' 'unsafe-inline'; connect-src 'self'; img-src * 'unsafe-inline'; style-src 'self' 'unsafe-inline';\"" >> /etc/apache2/apache2.conf

# restart the service
service apache2 restart
# check if php is installed
php -r 'echo "\n\nYour PHP installation is working fine.\n\n\n";'
