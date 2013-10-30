<?php
/**
 * The control file of partner module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     partner
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class partner extends control
{
    /**
     * partner profile.
     * 
     * @access public
     * @return void
     */
    public function index()
    {
        $this->view->partner = $this->config->partner;
        $this->display();
    }

    /**
     * set partner links.
     * 
     * @access public
     * @return void
     */
    public function setLink()
    {
        if(!empty($_POST))
        {
            $result = $this->loadModel('setting')->setItems('system.common.partner', (object)$_POST);
            if($result) $this->send(array('result' => 'success', 'message' => $this->lang->setSuccess));
            $this->send(array('result' => 'fail', 'message' => $this->lang->fail));
        }
        $this->view->title = $this->lang->partner->common;
        $this->display();
    }
}
