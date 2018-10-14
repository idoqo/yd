RewriteEngine On
# Allow any files or directories that exist to be displayed directly
RewriteCond %{REQUEST_FILENAME} !-f 
RewriteCond %{REQUEST_FILENAME} !-d

RewriteRule ^/?signup/(.*)/? signup.php?utype=$1

RewriteRule ^/?addproject create_job.php