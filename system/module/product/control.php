<?php
/**
 * The control file of product category of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     product
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class product extends control
{
    /** 
     * Browse product in front.
     * 
     * @param int    $categoryID   the category id
     * @param int    $pageID       current page id
     * @access public
     * @return void
     */
    public function browse($categoryID = 0, $pageID = 1)
    {  
        $this->app->loadClass('pager', $static = true);
        $pager = new pager(0, 15, $pageID);

        $category = $this->loadModel('tree')->getById($categoryID);
        $products = $this->product->getList($this->tree->getFamily($categoryID), 'id_desc', $pager);

        if($category)
        {
            $title    = $category->name;
            $keywords = trim($category->keyword . ' ' . $this->config->site->keywords);
            $desc     = strip_tags($category->desc);
            $this->session->set('productCategory', $category->id);
        }

        $this->view->title     = $title;
        $this->view->keywords  = $keywords;
        $this->view->desc      = $desc;
        $this->view->category  = $category;
        $this->view->products  = $products;
        $this->view->pager     = $pager;
        $this->view->contact   = $this->loadModel('company')->getContact();

        $this->display();
    }

    /**
     * Browse product in admin.
     * 
     * @param int    $categoryID  the category id
     * @param string $orderBy     the order by
     * @param int    $recTotal 
     * @param int    $recPerPage 
     * @param int    $pageID 
     * @access public
     * @return void
     */
    public function admin($categoryID = 0, $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {   
        /* Set the session. */
        $this->session->set('productList', $this->app->getURI(true));

        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);
        
        $families = '';
        if($categoryID) $families = $this->loadModel('tree')->getFamily($categoryID, 'product');
        $products = $this->product->getList($families, $orderBy, $pager);

        $this->view->title    = $this->lang->product->admin;
        $this->view->products = $products;
        $this->view->pager    = $pager;
        $this->view->type     = $type;
        $this->display();
    }   

    /**
     * Create a product.
     * 
     * @access public
     * @return void
     */
    public function create()
    {
        $categories = $this->loadModel('tree')->getOptionMenu('product', 0, $removeRoot = true);
        if(empty($categories))
        {
            die(js::alert($this->lang->tree->noCategories) . js::locate($this->createLink('tree', 'browse', 'type=product')));
        }

        if($_POST)
        {
            $this->product->create();       
            if(dao::isError())  $this->send(array('result' => 'fail', 'message' => dao::geterror()));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate'=>inlink('admin')));
        }

        $this->view->title      = $this->lang->product->create;
        $this->view->categories = $categories;
        $this->display();
    }

    /**
     * Edit a product.
     * 
     * @param  int $productID 
     * @access public
     * @return void
     */
    public function edit($productID)
    {
        $categories = $this->loadModel('tree')->getOptionMenu('product', 0, $removeRoot = true);
        if(empty($categories))
        {
            die(js::alert($this->lang->tree->noCategories) . js::locate($this->createLink('tree', 'browse', 'type=product')));
        }

        if($_POST)
        {
            $this->product->update($productID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('admin')));
        }

        $product    = $this->product->getByID($productID);

        $this->view->title      = $this->lang->product->edit;
        $this->view->product    = $product;
        $this->view->categories = $categories;

        $this->display();
    }

    /**
     * View a product.
     * 
     * @param int $productID 
     * @access public
     * @return void
     */
    public function view($productID)
    {
        $product = $this->product->getById($productID);

        /* fetch first category for display. */
        $category = array_slice($product->categories, 0, 1);
        $category = $category[0]->id;

        $currentCategory = $this->session->productCategory;
        if($currentCategory > 0 && isset($product->categories[$currentCategory])) $category = $currentCategory;  
        $category = $this->loadModel('tree')->getById($category);

        $title    = $product->name . ' - ' . $category->name;
        $keywords = $product->keywords . ' ' . $category->keyword . ' ' . $this->config->site->keywords;
        $desc     = strip_tags($product->summary);
        
        $this->view->title       = $title;
        $this->view->keywords    = $keywords;
        $this->view->desc        = $desc;
        $this->view->product     = $product;
        $this->view->links       = $this->product->getPairs($category->id, 'id_desc');
        $this->view->prevAndNext = $this->product->getPrevAndNext($this->view->links, $product->id);
        $this->view->category    = $category;
        $this->view->contact     = $this->loadModel('company')->getContact();

        $this->dao->update(TABLE_PRODUCT)->set('views = views + 1')->where('id')->eq($productID)->exec(false);

        $this->display();
    }

    /**
     * Delete a product.
     * 
     * @param  int      $productID 
     * @access public
     * @return void
     */
    public function delete($productID)
    {
        if($this->product->delete($productID)) $this->send(array('result' => 'success'));
        $this->send(array('result' => 'fail', 'message' => dao::getError()));
    }
}
