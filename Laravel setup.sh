# Ubuntu 18.04 LTS Server Setup for Laravel

# Login as root user

sudo su -


# Update list of available packages

apt update


# Install node.js

curl -sL https://deb.nodesource.com/setup_14.x | sudo -E bash -
apt install nodejs


# Install laravel echo server

npm install -g laravel-echo-server
npm install --unsafe-perm -g sqlite3


# Install MySQL

apt install mysql-server


# Configure MySQL

mysql -u root <<-EOF
CREATE DATABASE foldertododb;
CREATE USER 'Nhillus'@'127.0.0.1:3306' IDENTIFIED WITH mysql_native_password BY 'prueba123';
GRANT ALL PRIVILEGES ON foldertododb.* TO 'Nhillus'@'127.0.0.1:3306';
EOF

# Install vue.js cli
npm install -g @vue/cli
npm install

# Install php

apt install php-fpm
apt install php-mysql php-common php-mbstring php-xml php-zip php-bcmath zip unzip php-zip

# Configure php

sed -i 's/^upload_max_filesize.*/upload_max_filesize = 10M/' /etc/php/7.2/fpm/php.ini
sed -i 's/^post_max_size.*/post_max_size = 10M/' /etc/php/7.2/fpm/php.ini