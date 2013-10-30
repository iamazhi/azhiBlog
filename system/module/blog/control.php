<?php
/**
 * The control file of blog category of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     blog
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class blog extends control
{
    /** 
     * Browse blog in front.
     * 
     * @param int    $categoryID   the category id
     * @param int    $pageID       current page id
     * @access public
     * @return void
     */
    public function index($categoryID = 0, $pageID = 1)
    {   
        $this->app->loadClass('pager', $static = true);
        $pager = new pager(0, 10, $pageID);

        $category = $this->loadModel('tree')->getById($categoryID);
        $articles = $this->loadMOdel('article')->getList('blog', $this->tree->getFamily($categoryID, 'blog'), $orderBy = 'id_desc', $pager);

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
     * View an article.
     * 
     * @param int $articleID 
     * @param int $currentCategory 
     * @access public
     * @return void
     */
    public function view($articleID, $currentCategory = 0)
    {
        $article  = $this->loadModel('article')->getById($articleID);

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
        $this->view->links       = $this->loadModel('article')->getPairs($category->id, 't1.order');
        $this->view->prevAndNext = $this->loadModel('article')->getPrevAndNext($this->view->links, $article->id);
        $this->view->category    = $category;
        $this->view->contact     = $this->loadModel('company')->getContact();

        $this->dao->update(TABLE_ARTICLE)->set('views = views + 1')->where('id')->eq($articleID)->exec(false);
        $this->display();
    }
}
