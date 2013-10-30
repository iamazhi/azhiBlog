<?php
/**
 * The model file of product category of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     product
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class productModel extends model
{
    /** 
     * Get an product by id.
     * 
     * @param  int      $productID 
     * @access public
     * @return bool|object
     */
    public function getByID($productID)
    {   
        /* Get product self. */
        $product = $this->dao->select('*')->from(TABLE_PRODUCT)->where('id')->eq($productID)->fetch();
        if(!$product) return false;

        /* Get it's categories. */
        $product->categories = $this->dao->select('t2.*')
            ->from(TABLE_RELATION)->alias('t1')
            ->leftJoin(TABLE_CATEGORY)->alias('t2')->on('t1.category = t2.id')
            ->where('t1.type')->eq('product')
            ->andWhere('t1.id')->eq($productID)
            ->fetchAll('id');

        /* Get product path to highlight main nav. */
        $path = '';
        foreach($product->categories as $category) $path .= $category->path;
        $product->path = explode(',', trim($path, ','));

        /* Get it's files. */
        $product->files = $this->loadModel('file')->getByObject('product', $productID);

        $product->images = $this->file->getByObject('product', $productID, $isImage = true );

        $product->image = new stdclass();
        $product->image->list    = $product->images;
        $product->image->primary = $product->image->list[0];

        return $product;
    }   

    /** 
     * Get product list.
     * 
     * @param  array   $categories 
     * @param  string  $orderBy 
     * @param  object  $pager 
     * @access public
     * @return array
     */
    public function getList($categories, $orderBy, $pager = null)
    {
        /* Get products(use groupBy to distinct products).  */
        $products = $this->dao->select('t1.*, t2.category')->from(TABLE_PRODUCT)->alias('t1')
            ->leftJoin(TABLE_RELATION)->alias('t2')->on('t1.id = t2.id')
            ->where('1 = 1')
            ->beginIF($categories)->andWhere('t2.category')->in($categories)->fi()
            ->groupBy('t2.id')
            ->orderBy($orderBy)
            ->page($pager)
            //->printSQL();
            ->fetchAll('id');
        if(!$products) return array();

        /* Get categories for these products. */
        $categories = $this->dao->select('t2.id, t2.name, t2.alias, t1.id AS product')
            ->from(TABLE_RELATION)->alias('t1')
            ->leftJoin(TABLE_CATEGORY)->alias('t2')->on('t1.category = t2.id')
            ->where('t2.type')->eq('product')
            ->beginIF($categories)->andWhere('t1.category')->in($categories)->fi()
            ->fetchGroup('product', 'id');

        /* Assign categories to it's product. */
        foreach($products as $product) $product->categories = $categories[$product->id];

        /* Get images for these products. */
        $images = $this->loadModel('file')->getByObject('product', array_keys($products), $isImage = true);

        /* Assign images to it's product. */
        foreach($products as $product)
        {
            if(empty($images[$product->id])) continue;

            $product->image->list    = $images[$product->id];
            $product->image->primary = $product->image->list[0];
        }
        
        /* Assign summary to it's product. */
        foreach($products as $product) $product->summary = empty($product->summary) ? helper::substr(strip_tags($product->content), 250) : $product->summary;

        return $products;
    }

    /**
     * Get product pairs.
     * 
     * @param string $modules 
     * @param string $orderBy 
     * @param string $pager 
     * @access public
     * @return array
     */
    public function getPairs($categories, $orderBy, $pager = null)
    {
        return $this->dao->select('t1.id, t1.name, t1.alias')->from(TABLE_PRODUCT)->alias('t1')
            ->leftJoin(TABLE_RELATION)->alias('t2')
            ->on('t1.id = t2.id')
            ->beginIF($categories)->where('t2.category')->in($categories)->fi()
            ->orderBy($orderBy)
            ->page($pager, false)
            ->fetchAll('id');
    }

    /**
     * get latest products. 
     *
     * @param array      $categories
     * @param int        $count
     * @access public
     * @return array
     */
    public function getLatest($categories, $count)
    {
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal = 0, $recPerPage = $count, $pageID = 1);

        return $this->getList($categories, 'id_desc', $pager);
    }

    /**
     * get hot products. 
     *
     * @param array      $categories
     * @param int        $count
     * @access public
     * @return array
     */
    public function getHot($categories, $count)
    {
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal = 0, $recPerPage = $count, $pageID = 1);

        return $this->getList($categories, 'views_desc', $pager);
    }

    /**
     * Get the prev and next product.
     * 
     * @param  array  $links    the link products.
     * @param  int    $current  the current product id.
     * @access public
     * @return array
     */
    public function getPrevAndNext($links, $current)
    {
        $prev = array();
        $next = array();
        $keys = array_keys($links);

        $currentKey = array_search($current, $keys);
        $prevKey    = $currentKey - 1;
        $nextKey    = $currentKey + 1;

        if(isset($keys[$prevKey])) $prev = array('id' => $keys[$prevKey], 'name' => $links[$keys[$prevKey]]->name, 'alias' => $links[$keys[$prevKey]]->alias);
        if(isset($keys[$nextKey])) $next = array('id' => $keys[$nextKey], 'name' => $links[$keys[$nextKey]]->name, 'alias' => $links[$keys[$nextKey]]->alias);

        return array('prev' => $prev, 'next' => $next);
    }

    /**
     * Create a product.
     * 
     * @access public
     * @return int|bool
     */
    public function create()
    {
        $product = fixer::input('post')
            ->join('categories', ',')
            ->setDefault('price', 0)
            ->setDefault('amount', 0)
            ->setDefault('promotion', 0)
            ->add('author', $this->app->user->account)
            ->add('addedDate', helper::now())
            ->get();

        $product->alias    = seo::processAlias($product->alias);
        $product->keywords = seo::processTags($product->keywords);

        $this->dao->insert(TABLE_PRODUCT)
            ->data($product, $skip = 'categories')
            ->autoCheck()
            ->batchCheck($this->config->product->create->requiredFields, 'notempty')
            ->exec();

        if(dao::isError()) return false;

        $productID = $this->dao->lastInsertID();

        $this->loadModel('tag')->save($product->keywords);
        $this->processCategories($productID, $this->post->categories);
        return $productID;
    }

    /**
     * Update a product.
     * 
     * @param  int $productID 
     * @access public
     * @return void
     */
    public function update($productID)
    {
        $product = fixer::input('post')
            ->join('categories', ',')
            ->setDefault('price', 0)
            ->setDefault('amount', 0)
            ->setDefault('promotion', 0)
            ->add('editor', $this->app->user->account)
            ->add('editedDate', helper::now())
            ->get();

        $product->alias    = seo::processAlias($product->alias);
        $product->keywords = seo::processTags($product->keywords);

        $this->dao->update(TABLE_PRODUCT)
            ->data($product, $skip = 'categories')
            ->autoCheck()
            ->batchCheck($this->config->product->edit->requiredFields, 'notempty')
            ->where('id')->eq($productID)
            ->exec();

        $this->loadModel('tag')->save($product->keywords);
        if(!dao::isError()) $this->processCategories($productID, $this->post->categories);

        if(!dao::isError()) return true;
        return false;
    }
        
    /**
     * Delete a product.
     * 
     * @param  int      $productID 
     * @access public
     * @return void
     */
    public function delete($productID, $null = null)
    {
        $product = $this->getByID($productID);
        if(!$product) return false;

        $this->dao->delete()->from(TABLE_RELATION)->where('id')->eq($productID)->andWhere('type')->eq('product')->exec();
        $this->dao->delete()->from(TABLE_PRODUCT)->where('id')->eq($productID)->exec();

        return !dao::isError();
    }

    /**
     * Process categories for a product.
     * 
     * @param  int    $productID 
     * @param  array  $categories 
     * @access public
     * @return void
     */
    public function processCategories($productID, $categories = array())
    {
       if(!$productID) return false;
       $type = 'product'; 

       /* First delete all the records of current product from the releation table.  */
       $this->dao->delete()->from(TABLE_RELATION)
           ->where('type')->eq($type)
           ->andWhere('id')->eq($productID)
           ->autoCheck()
           ->exec();

       /* Then insert the new data. */
       foreach($categories as $category)
       {
           if(!$category) continue;

           $data = new stdclass();
           $data->type     = $type; 
           $data->id       = $productID;
           $data->category = $category;

           $this->dao->insert(TABLE_RELATION)->data($data)->exec();
       }
    }

    /**
     * Print files.
     * 
     * @param  object $files 
     * @access public
     * @return void
     */
    public function printFiles($files)
    {
        if(empty($files)) return false;

        foreach($files as $file)
        {
            if(!$file->isImage)
            {
                $file->title = $file->title . ".$file->extension";
                echo html::a(helper::createLink('file', 'download', "fileID=$file->id&mouse=left"), $file->title, '_blank') . '&nbsp;&nbsp;&nbsp'; 
            }
        }
    }
}