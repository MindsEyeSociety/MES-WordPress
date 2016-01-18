# Provision MES Multisite

# Make a database, if we don't already have one
echo -e "\nCreating database 'mes' (if it's not already there)"
mysql -u root --password=root -e "CREATE DATABASE IF NOT EXISTS mes"
mysql -u root --password=root -e "GRANT ALL PRIVILEGES ON mes.* TO wp@localhost IDENTIFIED BY 'wp';"
echo -e "\n DB operations done.\n\n"

# Nginx Logs
if [ ! -d /srv/log/mes.dev ]; then
	mkdir /srv/log/mes.dev
fi

touch /srv/log/mes.dev/error.log
touch /srv/log/mes.dev/access.log

# Install and configure the latest stable version of WordPress
if [ ! -d /srv/www/mes.dev/wp-admin ]; then

	cd /srv/www/mes.dev

	echo "Downloading WordPress Multisite Subdomain Stable, see http://wordpress.org/"
	wp core download --allow-root

	echo "Configuring WordPress Multisite Subdomain Stable..."
	wp core config --dbname=mes --dbuser=wp --dbpass=wp --quiet --extra-php --allow-root <<PHP
define( 'WP_DEBUG', true );
PHP
	echo "Installing WordPress Multisite Subdomain Stable..."
	wp core multisite-install --allow-root --url=mes.dev --subdomains --quiet --title="Mind's Eye Society" --admin_name=admin --admin_email="admin@local.dev" --admin_password="password" --allow-root

	# Create sites
	wp site create --allow-root --slug=events --title="Events" --email="admin@local.dev" --quiet --allow-root
	wp site create --allow-root --slug=volunteer --title="Volunteer" --email="admin@local.dev" --quiet --allow-root
	wp site create --allow-root --slug=games --title="Games" --email="admin@local.dev" --quiet --allow-root
	wp site create --allow-root --slug=education --title="Education" --email="admin@local.dev" --quiet --allow-root

	# Removes unused themes
	wp theme delete twentyfifteen twentyfourteen --allow-root

	# Installs plugins
	wp plugin install jetpack regenerate-thumbnails developer debug-bar debug-bar-console debug-bar-extender events-manager rewrite-rules-inspector user-switching wordpress-importer --activate-network --allow-root
	wp plugin install https://github.com/alleyinteractive/wordpress-fieldmanager/archive/master.zip --allow-root
	mv wp-content/plugins/wordpress-fieldmanager-master wp-content/plugins/fieldmanager
	wp plugin activate fieldmanager --network --allow-root

	# Installs theme
	git -C mindseyesociety submodule update --init --recursive
	mv mindseyesociety wp-content/themes/mindseyesociety
	wp theme enable mindseyesociety --network --activate --allow-root

else

	echo "Updating WordPress installation..."
	cd /srv/www/mes.dev
	wp core upgrade --allow-root

fi
