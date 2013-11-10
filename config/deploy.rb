############################################
# Setup Stages
############################################

set :stages, %w(production staging)
set :default_stage, "staging"
require 'capistrano/ext/multistage'
require 'yaml'

after "deploy", "deploy:cleanup"

############################################
# Setup Git
############################################

set :application, "Connectd"
set :repository, "git@github.com:jshjohnson/Connectd.git"
set :scm, :git
set(:git_enable_submodules, true)
# set :deploy_via, :remote_cache
set :copy_exclude, [".git", ".DS_Store", ".gitignore", ".gitmodules", "capfile", "config/"]

############################################
# Setup Server
############################################

set :use_sudo, false
ssh_options[:forward_agent] = true

############################################
# Recipies
############################################

### Git

namespace :git do
    desc "Updates git submodule tags"
    task :submodule_tags do
        run "if [ -d #{shared_path}/cached-copy/ ]; then cd #{shared_path}/cached-copy/ && git submodule foreach --recursive git fetch origin --tags; fi"
    end

    desc "Reinitalises git repo and submodules"
    task :setup do
        system("bash config/bash/git_init.sh")
    end
end

before "deploy", "git:submodule_tags"

### Database

namespace :db do
    task :backup_name, :roles => :app do
        now = Time.now
        run "mkdir -p #{shared_path}/db_backups"
        backup_time = [now.year,now.month,now.day,now.hour,now.min,now.sec].join()
        set :backup_file, "#{shared_path}/db_backups/#{backup_time}.sql"
    end

    desc "Takes a database dump from remote server"
    task :dump do
        backup_name
        puts "Dumping remote database..."
        database = YAML::load_file('config/database.yml')[stage.to_s]
        run "mysqldump --add-drop-table -h #{database['host']} -u #{database['username']} -p#{database['password']} #{database['database']} > #{backup_file}"
    end

    desc "Syncs remote database to local database"
    task :sync_to_local do
        backup_name
        dump
        puts "Downloading remote backup..."
        get "#{backup_file}", "/tmp/#{application}.sql"
        puts "Removing remote backup..."
        run "rm #{backup_file}"
        database = YAML::load_file('config/database.yml')['local']
        puts "Importing into local database..."
        system("mysql -h #{database['host']} -u #{database['username']} -p#{database['password']} #{database['database']} < /tmp/#{application}.sql")
        puts "Removing local backup..."      
        system("rm /tmp/#{application}.sql")
    end

    desc "Syncs local database to remote database"
    task :sync_to_remote do
        backup_name
        puts "Dumping local database..."
        database = YAML::load_file('config/database.yml')['local']
        system("mysqldump --add-drop-table -h #{database['host']} -u #{database['username']} -p'#{database['password']}' #{database['database']} > /tmp/#{application}.sql")
        puts "Uploading local backup..."
        upload "/tmp/#{application}.sql", "#{backup_file}"
        puts "Removing local backup..."
        system("rm /tmp/#{application}.sql")
        puts "Importing into remote database..."
        database = YAML::load_file('config/database.yml')[stage.to_s]
        run "mysql -h #{database['host']} -u #{database['username']} -p'#{database['password']}' #{database['database']} < #{backup_file}"
        puts "Removing remote backup..."
        run "rm #{backup_file}"

    end
end

