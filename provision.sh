#!/usr/bin/env bash
sudo apt-add-repository ppa:fish-shell/release-2
sudo apt-get update
sudo apt-get install -y fish
sudo apt-get install -y emacs
echo "mysql-server-5.5 mysql-server/root_password password root" | debconf-set-selections
echo "mysql-server-5.5 mysql-server/root_password_again password root" | debconf-set-selections
sudo apt-get install -y lamp-server^ phpmyadmin

sudo echo "Include /etc/phpmyadmin/apache.conf" >> /etc/apache2/apache2.conf

#change the config of the apache
sudo -i 
chmod 777 /vagrant/src/logic/uploads

#make vagrant default shell
usermod -s /usr/bin/fish vagrant #for the normal user 
chsh -s `which fish` # for the root

sed -i '12s#.*#DocumentRoot /vagrant#' /etc/apache2/sites-enabled/000-default.conf
sed -i '164s#.*#<Directory /vagrant>#' /etc/apache2/apache2.conf
# restart the service
service apache2 restart
# check if php is installed
php -r 'echo "\n\nYour PHP installation is working fine.\n\n\n";'