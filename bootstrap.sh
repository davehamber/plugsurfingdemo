#!/usr/bin/env bash
yum -y update

# Install nano editor
yum -y install nano

# Install default web server (apache2)
yum -y install httpd

# Add epel packages to allow installation of PHP 5.6
rpm -Uvh https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm
rpm -Uvh https://mirror.webtatic.com/yum/el7/webtatic-release.rpm
yum -y install php56w php56w-opcache
yum -y install php56w-xml
yum -y install php56w-pdo

# Steps needed to install Xdebug
yum -y install php56w-devel gcc gcc-c++ autoconf automake
yum -y install php-pear
pecl install Xdebug
echo "zend_extension=xdebug.so" > /etc/php.d/xdebug.ini

# Give php.ini a timezone to stop php configuration moans
sed -i "s/;date.timezone =/date.timezone = Europe\/Berlin/g" /etc/php.ini

# Set up virtual hosts directories for apache
mkdir /etc/httpd/sites-available
mkdir /etc/httpd/sites-enabled

# Add basic virtual host file for our restaurant search
cat > /etc/httpd/sites-available/plugsurfingdemo.davehamber.com.conf << EOF
<VirtualHost *:80>
    ServerName plugsurfingdemo.davehamber.local
    ServerAlias plugsurfingdemo.davehamber.local

    DocumentRoot /vagrant/web
    <Directory /vagrant/web>
        # enable the .htaccess rewrites
        AllowOverride All
        Require all granted
    </Directory>

    # uncomment the following lines if you install assets as symlinks
    # or run into problems when compiling LESS/Sass/CoffeScript assets
    # <Directory /var/www/plugsurfingdemo.davehamber.com/html>
    #    Option FollowSymlinks
    # </Directory>

    ErrorLog /var/log/httpd/plugsurfingdemo.davehamber.com_error.log
    CustomLog /var/log/httpd/plugsurfingdemo.davehamber.com_access.log combined
</VirtualHost>
EOF

# Link available virtual host to enabled virtual host
ln -s /etc/httpd/sites-available/plugsurfingdemo.davehamber.com.conf /etc/httpd/sites-enabled/plugsurfingdemo.davehamber.com.conf

# Tell httpd.conf to look for config files in sites-enabled
echo "IncludeOptional sites-enabled/*.conf" >> /etc/httpd/conf/httpd.conf

# Alter SELinux settings to allow web access to vagrant directory
chcon -Rv --type=httpd_sys_rw_content_t /vagrant/
restorecon -v /vagrant/web

# Allow the app/cache and app/logs to be writeable by both apache and the vagrant user
setfacl -R -m u:apache:rwX -m u:vagrant:rwX /vagrant/app/cache /vagrant/app/logs
setfacl -dR -m u:apache:rwX -m u:vagrant:rwX /vagrant/app/cache /vagrant/app/logs

curl -L https://phar.phpunit.de/phpunit.phar > /usr/local/bin/phpunit.phar
chmod +x /usr/local/bin/phpunit.phar

# Add apache to boot and start
systemctl enable httpd.service
service httpd start
