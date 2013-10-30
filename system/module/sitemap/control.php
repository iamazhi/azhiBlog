<?php
/**
 * The control file of sitemap of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     sitemap
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class sitemap extends control
{
    /**
     * Output the sitemap.
     * 
     * @access public
     * @return void
     */
    public function index()
    {
        if(strcmp(substr($_SERVER["REQUEST_URI"], -(strlen('sitemap.xml'))), 'sitemap.xml')==0) header("Content-type: text/xml");

        $this->loadModel('tree');
        $this->loadModel('article');
        $this->loadModel('product');
        $this->loadModel('forum');
        $this->loadModel('thread');

        $this->app->loadClass('pager', $static = true);
        $pager = new pager(0, $this->config->sitemap->items, 1);

        $bookArticles = $this->dao->select('*')->from(TABLE_ARTICLE)->where('type')->like("book_%")->fi()->fetchAll('id');
        $articles     = $this->article->getList('article', $this->tree->getFamily(0, 'article'), 'id_desc', $pager);
        $blogs        = $this->article->getList('blog', $this->tree->getFamily(0, 'blog'), 'id_desc', $pager);
        $products     = $this->product->getList($this->tree->getFamily(0), 'id_desc', $pager);
        $threads      = $this->thread->getList($this->tree->getFamily(0), 'id_desc', $pager);

        $this->view->siteLink       = commonModel::getSysURL();
        $this->view->bookArticles   = $bookArticles;
        $this->view->articles       = $articles;
        $this->view->blogs          = $blogs;
        $this->view->products       = $products;
        $this->view->threads        = $threads;
        $this->view->articleTree    =  $this->tree->getTreeMenu('article', 0, array('treeModel', 'createBrowseLink'));
        $this->view->productTree    =  $this->tree->getTreeMenu('product', 0, array('treeModel', 'createProductBrowseLink'));
        $this->view->blogTree       =  $this->tree->getTreeMenu('blog', 0, array('treeModel', 'createBlogBrowseLink'));
        $this->view->boards         =  $this->forum->getBoards();

        $this->display();
    }
}
