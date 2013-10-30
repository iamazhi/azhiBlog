<?php include '../../common/view/header.html.php';?>
<section id="login">
  <div class="box-radius">
    <div class="row">
      <?php if(isset($config->oauth)):?>
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading"><h4><strong><?php echo $lang->user->oauth->lblWelcome;?></strong></h4></div>
          <div class="panel-body">
            <?php 
            foreach($lang->user->oauth->providers as $providerCode => $providerName) 
            {
                $params = "provider=$providerCode" . ($referer ? "&referer=" . helper::safe64Encode($referer) : '');
                echo html::a(inlink('oauthLogin', $params), "<i class='icon-{$providerCode} icon-large'></i> " . $providerName, '', "class='btn btn-default btn-wider btn-lgx btn-block'");
            }
            ?>
          </div>
        </div>
      </div>
      <div class="col-md-6">
      <?php else:?>
      <div class="col-md-12">
      <?php endif;?>
        <div class="panel panel-default">
          <div class="panel-heading"><h4><strong><?php echo $lang->user->login->welcome;?></strong></h4></div>
          <div class="panel-body">
            <form method='post' id='ajaxForm' role='form'>
              <div class="form-group"><?php echo html::input('account','',"placeholder='{$lang->user->inputAccountOrEmail}' class='input-lg'");?></div>
              <div class="form-group"><?php echo html::password('password','',"placeholder='{$lang->user->inputPassword}' class='input-lg'");?></div>
              <?php echo html::submitButton($lang->user->login->common, 'btn btn-primary btn-wider btn-lg');?>
              <?php echo html::hidden('referer', $referer);?>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php include '../../common/view/footer.html.php';?>
