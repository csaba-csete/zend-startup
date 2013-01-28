require_recipe "apt"
require_recipe "build-essential"
require_recipe "networking_basic"
require_recipe "apache2"
include_recipe "apache2::mod_php5"
include_recipe "apache2::mod_rewrite"
include_recipe "apache2::mod_deflate"
include_recipe "apache2::mod_headers"
require_recipe "mysql::server"
require_recipe "vagrant_main::custom_php"
require_recipe "elasticsearch"
require_recipe "ant"
require_recipe "memcached"
require_recipe "phpmyadmin"

# Install mysql gem
gem_package "mysql" do
  action :install
end

web_app "application" do
  template "application.conf.erb"
  notifies :restart, resources(:service => "apache2")
end