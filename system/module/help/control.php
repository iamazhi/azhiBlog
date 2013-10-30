<?php
/**
 * The control file of help category of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     help
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class help extends control
{
    public function index()
    {
        $book = $this->help->getFirstBook();
        if($book) $this->locate(inlink('book', "type=$book->key"));
        $this->locate($this->createLink('index'));
    }

    /**
     * Browse books in admin.
     * 
     * @access public
     * @return void
     */
    public function admin()
    {
        $this->view->books = $this->help->getBookList();
        $this->view->title = $this->lang->help->common;
        $this->display();
    }

    /**
     * Browse the categories and print manage links.
     * 
     * @param  string $type 
     * @access public
     * @return void
     */
    public function category($type)
    {
        $this->lang->help->menu = $this->help->createModuleMenu();

        $this->lang->category         = $this->lang->directory;
        $this->lang->tree->menu       = $this->lang->help->menu;
        $this->lang->menuGroups->tree = 'help';

        $this->view->categoryBox = $this->help->getCategoryBox($type);
        $this->view->title    = $this->lang->category->common;
        $this->view->type     = $type;
        $this->view->root     = $root;
        $this->view->children = $this->loadModel('tree')->getChildren(0, $type);

        $this->display();
    }

    /**
     * Create a book.
     *
     * @access public 
     * @return void
     */
    public function createBook()
    {
        if($_POST)
        {
            $result = $this->help->createBook();
            if($result === true) $this->send(array('result' => 'success', 'message'=>$this->lang->saveSuccess, 'locate' => $this->inlink('admin')));
            $this->send(array('result' => 'fail', 'message' => $result));
        }
        $this->display(); 
    }

    /**
     * Edit a book.
     *
     * @param int $id
     * @access public
     * @return void
     */
    public function editBook($id)
    {
        if($_POST)
        {
            $result = $this->help->updateBook($id);
            if($result === true) $this->send(array('result' => 'success', 'message'=>$this->lang->saveSuccess, 'locate' => $this->inlink('admin')));
            $this->send(array('result' => 'fail', 'message' => $result));
        }

        $this->view->id   = $id;
        $this->view->book = $this->help->getBookByID($id);
        $this->display();
    }

    /**
     * Read a book.
     * 
     * @param  string $code 
     * @param  int    $categoryID 
     * @access public
     * @return void
     */
    public function book($code, $categoryID = 0)
    {
        $book = $this->loadModel('setting')->getItem("owner=system&module=common&section=book&key=$code");
        $book = json_decode($book);

        if(!is_numeric($categoryID))
        {
            $category   = $this->loadModel('tree')->getByID($categoryID);
            $categoryID = $category->id;
        }

        $bookCategory       = $this->loadModel('tree')->getById($categoryID);
        $bookCategory->book = $book->name;
        $bookCategory->code = $code;

        $this->view->title = $book->name;
        if($bookCategory)
        {
            $this->view->keywords = trim($bookCategory->keyword . ' ' . $this->config->site->keywords);
            if($bookCategory->desc) $this->view->desc = trim(preg_replace('/<[a-z\/]+.*>/Ui', '', $bookCategory->desc));
        }
        $this->view->books      = $this->help->getBookList();
        $this->view->book       = $book;
        $this->view->code       = $code;
        $this->view->category   = $bookCategory;
        $this->display();
    }

    /**
     * Read an article.
     * 
     * @param  int    $articleID 
     * @access public
     * @return void
     */
    public function read($articleID)
    { 
        $article  = $this->loadModel('article')->getByID($articleID);
        
        /* fetch first category for display. */
        $category = array_slice($article->categories, 0, 1);
        $category = $category[0];
        $category = $this->loadModel('tree')->getById($category->id);

        $type = str_replace('book_', '', $this->dao->findById($category->id)->from(TABLE_CATEGORY)->fetch('type'));
        $book = $this->loadModel('setting')->getItem("owner=system&module=common&section=book&key=$type");
        $book = json_decode($book);
        
        $category->book = $book->name;
        $category->code = $type;

        $this->createContentNav($article->content);

        $this->view->title    = $article->title;
        $this->view->keywords = trim($article->keywords . ' ' . $category->keyword . ' ' . $this->config->site->keywords);
        $this->view->desc     = trim($article->summary . ' ' . preg_replace('/<[a-z\/]+.*>/Ui', '', $category->desc));

        $this->view->type        = $type;
        $this->view->article     = $article;
        $this->view->links       = $this->article->getPairs($category->id, 't1.order');
        $this->view->prevAndNext = $this->loadModel('article')->getPrevAndNext($this->view->links, $article->id);
        //$this->view->layouts   = $this->loadModel('block')->getLayouts('help.read');
        $this->view->category    = $category;

        $this->dao->update(TABLE_ARTICLE)->set('views = views + 1')->where('id')->eq($articleID)->exec(false);

        $this->display();
    }

    /**
     * Delete a book.
     *
     * @param int $id
     * @retturn void
     */
    public function deleteBook($id)
    {
        if($this->help->deleteBook($id)) $this->send(array('result' => 'success'));
        $this->send(array('result' => 'fail', 'message' => dao::getError()));
    }


    /**
     * Create content navigation according the content. 
     * 
     * @param  int    $content 
     * @access public
     * @return string;
     */
    public function createContentNav($content)
    {
        $nav = "<div id='contentNav'>";
        $content = str_replace('<h3', '<h4', $content);
        $content = str_replace('h3>', 'h4>', $content);
        preg_match_all('|<h4.*>(.*)</h4>|isU', $content, $result);
        if(count($result[0]) >= 2)
        {
            foreach($result[0] as $id => $item)
            {
                $nav .= "<div><a href='#$id'>" . strip_tags($item) . "</a></div>";
                $replace = str_replace('<h4', "<h4 id=$id", $item);
                $content = str_replace($item, $replace, $content);
            }
            $nav .= "</div>";
            $content = $nav . $content;
        }
    }
}
