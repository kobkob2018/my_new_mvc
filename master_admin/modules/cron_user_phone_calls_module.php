<?php
  class cron_user_phone_callsModule extends CrudController{

    public $add_models = array("user_phone_calls");


    protected function update_new_calls(){
        $link_user = get_config('link_user');
        $link_pass = get_config('link_pass');
        $link_db = get_config('link_db');
        $link_server = get_config('link_server');
        $link_port = get_config('link_port');
        $link_server_with_port = $link_server.":".$link_port;
        echo "todo: insert the site_leads_stats...";
    }

  }
?>