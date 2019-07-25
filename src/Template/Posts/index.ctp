<?php if (isset($title)) $this->assign('title', $title);?>
<div class="container">
   <div class="container-fluid" id="wrapper">
      <div class="row">
         <nav class="navbar navbar-default">
             <div class="container-fluid">
                  <div class="navbar-header">
                     <?php echo $this->Html->link('Blog',array('controller' => 'posts','action' => 'index','full_base' => true), array('class' => 'navbar-brand')); ?>
                  </div>
                  <ul class="nav navbar-nav navbar-right">
                    <li>
                     <?php echo $this->Html->link('Home',array('controller' => 'posts','action' => 'index','full_base' => true)); ?>
                  </li>
                    <li><a href="javascript:void(0)">Profile</a></li>
                  <li>
                     <?php echo $this->Html->link('Logout',array('controller' => 'users','action' => 'logout','full_base' => true)); ?>
                  </li>
                  </ul>
             </div>
         </nav>
      </div>
      <div class="row">
         <div class="hidden-xs col-sm-4 col-md-3">
            <!--left menu-->
         </div>
         <div class="col-xs-12 col-sm-8 col-md-6">
            <div class="input-group">
               <input class="post-message form-control" type="text" name="content" placeholder="Make a post...">
               <span class="input-group-btn">
                 <button class="post btn btn-success" type="submit" name="post">Post</button>
               </span>
            </div><hr>
            <div id="main">
               <!--main-->
               <?php foreach($posts as $post) : ?>
                  <div class="panel panel-default">
                     <!-- post header -->
                     <div class="panel-heading" >
                        <h3 class="panel-title">
                           <a href="javascript:void(0)">
                              <div class="post-header">
                                 <div class="post-header-avatar">
                                    <a href="javascript:void(0)">
                                       <?php echo $this->Html->image($post->user->avatar, array("alt" => "","height" => "35px","width" => "35px","class" => "media-object img-rounded"))?>
                                    </a>
                                 </div>
                                 <div class="post-header-body">
                                       <span>
                                          <a href="javascript:void(0)">
                                             <?php echo $post->user->username;?>
                                          </a>
                                       </span><br>
                                    <small><span><time>22 minutes</time></span><span>ago</span></small>
                                 </div>
                              </div>
                           </a>
                        </h3>
                     </div>
                     <!-- post body -->
                     <div class="panel-body">
                        <div>
                           <p class="text-post">
                              <?php echo $post->content;?>
                           </p>
                        </div>
                        <div style = "border-top:2px solid #EDEDED;padding-top:10px">  
                           <div align = "center" class = "col-xs-4 col-sm-4 col-md-4">
                              <a href="javascript:void(0)">
                                 <span  data-toggle="tooltip" data-placement="bottom" title="Like">
                                    <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>  Like
                                 </span>
                              </a>
                           </div>
                           <div align = "center" class = "col-xs-4 col-sm-4 col-md-4">
                              <a href="javascript:void(0)">
                                 <span  data-toggle="tooltip" data-placement="bottom" title="Comment">
                                    <span class="glyphicon glyphicon-comment" aria-hidden="true"></span>  Comment
                                 </span>
                              </a>
                           </div>
                           <div align = "center" class = "col-xs-4 col-sm-4 col-md-4">
                              <a href="javascript:void(0)">
                                 <span  data-toggle="tooltip" data-placement="bottom" title="Share">
                                    <span class="glyphicon glyphicon-share" aria-hidden="true"></span>  Share
                                 </span>
                              </a>
                           </div>
                        </div>
                     </div>
                     <!-- post footer -->
                     <div class="panel-footer">
                        <div class = "comment-list" id = "<?php echo $post->id?>">
                           <?php $listComment = $post->Comment;?>
                           <?php foreach($listComment as $comment) : ?>
                              <div class="comment">
                                 <div class="comment-avatar-user">
                                    <a href="javascript:void(0)">
                                       <?php echo $this->Html->image($comment->user->avatar, array("alt" => "","height" => "27px","width" => "27px","class" => "media-object img-rounded"))?>
                                    </a>
                                 </div>
                                 <div class = "comment-body" id = "<?php echo $comment->id?>">
                                    <div class = "sub-comment"  id = "<?php echo 'parent-comment-' . $comment->id?>">
                                       <p class="" style = "margin: 0;padding: 0;"> 
                                          <span><a href="javascript:void(0)"><?php echo $comment->user->username;?></a></span> <?php echo $comment->message;?> 
                                       </p>
                                       <p class="comment" style = "margin: 0;padding: 0;"> 
                                          <small>
                                             <span> <a href="javascript:void(0)">Like </a></span> 
                                             <span><a href="javascript:void(0)">Comment </a></span>
                                          </small> 
                                          <small><span><time>22 min </time></span><span>ago</span></small>
                                       </p>
                                       <?php if($comment->children) : ?>
                                          <?php foreach($comment->children as $subComment) : ?>
                                             <div class = "sub-comment-item">
                                                <div class = "comment">
                                                   <div class = "comment-avatar-user">
                                                      <a href="javascript:void(0)">
                                                         <?php echo $this->Html->image($comment->user->avatar, array("alt" => "","height" => "20px","width" => "20px","class" => "media-object img-rounded"))?>
                                                      </a>
                                                   </div>
                                                   <div class="comment-body">
                                                      <p style = "margin: 0;padding: 0;" class="comment"> 
                                                         <span>
                                                            <a href="javascript:void(0)"><?php echo $subComment->user->username?></a>
                                                         </span> <?php echo $subComment->message?> 
                                                      </p>
                                                      <div>
                                                         <small><span> <a href="javascript:void(0)">Like </a></span> <span> <a href="javascript:void(0)">Comment </a></span></small><small><span><time>2 min </time></span><span>ago</span></small>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          <?php endforeach?>
                                       <?php endif?>
                                    </div>
                                    <?php echo $this->Html->image($avatarCurrentUser, 
                                                array("alt" => "","height" => "20px","width" => "20px",
                                                      "style" => array("margin-bottom : 4px"),
                                                      "class" => "img-rounded"))?>
                                    <input class = "comment-typing sub-comment-typing" id = "<?php echo $post['Post']['id']?>" placeholder="Write a comment..."  style="height:23px;width: 92%;margin-top: 10px;">
                                 </div>
                              </div> 
                           <?php endforeach?>
                        </div>
                        <?php echo $this->Html->image($avatarCurrentUser, 
                                                array("alt" => "","height" => "25px","width" => "25px",
                                                      "style" => array("margin-bottom : 4px"),
                                                      "class" => "img-rounded"))?>
                        <input class = "comment-typing" id = "<?php echo $post['Post']['id']?>" placeholder="Write a comment..."  style="width: 92%;margin-top: 15px;">
                     </div>
                  </div>
               <?php endforeach;?>
            </div>
            <button  data-toggle="tooltip" data-placement="bottom" title="Load More" class = "btn btn-success load-more" type="button" style="width:100%;">
                  LOAD MORE 
               </button>
         </div>
         <!---Sidebar menu started-->
         <div class="hidden-xs hidden-sm col-md-3">
            
         </div>
      </div>
   </div>
</div>