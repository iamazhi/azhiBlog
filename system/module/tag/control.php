<?php
/**
 * The control file of tag module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     tag
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class tag extends control
{
    /**
     * Browse tags in admin.
     * 
     * @access public
     * @return void
     */
    public function admin($recTotal = 0, $recPerPage = 10, $pageID = 1)
    {   
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        $tags = $this->get->tags ? $this->get->tags : array();
        $this->view->tags  = $this->tag->getList($tags, $pager);

        $this->view->title = $this->lang->tag->admin;
        $this->view->pager = $pager;
        $this->view->tagOptions = $this->tag->getOptionMenu();
        $this->display();
    }   

    /**
     * Edit one tag.
     * 
     * @param  int    $tagID 
     * @access public
     * @return void
     */
    public function link($tagID)
    {
        if(!empty($_POST))
        {
            $this->dao->update(TABLE_TAG)->set('link')->eq($this->post->link)->where('id')->eq($tagID)->exec();
            if(!dao::isError()) $this->send(array('result' => 'success'));
            $this->send(array('result' => 'fail', 'message' => dao::getError()));
        }
        $this->view->tag = $this->dao->select('*')->from(TABLE_TAG)->where('id')->eq($tagID)->fetch();
        $this->display();
    }
}
