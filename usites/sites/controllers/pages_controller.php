<?php
  class PagesController extends Controller{
    public $add_models = array("sites","sitePages");
    public function error() {
      SystemMessages::add_err_message("Oops! seems like you are in the wrong place");
      $this->include_view('pages/error.php');
    }

    protected function init_setup($action){
      $this->data['site'] = Sites::get_current_site();
      $this->data['page_meta_title'] = $this->data['site']['title'];
      return parent::init_setup($action);
    }

    protected function handle_access($action){
      switch ($action){
        case 'error':
        default:
          return true;
          break;
        
      }
    }

    protected function page_view(){
      $page = SitePages::get_current_page();
      if(!$page){
        return $this->error();
      }
      $this->data['page'] = $page;
      $this->data['page_meta_title'] = $page['meta_title'];
      $this->include_view('pages/page_view.php');
    }

    protected function home(){
      $this->include_view('pages/home.php');
    }

  }
?>