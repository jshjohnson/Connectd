############################################
# Setup Server
############################################

set :application, "dev.connectd.io" # typically the same as the domain
server "#{host}", :app

############################################
# Setup Git
############################################

set :branch, "development"