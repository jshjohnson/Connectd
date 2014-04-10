############################################
# Requirements
############################################

require 'rubygems' 
require 'bundler/setup'
require 'capistrano/ext/multistage'
require 'yaml'

############################################
# Setup Stages
############################################

set :stages, %w(prd dev)
set :default_stage, "dev"
set :keep_releases, 2

after "deploy", "deploy:cleanup"


############################################
# Setup Site
############################################

set :site, "156312" # this is your site number, https://kb.mediatemple.net/questions/268/What+is+my+site+number%3F#gs
set(:host) { "s156312.gridserver.com" }
set(:domain) { "s156312.gridserver.com" }
set(:user) { "connectd.io" }

############################################
# Setup Git
############################################

set :repository, "git@github.com:jshjohnson/Connectd.git"
set :scm, :git
set(:git_enable_submodules, true)
set :deploy_via, :remote_cache
set :copy_exclude, [".git", ".DS_Store", ".gitignore", ".gitmodules", "capfile", "config/"]

############################################
# Setup Server
############################################

set :use_sudo, false
ssh_options[:forward_agent] = true

# Path stuff, make sure to symlink html to ./current
set(:deploy_to) { "/home/156312/domains/#{application}" }
set :current_dir, "html"

# we need a relative path for the current symlink, without this
# current is set to link to the release starting from the /home directory
# which has a directory that is not owned by the serveradmin and apache
# won't have access
def relative_path(from_str, to_str)
  require 'pathname'
  Pathname.new(to_str).relative_path_from(Pathname.new(from_str)).to_s
end
 
# overwrite the symlink method to use the relative path method above
namespace :deploy do
  desc "Relative symlinks for current, so we don't use full path"
  task :create_symlink, :except => { :no_release => true } do
    if releases[-2] # not the first release
      previous_release_relative = relative_path(deploy_to, previous_release + '/htdocs')
      on_rollback { run "rm -f #{current_path}; ln -s #{previous_release_relative} #{current_path}; true" }
    end
    latest_release_relative = relative_path(deploy_to, latest_release + '/htdocs')
    run "rm -f #{current_path} && ln -s #{latest_release_relative} #{current_path}"
  end
end

### Site

namespace :site do
    desc "Setup symlinks for project"
    task :create_symlinks, :roles => :app do
        run "ln -nfs /home/156312/domains/#{application}/shared/config.php #{current_path}/config.php"
        run "ln -nfs /home/156312/domains/#{application}/shared/.htaccess-master #{current_path}/.htaccess"
    end

    desc "Create files and directories for site environment"
    task :setup, :roles => :app do
        run "touch #{shared_path}/.htaccess-master"

        siteurl = Capistrano::CLI.ui.ask("#{stage} site URL: ")
        database = YAML::load_file('config/database.yml')[stage.to_s]

        db_config = ERB.new(File.read('./config/templates/config.php.erb')).result(binding)
        accessfile = ERB.new(File.read('./config/templates/.htaccess.erb')).result(binding)

        put db_config, "#{shared_path}/config.php"
        put accessfile, "#{shared_path}/.htaccess-master"
    end

    desc "Sets up config and .htaccess for your local environment"
    task :setup_local, :roles => :app do
        database = YAML::load_file('config/database.yml')['local']
        siteurl = Capistrano::CLI.ui.ask("local site URL: ")
        db_config = ERB.new(File.read('./config/templates/config.php.erb')).result(binding)
        accessfile = ERB.new(File.read('./config/templates/.htaccess.erb')).result(binding)

        puts "Creating local config.php and .htaccess"
        File.open("htdocs/config.php", 'w') {|f| f.write(db_config) }
        File.open("htdocs/.htaccess", 'w') {|f| f.write(accessfile) }

    end

end

after "deploy:create_symlink", "site:create_symlinks"
after "deploy:setup", "site:setup"

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
    task :pull do
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
    task :push do
        backup_name
        puts "Dumping local database..."
        database = YAML::load_file('config/database.yml')['local']
        system("mysqldump --add-drop-table -h #{database['host']} -u #{database['username']} -p#{database['password']} #{database['database']} > /tmp/#{application}.sql")
        puts "Uploading local backup..."
        upload "/tmp/#{application}.sql", "#{backup_file}"
        puts "Removing local backup..."
        system("rm /tmp/#{application}.sql")
        puts "Importing into remote database..."
        database = YAML::load_file('config/database.yml')[stage.to_s]
        run "mysql -h #{database['host']} -u #{database['username']} -p#{database['password']} #{database['database']} < #{backup_file}"
        puts "Removing remote backup..."
        run "rm #{backup_file}"

    end
end

### Confirmations

task :confirm do
  set(:confirmed) do
    puts <<-WARN
    \e[31m
    ========================================================================
 
      WARNING: You're about to sync to a LIVE database or deploy to a LIVE
      production environment.

      Please confirm that you're not going to fuck things up.
 
    ========================================================================
    \e[0m
    WARN
    answer = Capistrano::CLI.ui.ask "\e[31m    Are you sure you want to continue? (y) \e[0m"
    if answer == 'y' then true else false end
  end
 
  unless fetch(:confirmed)
    puts "\nDeploy cancelled!"
    exit
  end
end
 
before 'db:push', :confirm
before 'production', :confirm



