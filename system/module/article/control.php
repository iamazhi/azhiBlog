<?php
/**
 * The control file of article category of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     article
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class article extends control
{
    /** 
     * The index page, locate to the first category or home page if no category.
     * 
     * @access public
     * @return void
     */
    public function index()
    {   
        $category = $this->loadModel('tree')->getFirst('article');
        if($category) $this->locate(inlink('browse', "category=$category->id"));
        $this->locate($this->createLink('index'));
    }   

    /** 
     * Browse article in front.
     * 
     * @param int    $categoryID   the category id
     * @param int    $pageID       current page id
     * @access public
     * @return void
     */
    public function browse($categoryID = 0, $pageID = 1)
    {   
        $type = 'article';
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal = 0, $recPerPage = 6, $pageID);
        $category = $this->loadModel('tree')->getById($categoryID);
        $articles = $this->article->getList($type, $this->tree->getFamily($categoryID, $type), 'id_desc', $pager);

        if($category)
        {
            $title    = $category->name;
            $keywords = trim($category->keyword . ' ' . $this->config->site->keywords);
            $desc     = strip_tags($category->desc);
            $this->session->set('articleCategory', $category->id);
        }

        $this->view->title     = $title;
        $this->view->keywords  = $keywords;
        $this->view->desc      = $desc;
        $this->view->category  = $category;
        $this->view->articles  = $articles;
        $this->view->pager     = $pager;
        $this->view->contact   = $this->loadModel('company')->getContact();
        //$this->view->layouts = $this->loadModel('block')->getLayouts('article.list');

        $this->display();
    }
    
    /**
     * Browse article in admin.
     * 
     * @param string $type        the article type
     * @param int    $categoryID  the category id
     * @param int    $recTotal 
     * @param int    $recPerPage 
     * @param int    $pageID 
     * @access public
     * @return void
     */
    public function admin($type = 'article', $categoryID = 0, $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {   
        $this->lang->article->menu = $this->lang->$type->menu;
        $this->lang->menuGroups->article = $type;

        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        $children = $this->loadModel('tree')->getChildren($categoryID, $type);
        if($children || strpos($type, 'book_') === false)
        {
            $orderBy = 'id_desc';
        }
        else
        {
            $orderBy = 't1.order';
        }
        
        $families = $categoryID ? $this->loadModel('tree')->getFamily($categoryID, $type) : '';
        $articles = $this->article->getList($type, $families, $orderBy, $pager);

        if(strpos($type, 'book') !== false)
        {
            $this->view->categoryBox = $this->loadModel('help')->getCategoryBox($type);
            unset($this->lang->article->menu);
            $this->lang->menuGroups->article = 'help';
            $i = 1;
            foreach($articles as $article)
            {
                if(!$children)
                {
                    $article->order = $this->post->maxOrder + $i * 10;
                }
                else
                {
                    $article->order = $article->id; 
                }
                $i++;
            }
        }

        $this->view->title    = $type == 'blog' ? $this->lang->blog->admin : $this->lang->article->admin;
        $this->view->articles = $articles;
        $this->view->pager    = $pager;
        $this->view->children = $children;
        $this->view->type     = $type;

        if(strpos($type, 'book') !== false)
        {
            $this->display('article', 'bookadmin');
            exit;
        }

        $this->display();
    }   

    /**
     * Create a article.
     * 
     * @param  string $type 
     * @param  int    $categoryID
     * @access public
     * @return void
     */
    public function create($type = 'article', $categoryID = '')
    {
        $this->lang->article->menu = $this->lang->$type->menu;
        $this->lang->menuGroups->article = $type;

        if(strpos($type, 'book') !== false)
        {
            $this->view->categoryBox = $this->loadModel('help')->getCategoryBox($type);
            unset($this->lang->article->menu);
            $this->lang->menuGroups->article = 'help';
        }

        $categories = $this->loadModel('tree')->getOptionMenu($type, 0, $removeRoot = true);
        if(empty($categories))
        {
            die(js::alert($this->lang->tree->noCategories) . js::locate($this->createLink('tree', 'browse', "type=$type")));
        }

        if($_POST)
        {
            $this->article->create($type);       
            if(dao::isError())  $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate'=>inlink('admin', "type=$type")));
        }

        $this->view->title           = $this->lang->article->create;
        $this->view->currentCategory = $categoryID;
        $this->view->categories      = $this->loadModel('tree')->getOptionMenu($type, 0, $removeRoot = true);
        $this->view->type            = $type;

        $this->display();
    }

    /**
     * Edit an article.
     * 
     * @param  int $articleID 
     * @access public
     * @return void
     */
    public function edit($articleID, $type)
    {
        $this->lang->article->menu = $this->lang->$type->menu;
        $this->lang->menuGroups->article = $type;

        if(strpos($type, 'book') !== false)
        {
            $this->view->categoryBox = $this->loadModel('help')->getCategoryBox($type);
            unset($this->lang->article->menu);
            $this->lang->menuGroups->article = 'help';
        }

        $article    = $this->article->getByID($articleID, $replaceTag = false);

        $categories = $this->loadModel('tree')->getOptionMenu($type, 0, $removeRoot = true);
        if(empty($categories))
        {
            die(js::alert($this->lang->tree->noCategories) . js::locate($this->createLink('tree', 'browse', "type=$type")));
        }

        if($_POST)
        {
            $this->article->update($articleID, $type);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('admin', "type=$type")));
        }

        $this->view->title      = $this->lang->article->edit;
        $this->view->article    = $article;
        $this->view->categories = $categories;
        $this->view->type       = $type;
        $this->display();
    }

    /**
     * View an article.
     * 
     * @param int $articleID 
     * @access public
     * @return void
     */
    public function view($articleID)
    {
        $article  = $this->article->getById($articleID);

        /* fetch category for display. */
        $category = array_slice($article->categories, 0, 1);
        $category = $category[0]->id;

        $currentCategory = $this->session->articleCategory;
        if($currentCategory > 0 && isset($article->categories[$currentCategory])) $category = $currentCategory;  

        $category = $this->loadModel('tree')->getById($category);

        $title    = $article->title . ' - ' . $category->name;
        $keywords = $article->keywords . ' ' . $category->keyword . ' ' . $this->config->site->keywords;
        $desc     = strip_tags($article->summary);
        
        $this->view->title       = $title;
        $this->view->keywords    = $keywords;
        $this->view->desc        = $desc;
        $this->view->article     = $article;
        $this->view->links       = $this->article->getPairs($category->id, 'id_desc');
        $this->view->prevAndNext = $this->article->getPrevAndNext($this->view->links, $article->id);
        $this->view->category    = $category;
        $this->view->contact     = $this->loadModel('company')->getContact();

        $this->dao->update(TABLE_ARTICLE)->set('views = views + 1')->where('id')->eq($articleID)->exec(false);

        $this->display();
    }

    /**
     * Update order fields.
     * 
     * @access public
     * @return void
     */
    public function updateOrder($type = 'article')
    {
        if($this->post->orders)
        {
            $orders = array_flip($this->post->orders);
            ksort($orders);

            $i = 0;
            foreach($orders as $articleID)
            {
                $order = $i * 10;
                $this->dao->update(TABLE_ARTICLE)
                    ->set('`order`')->eq($order)
                    ->where('id')->eq($articleID)
                    ->limit(1)
                    ->exec(false);
                $i++;
            }

            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('admin', "type=$type")));
        }
    }

    /**
     * Delete an article.
     * 
     * @param  int      $articleID 
     * @access public
     * @return void
     */
    public function delete($articleID)
    {
        if($this->article->delete($articleID)) $this->send(array('result' => 'success'));
        $this->send(array('result' => 'fail', 'message' => dao::getError()));
    }
}
