<?php
/**
 * The control file of reply module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     reply
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class reply extends control
{
    /**
     * Reply a thread.
     * 
     * @param  int      $threadID 
     * @access public
     * @return void
     */
    public function post($threadID)
    {
        if($this->app->user->account == 'guest') die(js::locate($this->createLink('user', 'login')));

        if($_POST)
        {
            $replyID = $this->reply->post($threadID);

            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->send(array('result' => 'success', 'locate' => $this->createLink('thread', 'view', "threadID=$threadID")));
        }
    }

    /**
     * Edit a reply.
     * 
     * @param string $replyID 
     * @access public
     * @return void
     */
    public function edit($replyID)
    {
        if($this->app->user->account == 'guest') die(js::locate($this->createLink('user', 'login')));

        /* Judge current user has priviledge to edit the reply or not. */
        $reply = $this->reply->getByID($replyID);
        if(!$reply) die(js::locate('back'));

        $moderators = $this->loadModel('thread')->getModerators($reply->thread);
        if(!$this->thread->canEdit($moderators, $reply->author)) die(js::locate('back'));

        $thread = $this->thread->getByID($reply->thread);
        
        if($_POST)
        {
            $this->reply->update($replyID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));

            $this->send(array('result' => 'success', 'locate' => $this->createLink('thread', 'view', "threaID=$thread->id")));
        }

        $this->view->title  = $this->lang->reply->edit . $this->lang->colon . $thread->title;
        $this->view->reply  = $reply;
        $this->view->thread = $thread;
        $this->view->board  = $this->loadModel('tree')->getById($thread->board);

        $this->display();
    }

    /**
     * Delete a reply.
     * 
     * @param  int      $replyID 
     * @access public
     * @return void
     */
    public function delete($replyID)
    {
        $reply = $this->reply->getByID($replyID);
        if(!$reply) $this->send(array('result' => 'fail', 'message' => 'Not found'));

        $moderators = $this->loadModel('thread')->getModerators($reply->thread);
        if(!$this->thread->canManage($moderators)) $this->send(array('result' => 'fail'));

        $locate = helper::createLink('thread', 'view', "threadID=$reply->thread");
        if($this->reply->delete($replyID)) $this->send(array('result' => 'success', 'locate' => $locate));

        $this->send(array('result' => 'fail', 'message' => dao::getError()));
    }
}
