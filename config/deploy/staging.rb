############################################
# Setup Server
############################################

set :user, "joshuajohnson.co.uk"
set :host, "s156312.gridserver.com"
set :password, "cheeseball27"
server "#{host}", :app
set :deploy_to, "/home/156312/users/.home/domains/connectd.io/html"

############################################
# Setup Git
############################################

set :branch, "development"