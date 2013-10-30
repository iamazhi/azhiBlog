<?php
/**
 * The control file of site module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     site
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class site extends control
{
    /**
     * set site basic info.
     * 
     * @access public
     * @return void
     */
    public function setBasic()
    {
        if(!empty($_POST))
        {
            $result = $this->loadModel('setting')->setItems('system.common.site', $_POST);
            if($result) $this->send(array('result' => 'success', 'message' => $this->lang->setSuccess));
            $this->send(array('result' => 'fail', 'message' => $this->lang->fail));
        }

        $this->view->title = $this->lang->site->setBasic;
        $this->display();
    }

    /**
     * set logo.
     * 
     * @access public
     * @return void
     */
    public function setLogo()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            if(empty($_FILES)) $this->send(array('result' => 'fail', 'message' => $this->lang->error->noSelectedLogo));

            $fileModel =  $this->loadModel('file');

            /*upload new logo*/
            $logo = $fileModel->saveUpload('logo');
            if(!$logo) $this->send(array('result'=>'fail', 'message'=>$this->lang->fail, inlink('setLogo')));

            $fileID   = array_keys($logo);
            $logoFile = $fileModel->getById($fileID[0]); 

            /*delete old logo*/
            $oldLogos  = $fileModel->getByObject('logo', 0);
            foreach($oldLogos as $oldLogo)
            {
                if($oldLogo->id != $logoFile->id) $fileModel->delete($oldLogo->id);
            }
            
            /* save new logo data. */
            $setting  = new stdclass();

            $setting->fileID    = $logoFile->id;
            $setting->pathname  = $logoFile->pathname;
            $setting->webPath   = $logoFile->webPath;
            $setting->addedBy   = $logoFile->addedBy;
            $setting->addedDate = $logoFile->addedDate;

            $result = $this->loadModel('setting')->setItems('system.common.site', array('logo' => helper::jsonEncode($setting)));
            if($result)
            {
                $this->send(array('result' => 'success', 'message' => $this->lang->setSuccess, 'locate'=>inlink('setLogo')));
            }
            else
            {
                $this->send(array('result'=>'fail', 'message'=>$this->lang->fail, inlink('setLogo')));
            }
        }
            
        $this->view->title = $this->lang->site->setLogo;
        $this->view->logo = isset($this->config->site->logo) ? json_decode($this->config->site->logo) : false;

        $this->display();
    }

    /**
     * Set theme
     *
     * @param $theme
     * @access public
     * return void
     **/
     public function setTheme($theme = '')
     {
         if($theme and isset($this->lang->site->themes[$theme]))
         {  
            $result = $this->loadModel('setting')->setItems('system.common.site', array('theme' => $theme ));
            if($result) $this->send(array('result' => 'success', 'message' => $this->lang->setSuccess));
            $this->send(array('result' => 'fail', 'message' => $this->lang->fail));
         }
         $this->view->title = $this->lang->site->setTheme;
         $this->display();
     }

    /**
     * set site basic info.
     * 
     * @access public
     * return void
     */
    public function setOauth()
    {
        if(!empty($_POST))
        {
            $provider = $this->post->provider;
            $oauth    = array($provider => helper::jsonEncode($_POST));
            $result   = $this->loadModel('setting')->setItems('system.common.oauth', $oauth);
            if($result) $this->send(array('result' => 'success', 'message' => $this->lang->setSuccess));
            $this->send(array('result' => 'fail', 'message' => $this->lang->fail));
        }
        $this->view->title = $this->lang->site->setOauth;
        $this->display();
    }
}
