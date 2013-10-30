<?php
/**
 * The control file of article category of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     article
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class rss extends control
{
    /**
     * Output the rss.
     * 
     * @access public
     * @return void
     */
    public function index()
    {
        $type = $this->get->type != false ? $this->get->type : 'blog';
        $this->loadModel('tree');
        $this->loadModel('article');

        $this->app->loadClass('pager', $static = true);
        $pager = new pager(0, $this->config->rss->items, 1);

        $articles = $this->article->getList($type, $this->tree->getFamily(0, $type), 'id_desc', $pager);
        $latestArticle = current((array)$articles);

        $this->view->title    = $this->config->site->name;
        $this->view->desc     = $this->config->site->desc;
        $this->view->siteLink = $this->inlink('browse', "type={$type}");
        $this->view->siteLink = commonModel::getSysURL();

        $this->view->articles = $articles;
        $this->view->lastDate = $latestArticle->addedDate . ' +0800';
         
        header("Content-type: text/xml");

        $this->display();
    }
}
