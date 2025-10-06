# update
sudo apt update && sudo apt upgrade -y

# install Apache, PHP, and PHP-MySQL
sudo apt install -y apache2 php php-mysql libapache2-mod-php

# install MariaDB (MySQL-compatible)
sudo apt install -y mariadb-server

# secure simple MariaDB setup (interactive)
sudo mysql_secure_installation
# (You can set a root password or use socket auth — for the lab create a test DB/user below)

# install ModSecurity v3 and the connector for Apache (libmodsecurity + modsecurity-apache)
# On Ubuntu you can use packaged mod-security or build; below uses libapache2-mod-security2 for simplicity
sudo apt install -y libapache2-mod-security2

# download OWASP CRS (recommended)
cd /opt
sudo git clone https://github.com/coreruleset/coreruleset.git owasp-crs
sudo cp -r owasp-crs/rules /etc/modsecurity/

# ensure main config exists
sudo cp /etc/modsecurity/modsecurity.conf-recommended /etc/modsecurity/modsecurity.conf
# turn detection mode to On (blocking) later; start with detection-only for testing
sudo sed -i 's/SecRuleEngine DetectionOnly/SecRuleEngine DetectionOnly/' /etc/modsecurity/modsecurity.conf

# enable apache module and restart
sudo a2enmod security2
sudo systemctl restart apache2
