<?php
/**
 * The model file of tag module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Xiying Gusn <guanxiying@xirangit.com>
 * @package     tag
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class tagModel extends model
{
    /**
     * Get tag list.
     * 
     * @param  int    $tags 
     * @param  int    $pager 
     * @access public
     * @return void
     */
    public function getList($tags, $pager)
    {
        return $this->dao->select('*')->from(TABLE_TAG)
        ->beginIf(!empty($tags))->where('tag')->in($tags)->fi()
        ->page($pager)->fetchAll('id');
    }
    
    /**
     * Get option menu list for select.
     * 
     * @access public
     * @return void
     */
    public function getOptionMenu()
    {
        return $this->dao->select('tag')->from(TABLE_TAG)->fetchPairs('tag', 'tag');
    }
    
    /**
     * Save tags.
     * 
     * @param  string    $tags 
     * @access public
     * @return void
     */
    public function save($tags)
    {
        $tags =  array_unique(explode(',', $tags));

        foreach($tags as $tag)
        {
            if(trim($tag) == '') continue;
            $rank  = $this->countRank($tag);
            $count = $this->dao->select('count(*) as count')->from(TABLE_TAG)->where('tag')->eq($tag)->fetch('count');

            if($count == 0)
            {
                $this->dao->insert(TABLE_TAG)->data(array('tag' => $tag, 'rank' => $rank))->exec();
            }
            else
            {
                $this->dao->update(TABLE_TAG)->set('rank')->eq($rank)->where('tag')->eq($tag)->exec();
            }
        }

        if(!dao::isError()) return true;
        return dao::geterror();
    }

    /**
     * Count rank of one tag.
     * 
     * @param  string    $tag 
     * @access public
     * @return int
     */
    public function countRank($tag)
    {
        $rank = $this->dao->select('count(*) as count')->from(TABLE_ARTICLE)->where("concat(',', keywords, ',')")->like("%,{$tag},%")->fetch('count');
        $rank += $this->dao->select('count(*) as count')->from(TABLE_PRODUCT)->where("concat(',', keywords, ',')")->like("%,{$tag},%")->fetch('count');
        $rank += $this->dao->select('count(*) as count')->from(TABLE_CATEGORY)->where("concat(',', keywords, ',')")->like("%,{$tag},%")->fetch('count');
        return $rank;
    }
}
