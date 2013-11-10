############################################
# Setup Server
############################################

set :user, "mixdsftpuser"
set :host, "mixd-server-master-002.mixd.co.uk"
server "#{host}", :app
set :deploy_to, "/var/www/tripartite.mixd.co.uk/httpdocs"

############################################
# Setup Git
############################################

set :branch, "development"