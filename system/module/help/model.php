<?php
/**
 * The model file of help category of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     help
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class helpModel extends model
{
    /**
     * getOrderId 
     * 
     * @param  string    $book 
     * @param  string    $categoryID 
     * @param  id        $parentID 
     * @access public
     * @return void
     * @todo rewrite the logic.
     */
    public function getOrderId($code, $categoryID, $parentID = '')
    {
        $allCategories = $this->dao->select('*')->from(TABLE_CATEGORY)
            ->where('type')->eq('book_' . $code)
            ->beginIF($parentID !='')->andWhere('parent')->eq($parentID)->fi()
            ->orderBy('grade, `order`')->fetchAll('id');
        $order = 1;
        foreach($allCategories as $thisCategory)
        {
            if($categoryID == $thisCategory->id)break;
            $order++;
        }
        return $order;
    }

    public function getCategoryBox($type)
    {
        $book = $this->getBookByCode(str_replace('book_', '', $type));
        $treeMenu    = $this->loadModel('tree')->getTreeMenu($type, 0, array('treeModel', 'createBookLink'));
        $backButton  =  html::a(helper::createLink('help', 'admin', "type={$type}"), $this->lang->help->backtobooks, '', "class='btn btn-default btn-sm'");

        $categoryBox = <<<Eof
            <div class='col-md-2'>
              <table class='table'>
                <caption>
                  {$book->name}
                </caption>
               <tr>
                 <td><div id='treeMenuBox'>{$treeMenu} {$backButton}</div></td>
               </tr>
             </table>
           </div>
Eof;
        return $categoryBox;
    }

    /**
     * Create a book.
     *
     * @access public
     * @return bool
     */
    public function createBook()
    {
        $book = fixer::input('post')->get();

        $setting = new stdclass();
        $setting->owner   = 'system';
        $setting->module  = 'common';
        $setting->section = 'book';
        $setting->key     = $book->code;
        unset($book->code);
        $setting->value   = helper::jsonEncode($book);
        
        $books = $this->dao->select('*')->from(TABLE_CONFIG)
            ->where('owner')->eq('system')
            ->andWhere('module')->eq('common')
            ->andWhere('section')->eq('book')
            ->andWhere('`key`')->eq($setting->key)
            ->fetchAll();

        $errors = array();

        if(count($books) > 1)
        {
            $errors['code'] = $this->lang->help->codeunique;
        }
        elseif(count($books) == 1)
        {
            $errors['code'] = $this->lang->help->codeunique;
        }
        
        if(!ctype_alnum($setting->key)) $errors['code'] = $this->lang->help->codealnum;

        if(!$book->name) $errors['name'] = $this->lang->help->namenotempty;
        if(!$setting->key) $errors['code'] = $this->lang->help->codenotempty;

        if(!empty($errors)) return $errors;

        $this->dao->insert(TABLE_CONFIG)->data($setting)->exec();

        return !dao::isError();
    }

    /**
     * Get a book by code.
     *
     * @param string $code
     * @access public
     * @return array
     */
    public function getBookByCode($code)
    {
        $book = $this->dao->select('*')->from(TABLE_CONFIG)->where('`key`')->eq($code)->fetch();
        if(!$book) return false;

        $id   = $book->id;
        $key  = $book->key;    
        $book = json_decode($book->value);

        $book->id  = $id;
        $book->key = $key;

        return $book;
    }

    /**
     * Get a book by id.
     *
     * @param int $id
     * @access public
     * @return array
     */
    public function getBookByID($id)
    {
        $book = $this->dao->select('*')->from(TABLE_CONFIG)->where('id')->eq($id)->fetch();
        if(!$book) return false;

        $id   = $book->id;
        $key  = $book->key;    
        $book = json_decode($book->value);

        $book->id  = $id;
        $book->key = $key;

        return $book;
    }

    /**
     * Get the first book.
     * 
     * @access public
     * @return object|bool
     */
    public function getFirstBook()
    {
        $book = $this->dao->select('*')->from(TABLE_CONFIG)
            ->where('owner')->eq('system')
            ->andWhere('module')->eq('common')
            ->andWhere('section')->eq('book')
            ->orderBy('id_desc')
            ->limit(1)
            ->fetch();

        if(!$book) return false;

        $id   = $book->id;
        $key  = $book->key;    
        $book = json_decode($book->value);

        $book->id  = $id;
        $book->key = $key;

        return $book;
    }

    /**
     * Get book list.
     *
     * @access public
     * @return array
     */
    public function getBookList($pager = null)
    {
        $books = $this->dao->select('*')->from(TABLE_CONFIG)
            ->where('owner')->eq('system')
            ->andWhere('module')->eq('common')
            ->andWhere('section')->eq('book')
            ->orderBy('id_desc')
            ->page($pager)
            ->fetchAll('id');

        foreach($books as $bookID => $book)
        {
            $id  = $book->id;
            $key = $book->key;
            $books[$bookID]      = json_decode($book->value);
            $books[$bookID]->key = $key;
            $books[$bookID]->id  = $id; 
        }

        return $books;
    }

    /**
     * Update a book.
     *
     * @param int $id
     * @access public
     * @return bool
     */
    public function updateBook($id)
    {
        $book = fixer::input('post')->get();
        $setting->key  = $book->code;
        unset($book->code);
        $setting->value = helper::jsonEncode($book);
        
        $books = $this->dao->select('*')->from(TABLE_CONFIG)
            ->where('owner')->eq('system')
            ->andWhere('module')->eq('common')
            ->andWhere('section')->eq('book')
            ->andWhere('`key`')->eq($setting->key)
            ->fetchAll();

        $errors = array();

        if(count($books) > 1)
        {
            $errors['code'] = $this->lang->help->codeunique;
        }
        elseif(count($books) == 1 && $books[0]->id != $id)
        {
            $errors['code'] = $this->lang->help->codeunique;
        }

        if(!ctype_alnum($setting->key)) $errors['code'] = $this->lang->help->codealnum;

        if(!$book->name) $errors['name'] = $this->lang->help->namenotempty;
        if(!$setting->key) $errors['code'] = $this->lang->help->codenotempty;
        
        if(!empty($errors)) return $errors;

        $this->dao->update(TABLE_CONFIG)->data($setting)->where('id')->eq($id)->exec();

        return !dao::isError();
    }

    /**
     * Delete a book.
     *
     * @param int $id
     * @return bool
     */
    public function deleteBook($id)
    {
        $book = $this->getBookByID($id);
        if(!$book) return false;
        
        $this->dao->delete()->from(TABLE_CONFIG)->where('id')->eq($id)->exec();
        $this->dao->delete()->from(TABLE_CATEGORY)->where('type')->eq($book->key)->exec();
        $this->dao->delete()->from(TABLE_RELATION)->where('type')->eq($book->key)->exec();

        return !dao::isError();
    }
}
