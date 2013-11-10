############################################
# Setup Server
############################################

set :user, "joshuajohnson.co.uk"
set :host, "s156312.gridserver.com"
server "#{host}", :app
set :deploy_to, "/domains/connectd.io/html/"

############################################
# Setup Git
############################################

set :branch, "master"