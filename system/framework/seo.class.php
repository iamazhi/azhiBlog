<?php
/**
 * The seo and uri class file. 
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @link        http://www.chanzhi.org
 */
?>
<?php
/**
 * The seo class, parse seo mode uri to normal mode uri.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class seo
{
    /**
     * Parse SEO URI for setRouteByPathInfo.
     *
     * @param uri
     * return string
     */
    public static function parseURI($uri)
    {
        global $config;
        if(!helper::inSeoMode()) return $uri;

        $categoryAlias = $config->seo->alias->category;
        $pageAlias     = $config->seo->alias->page;
        $methodAlias   = $config->seo->alias->method;
        $params = array();

        /* Get module and params from the uri. Like article/2@alias.html, we fetch article/2.  */
        if(strpos($uri, '_') !== false) $uri = substr($uri, 0, strpos($uri, '_'));

        /* Is there a pageID variable in the url?  */
        $pageID = 0;
        if(preg_match('/\/p\d+$/', $uri, $matches))
        {
            $pageID = str_replace('/p', '', $matches[0]);    // Get pageID thus the flowing logic can use it.
            $uri    = str_replace($matches[0], '', $uri);    // Remove the pageID part from the url.
        }

        /* Split uri to items and try to get module and params from it. */
        $items  = explode('/', $uri);
        $module = $items[0];

        /* There's no '/' in uri. */
        if(strpos($uri, '/') === false)
        {
            /* Not an alias, return directly. */
            if(!isset($categoryAlias[$uri]) && !isset($pageAlias[$uri])) return $uri;

            /* The module is an alias of a page. */
            if(isset($pageAlias[$uri]) && $module == 'page')
            {
                $module       = $pageAlias[$uri]->module;
                $params['id'] = $pageAlias[$uri]->id;
                return seo::convertURI($module, 'view' , $params, $pageID);
            }

            /* The module is an alias of a category. */
            $module = $categoryAlias[$uri]->module;
            $params['category'] = $categoryAlias[$uri]->category;
            return seo::convertURI($module, 'browse', $params, $pageID);
        }

        /* Is the module an alias of a category? */
        if(isset($categoryAlias[$module]))
        {
            $category = $categoryAlias[$module]->category;      // Get the category.
            $module   = $categoryAlias[$module]->module;    // Get the module of the alias category.

            /* If the first param is number, like article/123.html, should call view method. */
            if(is_numeric($items[1])) 
            {
                $params['id'] = $items[1];
                return seo::convertURI($module, 'view', $params, $pageID);
            }

            $params['category'] = $category;
            return seo::convertURI($module, 'browse', $params, $pageID);
        }

        //------------- The module is an system module-------------- */

        /* Remove the book param from the items if the module is help. */
        if($module == 'help' && count($items) > 2)
        {
            $book     = $items[1];
            $uri      = str_replace('/' . $items[1], '', $uri );
            $items[1] = $items[2];
        }

        /*  If the first param is a category id, like news/c123.html. */
        if(preg_match('/^c\d+$/', $items[1]))
        {
            $params['category'] = str_replace('c', '', $items[1]);
            $method = $methodAlias[$module]['browse'];
            if($module == 'help' && $book) $method .= '-' . $book;
            return seo::convertURI($module, $method, $params, $pageID);
        }

        /* The first param is an object id. */
        if(is_numeric($items[1]))
        {
            $params['id'] = $items[1];
            $method = $methodAlias[$module]['view'];
            return seo::convertURI($module, $method, $params, $pageID);
        }

        /* The first param is a category alias. */
        $params['category'] = $items[1]; 
        $method = $methodAlias[$module]['browse'];

        /* Add -bookName to help->book method. */
        if($module == 'help' && $book) $method .= '-' . $book;
        return seo::convertURI($module, $method, $params, $pageID);
    }

    /**
     * Convert seo mode URI to normal mode.
     * 
     * @param string $module
     * @param string $method
     * @param string $params
     * @param int $pageID
     * return string
     */
    function convertURI($module, $method, $param = array(), $pageID = 0)
    {
        $uri = "$module-$method";
        foreach($param as $value) $uri .= "-$value";
        if($pageID > 0) $uri .= "-$pageID";
        return $uri;
    }
    

    /**
     * Unify string to standard space char.
     * 
     * @param  string    $string 
     * @param  string    $to 
     * @access public
     * @return string
     */
    public function unify($string, $to)
    {
       $string = str_replace(array('_', '、', ' ', '-', '?', '@', '&', '%', '~', '`', '+', '*', '/', '\\', '，', '.', '。'), $to, $string);
       return preg_replace('/[,]+/', $to, $string);
    }
}

/**
 * The uri class, create seo mode uri for seo modules.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 *
 * @author      Dtt
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class uri
{
    /**
     * Create article browse
     *
     * @params array    $params
     * @params array    $alias  
     * return string
     */
    public static function createArticleBrowse($params, $alias)
    {
        global $config;
        $link = 'article/c' . array_shift($params);
        if($alias['category'] != '') $link = $alias['category'];
        return $config->webRoot . $link . '.' . $config->default->view;
    }

    /**
     * Create article view
     *
     * @params array    $params
     * @params array    $alias  
     * return string
     */
    public static function createArticleView($params, $alias)
    {
        global $config;
        $link = 'article/';
        if($alias['category']) $link = $alias['category'] . $config->webRoot;
        $link .= array_shift($params);
        if($alias['name']) $link .= '_' . $alias['name'];
        return $config->webRoot . $link . '.' . $config->default->view;
    }

    /**
     * Create article view
     *
     * @params array    $params
     * @params array    $alias  
     * return string
     */

    public static function createProductBrowse($params, $alias)
    {
        global $config;
        $link = 'product/c' . array_shift($params);
        if($alias['category']) $link = $alias['category'];
        return $config->webRoot . $link . '.' . $config->default->view;
    }

    /**
     * Create product view
     *
     * @params array    $params
     * @params array    $alias  
     * return string
     */
    public static function createProductView($params, $alias)
    {
        global $config;
        $link = 'product/';
        if($alias['category']) $link = $alias['category'] . $config->webRoot;
        $link .= array_shift($params);
        if($alias['name']) $link .= '_' . $alias['name'];
        return $config->webRoot . $link . '.' . $config->default->view;
    }

    /**
     * Create forum board.
     *
     * @params array    $params
     * @params array    $alias  
     * return string
     */
    public static function createForumBoard($params, $alias)
    {
        global $config;
        $link = 'forum/';
        if($alias['category'])
        {
            $link .= $alias['category'];
        }
        else
        {
            $link .= 'c' . array_shift($params);
        }
        return $config->webRoot . $link . '.' . $config->default->view;
    }

    /**
     * Create thread view.
     *
     * @params array    $params
     * @params array    $alias  
     * return string
     */
    public static function createThreadView($params, $alias)
    {
        global $config;
        return $link = '/thread/' . array_shift($params) . '.' . $config->default->view;
    }

    /**
     * Create blog index.
     *
     * @params array    $params
     * @params array    $alias  
     * return string
     */
    public static function createBlogIndex($params, $alias)
    {
        global $config;
        $link = 'blog/';
        if($alias['category'])
        {
            $link .= $alias['category'];
        }
        else
        {
            if(empty($params)) 
            {
                $link .= 'c0';
            }
            else
            {
                $link .= 'c' . array_shift($params);
            }
        }
        return $config->webRoot . $link . '.' . $config->default->view;
    }

    /**
     * Create blog view.
     *
     * @params array    $params
     * @params array    $alias  
     * return string
     */
    public static function createBlogView($params, $alias)
    {
        global $config;
        $link = 'blog/' . array_shift($params);
        if($alias['name']) $link .= '_' . $alias['name'];
        return $config->webRoot . $link . '.' . $config->default->view;
    }

    /**
     * Create help book.
     *
     * @params array    $params
     * @params array    $alias  
     * return string
     */
    public static function createHelpBook($params, $alias)
    {
        global $config;
        $link = 'help/' . array_shift($params);
        if($alias['category'])
        {
            $link .= $config->webRoot . $alias['category'];
        }
        else
        {
            if(count($params) > 0)
            {
                $category = array_shift($params);
                if(is_numeric($category)) $category = 'c' . $category;
                $link .= $config->webRoot . $category;
            }
        }
        return $config->webRoot . $link . '.' . $config->default->view;
    }

    /**
     * Create help read.
     *
     * @params array    $params
     * @params array    $alias  
     * return string
     */
    public static function createHelpRead($params, $alias)
    {
        global $config;

        $id   = array_shift($params);
        $book = array_shift($params);

        $link = 'help/'  . $book . '/' . $id;
        if($alias['name']) $link .= '_' . $alias['name'];
        return $config->webRoot . $link . '.' . $config->default->view;
    }
}
