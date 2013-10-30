<?php
/**
 * The common simplified chinese file of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青島息壤網絡信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
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
$lang->chanzhiEPS = '蟬知企業門戶系統';
$lang->poweredBy  = " 由 <a href='http://www.chanzhi.org/?v=%s' target='_blank'>{$lang->chanzhiEPS} %s</a> 強力驅動！";

$lang->killIE6    = '<script src="//letskillie6.googlecode.com/svn/trunk/2/zh_CN.js"></script>';

/* Global lang items. */
$lang->home           = '首頁';
$lang->welcome        = '歡迎您，<strong>%s</strong>！';
$lang->todayIs        = '今天是%s，';
$lang->aboutUs        = '關於我們';
$lang->frontHome      = '前台';
$lang->forumHome      = '論壇';
$lang->helpHome       = '幫助';
$lang->dashboard      = '用戶中心';
$lang->register       = '註冊';
$lang->logout         = '退出';
$lang->login          = '登錄';
$lang->account        = '帳號';
$lang->password       = '密碼';
$lang->changePassword = '修改密碼';
$lang->forgotPassword = '忘記密碼?';
$lang->currentPos     = '當前位置';
$lang->categoryMenu   = '分類導航';

/* Global action items. */
$lang->reset          = '重填';
$lang->edit           = '編輯';
$lang->copy           = '複製';
$lang->hide           = '隱藏';
$lang->delete         = '刪除';
$lang->close          = '關閉';
$lang->save           = '保存';
$lang->confirm        = '確認';
$lang->preview        = '預覽';
$lang->goback         = '返回';
$lang->search         = '搜索';
$lang->more           = '更多';
$lang->actions        = '操作';
$lang->feature        = '未來';
$lang->year           = '年';
$lang->loading        = '稍候...';
$lang->saveSuccess    = '保存成功';
$lang->setSuccess     = '設置成功';
$lang->fail           = '失敗';
$lang->noResultsMatch = '沒有匹配的選項';

/* Items for javascript. */
$lang->js = new stdclass();
$lang->js->confirmDelete = '您確定要執行刪除操作嗎？';
$lang->js->deleteing     = '刪除中';
$lang->js->doing         = '處理中';
$lang->js->timeout       = '網絡超時,請重試';

/* Contact fields*/
$lang->company = new stdclass();
$lang->company->contactUs = '聯繫我們';
$lang->company->address   = '地址';
$lang->company->phone     = '電話';
$lang->company->email     = 'Email';
$lang->company->fax       = '傳真';
$lang->company->qq        = 'QQ';
$lang->company->weibo     = '微博';
$lang->company->weixin    = '微信';
$lang->company->wangwang  = '旺旺';

/* The main menus. */
$lang->menu = new stdclass();
$lang->menu->admin   = '首頁|admin|index|';
$lang->menu->article = '文章|article|admin|';
$lang->menu->blog    = '博客|article|admin|type=blog';
$lang->menu->product = '產品|product|admin|';
$lang->menu->help    = '幫助|help|admin|';
$lang->menu->comment = '評論|comment|admin|';
$lang->menu->forum   = '論壇|forum|admin|';
$lang->menu->site    = '站點|site|setbasic|';
$lang->menu->company = '公司|company|setbasic|';
$lang->menu->user    = '會員|user|admin|';

/* Menu of article module. */
$lang->article = new stdclass();
$lang->article->menu = new stdclass();
$lang->article->menu->browse = array('link' => '文章列表|article|admin|', 'alias' => 'edit');
$lang->article->menu->create = '發佈文章|article|create|type=article';
$lang->article->menu->tree   = '類目管理|tree|browse|type=article';

/* Menu of blog module. */
$lang->blog = new stdclass();
$lang->blog->menu = new stdclass();
$lang->blog->menu->browse = array('link' => '博客列表|article|admin|type=blog', 'alias' => 'edit');
$lang->blog->menu->create = '發佈博客|article|create|type=blog';
$lang->blog->menu->tree   = '類目管理|tree|browse|type=blog';

/* Menu of product module. */
$lang->product = new stdclass();
$lang->product->menu = new stdclass();
$lang->product->menu->browse = array('link' => '產品列表|product|admin|', 'alias' => 'edit');
$lang->product->menu->create = '發佈產品|product|create|';
$lang->product->menu->tree   = '類目管理|tree|browse|type=product';

/* Menu of comment module. */
$lang->comment = new stdclass();
$lang->comment->menu = new stdclass();
$lang->comment->menu->unchecked = '未審核|comment|admin|status=0';
$lang->comment->menu->checked   = '已審核|comment|admin|status=1';

/* Menu of forum module. */
$lang->forum = new stdclass();
$lang->forum->menu = new stdclass();
$lang->forum->menu->browse = '主題列表|forum|admin|';
$lang->forum->menu->tree   = '版塊管理|tree|browse|type=forum';

/* Menu of site module. */
$lang->site = new stdclass();
$lang->site->menu = new stdclass();
$lang->site->menu->basic     = '站點設置|site|setbasic|';
$lang->site->menu->logo      = 'LOGO設置|site|setlogo|';
$lang->site->menu->nav       = '導航設置|nav|admin|';
$lang->site->menu->theme     = '主題風格|site|settheme|';
$lang->site->menu->slide     = array('link' => '幻燈片設置|slide|admin|', 'alias' => 'create,edit');

/* Menu of company module. */
$lang->company->menu = new stdclass();
$lang->company->menu->basic   = '公司信息|company|setbasic|';
$lang->company->menu->contact = '聯繫方式|company|setcontact|';

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

/* The error messages. */
$lang->error = new stdclass();
$lang->error->length       = array('<strong>%s</strong>長度錯誤，應當為<strong>%s</strong>', '<strong>%s</strong>長度應當不超過<strong>%s</strong>，且不小於<strong>%s</strong>。');
$lang->error->reg          = '<strong>%s</strong>不符合格式，應當為:<strong>%s</strong>。';
$lang->error->unique       = '<strong>%s</strong>已經有<strong>%s</strong>這條記錄了。';
$lang->error->notempty     = '<strong>%s</strong>不能為空。';
$lang->error->equal        = '<strong>%s</strong>必須為<strong>%s</strong>。';
$lang->error->int          = array('<strong>%s</strong>應當是數字。', '<strong>%s</strong>最小值為%s',  '<strong>%s</strong>應當介於<strong>%s-%s</strong>之間。');
$lang->error->float        = '<strong>%s</strong>應當是數字，可以是小數。';
$lang->error->email        = '<strong>%s</strong>應當為合法的EMAIL。';
$lang->error->date         = '<strong>%s</strong>應當為合法的日期。';
$lang->error->account      = '<strong>%s</strong>應當為字母和數字的組合，至少三位';
$lang->error->passwordsame = '兩次密碼應當相等。';
$lang->error->passwordrule = '密碼應該符合規則，長度至少為六位。';
$lang->error->captcha      = '請輸入正確的驗證碼。';

/* The pager items. */
$lang->pager = new stdclass();
$lang->pager->noRecord  = '暫時沒有記錄。';
$lang->pager->digest    = '共 <strong>%s</strong> 條記錄，每頁 <strong>%s</strong> 條，頁面：<strong>%s/%s</strong> ';
$lang->pager->first     = '首頁';
$lang->pager->pre       = '上頁';
$lang->pager->next      = '下頁';
$lang->pager->last      = '末頁';
$lang->pager->locate    = 'Go!';

/* The datetime settings. */
define('DT_DATETIME1',  'Y-m-d H:i:s');
define('DT_DATETIME2',  'y-m-d H:i');
define('DT_MONTHTIME1', 'n/d H:i');
define('DT_MONTHTIME2', 'n月d日 H:i');
define('DT_DATE1',     'Y年m月d日');
define('DT_DATE2',     'Ymd');
define('DT_DATE3',     'Y年m月d日');
define('DT_DATE4',     'Y-m-d');
define('DT_TIME1',     'H:i:s');
define('DT_TIME2',     'H:i');
