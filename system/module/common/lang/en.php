<?php
/**
 * The common simplified chinese file of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     chanzhiEPS
 * @version     $Id$
 * @link        http://www.zentao.net
 */
/* common sign setting. */
$lang->colon   = ' : ';
$lang->prev    = '‹';
$lang->next    = '›';
$lang->laquo   = '&laquo;';
$lang->raquo   = '&raquo;';
$lang->minus   = ' - ';
$lang->RMB     = '￥';
$lang->divider = "<span class='divider'>{$lang->raquo}</span> ";

/* Lang items for xirang. */
$lang->chanzhiEPS = 'chanzhiEPS';
$lang->poweredBy = " Powered by <a href='http://www.chanzhi.org/?v=%s' target='_blank'>{$lang->chanzhiEPS} %s</a>!";

$lang->killIE6    = '<script src="//letskillie6.googlecode.com/svn/trunk/2/default.js"></script>';

/* Global lang items. */
$lang->home           = 'Home';
$lang->welcome        = 'Welcome, <strong>%s</strong>!';
$lang->todayIs        = 'Today is %s, ';
$lang->aboutUs        = 'About';
$lang->frontHome      = 'Front';
$lang->forumHome      = 'Forum';
$lang->helpHome       = 'Helo';
$lang->dashboard      = 'Dashboard';
$lang->register       = 'Register';
$lang->logout         = 'Logout';
$lang->login          = 'Login';
$lang->account        = 'Account';
$lang->password       = 'Password';
$lang->changePassword = 'Change password';
$lang->forgotPassword = 'Forgot password?';
$lang->currentPos     = 'Positon';
$lang->categoryMenu   = 'Categories';

/* Global action items. */
$lang->reset          = 'Reset';
$lang->edit           = 'Edit';
$lang->copy           = 'Copy';
$lang->hide           = 'Hide';
$lang->delete         = 'Delete';
$lang->close          = 'Close';
$lang->save           = 'Save';
$lang->confirm        = 'Confirm';
$lang->preview        = 'Preview';
$lang->goback         = 'Back';
$lang->search         = 'Search';
$lang->more           = 'More';
$lang->actions        = 'Actions';
$lang->feature        = 'Feature';
$lang->year           = 'Year';
$lang->loading        = 'Loading...';
$lang->saveSuccess    = 'Successfully saved.';
$lang->setSuccess     = 'Successfully saved.';
$lang->fail           = 'Fail';
$lang->noResultsMatch = 'No matched results.';

/* Items for javascript. */
$lang->js = new stdclass();
$lang->js->confirmDelete = 'Are sure to delete it?';
$lang->js->deleteing     = 'Deleting...';
$lang->js->doing         = 'Processing...';
$lang->js->timeout       = 'Timeout';

/* Contact fields*/
$lang->company = new stdclass();
$lang->company->contactUs = 'Contact';
$lang->company->address   = 'Address';
$lang->company->phone     = 'Phone';
$lang->company->email     = 'Email';
$lang->company->fax       = 'Fax';
$lang->company->qq        = 'QQ';
$lang->company->weibo     = 'Weibo';
$lang->company->weixin    = 'Weichat';
$lang->company->wangwang  = 'Wangwang';

/* The main menus. */
$lang->menu = new stdclass();
$lang->menu->admin   = 'Home|admin|index|';
$lang->menu->article = 'Article|article|admin|';
$lang->menu->blog    = 'Blog|article|admin|type=blog';
$lang->menu->product = 'Product|product|admin|';
$lang->menu->help    = 'Help|help|admin|';
$lang->menu->comment = 'Comment|comment|admin|';
$lang->menu->forum   = 'Forum|forum|admin|';
$lang->menu->site    = 'Site|site|setbasic|';
$lang->menu->company = 'Company|company|setbasic|';
$lang->menu->user    = 'User|user|admin|';

/* Menu of article module. */
$lang->article = new stdclass();
$lang->article->menu = new stdclass();
$lang->article->menu->browse = array('link' => 'List|article|admin|', 'alias' => 'edit');
$lang->article->menu->create = 'Create|article|create|type=article';
$lang->article->menu->tree   = 'Categories|tree|browse|type=article';

/* Menu of blog module. */
$lang->blog = new stdclass();
$lang->blog->menu = new stdclass();
$lang->blog->menu->browse = array('link' => 'List|article|admin|type=blog', 'alias' => 'edit');
$lang->blog->menu->create = 'Create|article|create|type=blog';
$lang->blog->menu->tree   = 'Categories|tree|browse|type=blog';

/* Menu of product module. */
$lang->product = new stdclass();
$lang->product->menu = new stdclass();
$lang->product->menu->browse = array('link' => 'List|product|admin|', 'alias' => 'edit');
$lang->product->menu->create = 'Create|product|create|';
$lang->product->menu->tree   = 'Categories|tree|browse|type=product';

/* Menu of comment module. */
$lang->comment = new stdclass();
$lang->comment->menu = new stdclass();
$lang->comment->menu->unchecked = 'Unreviewed|comment|admin|status=0';
$lang->comment->menu->checked   = 'Reviewed|comment|admin|status=1';

/* Menu of forum module. */
$lang->forum = new stdclass();
$lang->forum->menu = new stdclass();
$lang->forum->menu->browse = 'Threads|forum|admin|';
$lang->forum->menu->tree   = 'Boards|tree|browse|type=forum';

/* Menu of site module. */
$lang->site = new stdclass();
$lang->site->menu = new stdclass();
$lang->site->menu->basic     = 'Basic|site|setbasic|';
$lang->site->menu->logo      = 'Logo|site|setlogo|';
$lang->site->menu->nav       = 'Navigation|nav|admin|';
$lang->site->menu->theme     = 'Theme|site|settheme|';
$lang->site->menu->slide     = array('link' => 'Slide|slide|admin|', 'alias' => 'create,edit');
$lang->site->menu->oauth     = 'Open OAuth|site|setoauth|';

/* Menu of company module. */
$lang->company->menu = new stdclass();
$lang->company->menu->basic   = 'Basic|company|setbasic|';
$lang->company->menu->contact = 'Contact|company|setcontact|';

/* Menu groups setting. */
$lang->menuGroups = new stdclass();

/* Menu of tree module. */
$lang->tree = new stdclass();
$lang->tree->menu = $lang->article->menu;
$lang->menuGroups->tree = 'article';

/* Menu of nav module. */
$lang->nav = new stdclass();
$lang->nav->menu = $lang->site->menu;
$lang->menuGroups->nav  = 'site';

/* Menu of tree module. */
$lang->slide = new stdclass();
$lang->slide->menu = $lang->site->menu;
$lang->menuGroups->slide = 'site';

/* Error info. */
$lang->error = new stdclass();
$lang->error->length          = array("<strong>%s</strong>length should be<strong>%s</strong>", "<strong>%s</strong>length should between<strong>%s</strong>and <strong>%s</strong>.");
$lang->error->reg             = "<strong>%s</strong>should like<strong>%s</strong>";
$lang->error->unique          = "<strong>%s</strong>has<strong>%s</strong>already. If you are sure this record has been deleted, you can restore it in admin panel, trash page.";
$lang->error->notempty        = "<strong>%s</strong>can not be empty.";
$lang->error->equal           = "<strong>%s</strong>must be<strong>%s</strong>.";
$lang->error->int             = array("<strong>%s</strong>should be interger", "<strong>%s</strong>should between<strong>%s-%s</strong>.");
$lang->error->float           = "<strong>%s</strong>should be a interger or float.";
$lang->error->email           = "<strong>%s</strong>should be email.";
$lang->error->date            = "<strong>%s</strong>should be date";
$lang->error->account         = "<strong>%s</strong>should be a valid account.";
$lang->error->passwordsame    = "Two passwords must be the same";
$lang->error->passwordrule    = "Password should more than six letters.";
$lang->error->captcha         = 'Captcah wrong.';

/* The pager items. */
$lang->pager = new stdclass();
$lang->pager->noRecord  = "No records yet.";
$lang->pager->digest    = "<strong>%s</strong> records, <strong>%s</strong> per page, <strong>%s/%s</strong> ";
$lang->pager->first     = "First";
$lang->pager->pre       = "Previous";
$lang->pager->next      = "Next";
$lang->pager->last      = "Last";
$lang->pager->locate    = "GO!";

/* Date times. */
define('DT_DATETIME1',  'Y-m-d H:i:s');
define('DT_DATETIME2',  'y-m-d H:i');
define('DT_MONTHTIME1', 'n/d H:i');
define('DT_MONTHTIME2', 'F j, H:i');
define('DT_DATE1',     'Y-m-d');
define('DT_DATE2',     'Ymd');
define('DT_DATE3',     'F j, Y ');
define('DT_DATE4',     'M j');
define('DT_TIME1',     'H:i:s');
define('DT_TIME2',     'H:i');
