<?php
/**
 * The model file of user module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     user
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php
class userModel extends model
{
    /**
     * Get users List.
     *
     * @param object  $pager
     * @param string  $userName
     * @access public
     * @return object 
     */
    public function getList($pager, $userName = '')
    {
        return $this->dao->select('*')->from(TABLE_USER)
            ->beginIF($userName != '')->where('account')->like("%$userName%")->fi()
            ->orderBy('id_asc')
            ->page($pager)
            ->fetchAll();
    }

    /**
     * Get the basic info of some user.
     * 
     * @param mixed $users 
     * @access public
     * @return void
     */
    public function getBasicInfo($users)
    {
        $users = $this->dao->select('account, realname, `join`, last, visits')->from(TABLE_USER)->where('account')->in($users)->fetchAll('account', false);
        if(!$users) return array();

        foreach($users as $account => $user)
        {
            $user->realname  = empty($user->realname) ? $account : $user->realname;
            $user->shortLast = substr($user->last, 5, -3);
            $user->shortJoin = substr($user->join, 5, -3);
        }

        return $users;
    }

    /**
     * Get user by his account.
     * 
     * @param mixed $account   
     * @access public
     * @return object           the user.
     */
    public function getByAccount($account)
    {
        return $this->dao->select('*')->from(TABLE_USER)->where('account')->eq($account)->fetch('', false);
    }

    /**
     * Create a user.
     * 
     * @access public
     * @return void
     */
    public function create()
    {
        $this->checkPassword();

        $user = fixer::input('post')
            ->setDefault('join', date('Y-m-d H:i:s'))
            ->setDefault('last', helper::now())
            ->setDefault('visits', 1)
            ->setIF($this->post->password1 == false, 'password', '')
            ->setIF($this->cookie->r != '', 'referer', $this->cookie->r)
            ->setIF($this->cookie->r == '', 'referer', '')
            ->get();
        $user->password = $this->createPassword($this->post->password1, $user->account, $user->join); 

        $this->dao->insert(TABLE_USER)
            ->data($user, $skip = 'password1,password2')
            ->autoCheck()
            ->batchCheck($this->config->user->register->requiredFields, 'notempty')
            ->check('account', 'unique')
            ->check('account', 'account')
            ->check('email', 'email')
            ->check('email', 'unique')
            ->exec();
    }

    /**
     * Update an account.
     * 
     * @param  string $account 
     * @access public
     * @return void
     */
    public function update($account)
    {
        /* If the user want to change his password. */
        if($this->post->password1 != false)
        {
            $this->checkPassword();
            if(dao::isError()) return false;

            $join = $this->dao->select('`join`')->from(TABLE_USER)->where('account')->eq($account)->fetch('join');
            $password  = $this->createPassword($this->post->password1, $account, $join);
            $this->post->set('password', $password);
        }

        $user = fixer::input('post')
            ->cleanInt('imobile, qq, zipcode')
            ->specialChars('company, address, phone,')
            ->get();

        return $this->dao->update(TABLE_USER)
            ->data($user, $skip = 'password1,password2')
            ->autoCheck()
            ->batchCheck($this->config->user->edit->requiredFields, 'notempty')
            ->check('email', 'email')
            ->check('email', 'unique', "account!='$account'")
            ->checkIF($this->post->gtalk != false, 'gtalk', 'email')
            ->where('account')->eq($account)
            ->exec();
    }

    /**
     * Check the password is valid or not.
     * 
     * @access public
     * @return bool
     */
    public function checkPassword()
    {
        if($this->post->password1 != false)
        {
            if($this->post->password1 != $this->post->password2) dao::$errors['password1'][] = $this->lang->error->passwordsame;
            if(!validater::checkReg($this->post->password1, '|(.){6,}|')) dao::$errors['password1'][] = $this->lang->error->passwordrule;
        }
        else
        {
            dao::$errors['password1'][] = $this->lang->user->inputPassword;
        }
        return !dao::isError();
    }
    
    /**     
     * Update password 
     *          
     * @param  string $account 
     * @access public          
     * @return void
     */     
    public function updatePassword($account)
    { 
        $this->checkPassword();
        if(dao::isError()) return false;

        $join = $this->dao->select('*')->from(TABLE_USER)->where('account')->eq($account)->fetch('join');
        $user = fixer::input('post')
            ->setIF($this->post->password1 != false, 'password', $this->createPassword($this->post->password1, $account, $join))
            ->remove('password1, password2')
            ->get();

        $this->dao->update(TABLE_USER)->data($user)->autoCheck()->where('account')->eq($account)->exec();
    }   

    /**
     * Try to login with an account and password.
     * 
     * @param  string    $account 
     * @param  string    $password 
     * @access public
     * @return bool
     */
    public function login($account, $password)
    {
        $user = $this->identify($account, $password);
        if(!$user) return false;

        $user->rights = $this->authorize($user);
        $this->session->set('user', $user);
        $this->app->user = $this->session->user;

        return true;
    }

    /**
     * Identify a user.
     * 
     * @param   string $account     the account
     * @param   string $password    the password    the plain password or the md5 hash
     * @access  public
     * @return  object              if is valid user, return the user object.
     */
    public function identify($account, $password)
    {
        if(!$account or !$password) return false;

        /* First get the user from database by account or email. */
        $user = $this->dao->select('*')->from(TABLE_USER)
            ->beginIF(validater::checkEmail($account))->where('email')->eq($account)->fi()
            ->beginIF(!validater::checkEmail($account))->where('account')->eq($account)->fi()
            ->fetch();

        /* Then check the password hash. */
        if(!$user) return false;

        /* The password can be the plain or the password after md5. */
        if($this->createPassword($password, $user->account, $user->join) != $user->password and $user->password != $password) return false;

        /* Update user data. */
        $user->ip = $this->server->remote_addr;
        $user->last = helper::now();
        $user->visits ++;
        $this->dao->update(TABLE_USER)->data($user)->where('account')->eq($account)->exec();

        $user->realname  = empty($user->realname) ? $account : $user->realname;
        $user->shortLast = substr($user->last, 5, -3);
        $user->shortJoin = substr($user->join, 5, -3);

        /* Return him.*/
        return $user;
    }

    /**
     * Authorize a user.
     * 
     * @param   object    $user   the user object.
     * @access  public
     * @return  array
     */
    public function authorize($user)
    {
        $rights = $this->config->rights->guest;
        if($user->account == 'guest') return $rights;

        foreach($this->config->rights->member as $moduleName => $moduleMethods)
        {
            foreach($moduleMethods as $method) $rights[$moduleName][$method] = $method;
        }

        return $rights;
    }

    /**
     * Juage a user is logon or not.
     * 
     * @access public
     * @return bool
     */
    public function isLogon()
    {
        return (isset($_SESSION['user']) and !empty($_SESSION['user']) and $_SESSION['user']->account != 'guest');
    }

    /**
     * Forbid the user
     *
     * @param string $date
     * @param int $userID
     * @access public
     * @return void
     */
    public function forbid($userID, $date)
    {
        $intdate = strtotime("+$date day");

        $format = 'Y-m-d H:i:s';

        $date = date($format,$intdate);
        $this->dao->update(TABLE_USER)->set('allowTime')->eq($date)->where('id')->eq($userID)->exec();

        return !dao::isError();
    }

    /**
     * Delete user.
     * 
     * @param  string    $account 
     * @access public
     * @return bool
     */
    public function delete($account)
    {
        $user = $this->getByAccount($account);
        if(!$user) return false;

        $this->dao->delete()->from(TABLE_USER)->where('account')->eq($account)->exec();

        return !dao::isError();
    }

    /**
     * Identify email to regain the forgotten password 
     *
     * @access  public
     * @param   string account
     * @param   string email
     * @return  object              if is valid user, return the user object.
     */
    public function checkEmail($account, $email)
    {
        if(!$account or !$email) return false;

        if(RUN_MODE == 'admin' and strpos($this->config->admin->users, ",$account,") === false) return false;

        $user = $this->dao->select('*')->from(TABLE_USER)
            ->where('account')->eq($account)
            ->andWhere('email')->eq($email)
            ->fetch('', false);
        return $user;
    } 

    /**
     * update the resetKey.
     * 
     * @param  string   $resetKey 
     * @param  time     $resetedTime 
     * @access public
     * @return void
     */
    public function resetKey($account, $resetKey)
    {
        $this->dao->update(TABLE_USER)->set('resetKey')->eq($resetKey)->set('resetedTime')->eq(helper::now())->where('account')->eq($account)->exec(false);
    }

    /**
     * Check the resetKey.
     * 
     * @param  string   $resetKey 
     * @param  time     $resetedTime 
     * @access public
     * @return void
     */
    public function checkResetKey($resetKey)
    {
        $user = $this->dao->select('*')->from(TABLE_USER)
            ->where('resetKey')->eq($resetKey)
            ->fetch('');
        return $user;
    }

    /**
     * Reset the forgotten password.
     * 
     * @param  string   $resetKey 
     * @param  time     $resetedTime 
     * @access public
     * @return void
     */
    public function resetPassword($resetKey, $password)
    {
        $user = $this->dao->select('*')->from(TABLE_USER)
                ->where('resetKey')->eq($resetKey)
                ->fetch();
        
        $this->dao->update(TABLE_USER)
            ->set('password')->eq(md5($password))
            ->set('resetKey')->eq('')
            ->set('resetedTime')->eq('')
            ->where('resetKey')->eq($resetKey)
            ->exec();
    }

    /**
     * Create a strong password hash with md5.
     * 
     * @param  string    $password 
     * @param  string    $account 
     * @param  string    $join 
     * @access public
     * @return string
     */
    public function createPassword($password, $account, $join)
    {
        return md5(md5($password) . $account . $join);
    }

    /**
     * Create the callback address for oauth.
     * 
     * @param  string    $provider 
     * @access public
     * @return string
     */
    public function createOAuthCallbackURL($provider)
    {
        return commonModel::getSysURL() . helper::createLink('user', 'oauthCallback', "provider=$provider");
    }

    /**
     * Register an account when using OAuth.
     * 
     * @param  string    $provider 
     * @param  string    $openID 
     * @access public
     * @return void
     */
    public function registerOauthAccount($provider, $openID)
    {
        $user = fixer::input('post')
            ->setDefault('join', helper::now())
            ->setDefault('last', helper::now())
            ->setDefault('visits', 1)
            ->setIF($this->cookie->r != '', 'referer', $this->cookie->r)
            ->setIF($this->cookie->r == '', 'referer', '')
            ->add('password', $this->createPassword(md5(mt_rand()), $user->account, $user->join))     // Set a random password.
            ->get();

        $this->dao->insert(TABLE_USER)->data($user)
            ->autoCheck()
            ->batchCheck('account, email', 'notempty')
            ->check('account', 'unique')
            ->check('account', 'account')
            ->check('email', 'unique')
            ->check('email', 'email')
            ->exec();

        if(dao::isError()) return false;
        return $this->bindOAuthAccount($this->post->account, $provider, $openID);
    }

    /**
     * Bind an OAuth account.
     * 
     * @param  string    $account    the chanzhi system account
     * @param  string    $provider   the OAuth provider
     * @param  string    $openID     the open id from provider
     * @access public
     * @return bool
     */
    public function bindOAuthAccount($account, $provider, $openID)
    {
        if(!$account or !$provider or !$openID) return false;

        return $this->dao->replace(TABLE_OAUTH)
            ->set('account')->eq($account)
            ->set('provider')->eq($provider)
            ->set('openID')->eq($openID)
            ->exec();
    }

    /**
     * Get user by an open id.
     * 
     * @param  string    $provider 
     * @param  string    $openID 
     * @access public
     * @return object|bool
     */
    public function getUserByOpenID($provider, $openID)
    {
        $account = $this->dao->select('account')->from(TABLE_OAUTH)
            ->where('provider')->eq($provider)
            ->andWhere('openID')->eq($openID)
            ->fetch('account');
        if(!$account) return false;
        return $this->getByAccount($account);
    }
}
