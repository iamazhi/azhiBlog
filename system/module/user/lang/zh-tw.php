<?php
/**
 * The user module zh-tw file of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青島息壤網絡信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     user
 * @version     $Id: zh-tw.php 824 2010-05-02 15:32:06Z wwccss $
 * @link        http://www.chanzhi.org
 */
$lang->user->common    = '用戶';

$lang->user->id        = '編號';
$lang->user->account   = '用戶名';
$lang->user->password  = '密碼';
$lang->user->password2 = '請重複密碼';
$lang->user->realname  = '真實姓名';
$lang->user->nickname  = '暱稱';
$lang->user->avatar    = '頭像';
$lang->user->birthyear = '出生年';
$lang->user->birthday  = '出生月日';
$lang->user->gendar    = '性別';
$lang->user->email     = '郵箱';
$lang->user->msn       = 'MSN';
$lang->user->qq        = 'QQ';
$lang->user->yahoo     = '雅虎通';
$lang->user->gtalk     = 'Gtalk';
$lang->user->wangwang  = '旺旺';
$lang->user->mobile    = '手機';
$lang->user->phone     = '電話';
$lang->user->company   = '公司/組織';
$lang->user->address   = '通訊地址';
$lang->user->zipcode   = '郵編';
$lang->user->join      = '加入日期';
$lang->user->visits    = '訪問次數';
$lang->user->ip        = '最後IP';
$lang->user->last      = '最後登錄時間';
$lang->user->allowTime = '開放時間';
$lang->user->status    = '狀態';
$lang->user->alert     = '您的帳號已被禁用';

$lang->user->list            = '會員列表';
$lang->user->view            = "用戶詳情";
$lang->user->create          = "添加用戶";
$lang->user->edit            = "編輯用戶";
$lang->user->changePassword  = "更改密碼";
$lang->user->newPassword     = "新密碼";
$lang->user->update          = "編輯用戶";
$lang->user->delete          = "刪除用戶";
$lang->user->browse          = "瀏覽用戶";
$lang->user->deny            = "訪問受限";
$lang->user->confirmDelete   = "您確認刪除該用戶嗎？";
$lang->user->confirmActivate = "您確認激活該用戶嗎？";
$lang->user->relogin         = "重新登錄";
$lang->user->asGuest         = "遊客訪問";
$lang->user->goback          = "返回前一頁";
$lang->user->allUsers        = '全部用戶';
$lang->user->submit          = "提交";
$lang->user->forbid          = '禁用';

$lang->user->profile     = '個人信息';
$lang->user->editProfile = '編輯信息';
$lang->user->thread      = '我的主題';
$lang->user->reply       = '我的回貼';
$lang->user->message     = '我的消息';

$lang->user->inputUserName       = '請輸入用戶名';
$lang->user->inputAccountOrEmail = '請輸入用戶名或Email';
$lang->user->inputPassword       = '請輸入密碼';
$lang->user->searchUser          = '搜索';

$lang->user->errorDeny     = "抱歉，您無權訪問『<b>%s</b>』模組的『<b>%s</b>』功能。請聯繫管理員獲取權限。點擊後退返回上頁。";
$lang->user->loginFailed   = "登錄失敗，請檢查您的用戶名或密碼是否填寫正確。";
$lang->user->lblRegistered = '恭喜您，已經成功註冊。';
$lang->user->forbidSuccess = '禁用成功';
$lang->user->forbidFail    = '禁用失敗';

$lang->user->forbidUser          = '禁用管理';
$lang->user->forbidDate = array();
$lang->user->forbidDate['1']     = '一天';
$lang->user->forbidDate['2']     = '兩天';
$lang->user->forbidDate['3']     = '三天';
$lang->user->forbidDate['7']     = '一周';
$lang->user->forbidDate['30']    = '一個月';
$lang->user->forbidDate['10000'] = '永久';
$lang->user->operate             = '操作';

$lang->user->gendarList = new stdclass();
$lang->user->gendarList->m = '男';
$lang->user->gendarList->f = '女';
$lang->user->gendarList->u = '';

$lang->user->register  = new stdclass();
$lang->user->register->welcome     = '歡迎註冊成為會員';
$lang->user->register->why         = '歡迎註冊成為我們的會員，您可以享受更多的服務。';
$lang->user->register->lblUserInfo = '用戶信息';
$lang->user->register->lblAccount  = '必須是三位以上的英文字母或數字';
$lang->user->register->lblPassword = '數字和字母組成，六位以上';

$lang->user->notice = new stdclass();
$lang->user->notice->password = '字母和數字組合，最少六位';

$lang->user->login  = new stdclass();
$lang->user->login->common  = "登錄";
$lang->user->login->welcome = '已有帳號';
$lang->user->login->why     = '歡迎登陸，享用會員專屬服務！';

$lang->user->oauth = new stdclass();
$lang->user->oauth->common       = '開放登錄';
$lang->user->oauth->provider     = '服務商';
$lang->user->oauth->clientID     = 'App Key';
$lang->user->oauth->clientSecret = 'App Secret';
$lang->user->oauth->verification = '網站驗證';
$lang->user->oauth->widget       = '網頁組件';

$lang->user->oauth->providers['sina'] = '新浪微博';
$lang->user->oauth->providers['qq']   = 'QQ';

$lang->user->oauth->lblWelcome    = '開放登錄，快捷方便';
$lang->user->oauth->lblProfile    = "<h3>設置用戶名，完成註冊</h3>";
$lang->user->oauth->lblBind       = "<h3>或綁定已有帳號</h3>";
$lang->user->oauth->lblBindFailed = "綁定賬戶失敗！";

$lang->user->control = new stdclass();
$lang->user->control->common      = '用戶中心';
$lang->user->control->welcome     = '歡迎您，<strong>%s</strong>';
$lang->user->control->lblPassword = "留空，則保持不變。";

$lang->user->control->menus[10] = '<i class="icon-large icon-user"></i> 個人信息 <i class="icon-chevron-right"></i>|user|profile';
$lang->user->control->menus[20] = '<i class="icon-large icon-edit"></i> 編輯信息 <i class="icon-chevron-right"></i>|user|edit';
$lang->user->control->menus[28] = '<i class="icon-large icon-comments-alt"></i> 我的消息 <i class="icon-chevron-right"></i>|user|message';
$lang->user->control->menus[30] = '<i class="icon-large icon-share"></i> 我的主題 <i class="icon-chevron-right"></i>|user|thread';
$lang->user->control->menus[40] = '<i class="icon-large icon-mail-reply-all"></i> 我的回帖 <i class="icon-chevron-right"></i>|user|reply';
