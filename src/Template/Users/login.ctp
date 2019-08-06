<div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
    <div class="panel panel-info" >
        <div class="panel-heading">
            <div class="panel-title"> Đăng nhập</div>
            <div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="#"> Quên mật khẩu?</a></div>
        </div>     
        <div style="padding-top:30px" class="panel-body" >
            <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>  
            <form id="loginform" class="form-horizontal" role="form" action = "<?php echo $this->Url->build(array('controller' => 'users','action' => 'login'));?>" method="post">                               
                <div style="margin-bottom: 25px" class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input id="login-username" type="text" class="form-control" name="username" placeholder = "Tên đăng nhập" autocomplete = 'new-password'>                                      
                </div>                              
                <div style="margin-bottom: 25px" class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input id="login-password" type="password" class="form-control" name="password" placeholder = "Mật khẩu" autocomplete = 'new-password'>
                </div>
                <div style="display:none; margin-bottom: 25px" class="input-group">  
                    <input name="_csrfToken" value="<?= $this->request->getParam('_csrfToken'); ?>" /> 
                </div>                                    
                <div style="margin-top:10px" class="form-group">
                    <div class="col-sm-12 controls">
                        <input type="submit" class="btn btn-primary" id="btn-login" value = "Đăng nhập"> 
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12 control">
                        <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
                            Bạn chưa có tài khoản 
                            <a href="#" onClick="$('#loginbox').hide(); $('#signupbox').show()">
                                Đăng kí tại đây
                            </a>
                        </div>
                    </div>
                </div> 
            </form>       
        </div>                     
    </div>  
</div>

<div id="signupbox" style="display:none; margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
    <div class="panel panel-info">
        <div class="panel-heading">
            <div class="panel-title">Đăng kí</div>
            <div style="float:right; font-size: 85%; position: relative; top:-10px"><a id="signinlink" href="#" onclick="$('#signupbox').hide(); $('#loginbox').show()">Đăng nhập</a></div>
        </div>  
        <div class="panel-body" >
            <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>  
            <form id="loginform" class="form-horizontal" role="form" action = "<?php echo $this->Url->build(array('controller' => 'users','action' => 'register'));?>" method="post">                               
                <div style="margin-bottom: 25px" class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input id="login-username" type="text" class="form-control" name="username" placeholder = "Tên đăng nhập" autocomplete = 'new-password'>                                     
                </div>                              
                <div style="margin-bottom: 25px" class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input id="login-password" type="password" class="form-control" name="password" placeholder = "Mật khẩu" autocomplete = 'new-password'>
                </div>  
                <div style="display:none; margin-bottom: 25px" class="input-group">  
                    <input name="_csrfToken" value="<?= $this->request->getParam('_csrfToken'); ?>" /> 
                </div>                                      
                <div style="margin-top:10px" class="form-group">
                    <div class="col-sm-12 controls">
                        <input type="submit" class="btn btn-primary" id="btn-login" value = "Đăng ký"> 
                    </div>
                </div>
            </form> 
        </div>
    </div>      
</div>