<?php
  class PagesController extends CrudController{
    public $add_models = array("sitePages","siteBlocks");
    public function error() {
      SystemMessages::add_err_message("Oops! seems like you are in the wrong place");
      $this->include_view('pages/error.php');
    }

    protected function init_setup($action){
      $this->data['page_meta_title'] = $this->data['site']['title'];
      return parent::init_setup($action);
    }

    protected function page_view(){
      $page = SitePages::get_current_page();
      $this->add_asset_mapping(SitePages::$assets_mapping);
      if(!$page){
        return $this->error();
      }
      $this->data['page'] = $page;
      $this->data['page_meta_title'] = $page['meta_title'];

      $this->data['content_blocks'] = SiteBlocks::get_current_page_blocks();


      $this->include_view('pages/page_view.php');
    }

    protected function home(){
      return $this->page_view();
    }

  }
?>