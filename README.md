## Admin Panel

# CLI commands

* Run frontend - composer run frontend-dev --timeout 36000

# Installation

1. Run in CLI: composer install
2. Run in CLI: composer run frontend-install
3. Do steps in the section (local only): SSL local installation + Backend local serve

# SSL local installation + Backend local serve

1. Install XAMPP (Windows)
2. Put this project's folder in xampp/htdocs
3. Go to xampp/apache and create file named v3.ext
4. Put this content into v3.ext:
	authorityKeyIdentifier=keyid,issuer
	basicConstraints=CA:FALSE
	keyUsage = digitalSignature, nonRepudiation, keyEncipherment, dataEncipherment
	subjectAltName = @alt_names
	[alt_names]
	DNS.1 = localhost
	DNS.2 = *.localvaren.com
	DNS.3 = localvaren.com
	DNS.4 = 127.0.0.1
	DNS.5 = 127.0.0.2
5. Edit file makecert.bat:
	find line like: bin\openssl x509 -in server.csr -out server.crt -req -signkey server.key -days 365
	change to: bin\openssl x509 -in server.csr -out server.crt -req -signkey server.key -days 1825 -extfile v3.ext
6. Launch file makecert.bat, when it asks for Common Name (e.g. server FQDN or YOUR name) then write there: localvaren.com
7. Check out xampp/apache/conf/httpd.conf:
	The following lines must be uncommented. Remove the preceeding "#".
		LoadModule ssl_module modules/mod_ssl.so
		Include conf/extra/httpd-ssl.conf
8. Edit xampp/apache/conf/extra/httpd-vhosts.conf by adding next content in the end:
	<VirtualHost *:80>
    ServerName localvaren.com
    ServerAlias localvaren.com
    DocumentRoot "G:/xampp/htdocs/admin-silva/public"
    RewriteEngine on
    RewriteCond %{SERVER_NAME} =www.localvaren.com [OR]
    RewriteCond %{SERVER_NAME} =localvaren.com
    RewriteRule ^ https://%{SERVER_NAME}%{REQUEST_URI} [END,NE,R=permanent]
	</VirtualHost>

	<VirtualHost *:443>
    ServerName localvaren.com
    ServerAlias localvaren.com
    DocumentRoot "G:/xampp/htdocs/admin-silva/public"
    SSLEngine on
    SSLCertificateFile "conf/ssl.crt/server.crt"
    SSLCertificateKeyFile "conf/ssl.key/server.key"
	</VirtualHost>
9. Go to your system disk, then open in notepad Windows/System32/drivers/etc/hosts.ics
10. Add this line in the end: 127.0.0.1 localvaren.com
11. Restart the computer and it's done.
