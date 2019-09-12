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
               <input type="hidden" name="_csrfToken" <?php echo "value = " . $this->request->getParam('_csrfToken'); ?> />
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
                                       <?php echo $this->Html->image($post->user->avatar, array("alt" => "","class" => "media-object img-rounded post-user-avatar","id" => "user-avatar-post-" . $post->id))?>
                                    </a>
                                 </div>
                                 <div class="post-header-body">
                                    <span>
                                       <a href="javascript:void(0)"  id = "<?php echo 'username-post-'.$post->id?>"><?php echo $post->user->username;?></a>
                                       <?php echo ($post->shareFrom) ? " đã chia sẻ bài viết của <a href='javascript:void(0)'>" . $post->shareFrom . "</a>": "" ?>
                                    </span><br>
                                    <small><span><time>22 minutes</time></span><span>ago</span></small>
                                 </div>
                                 <div class="dropdown pull-right">
                                    <p class = "post-action" data-toggle="dropdown">...</p>
                                    <ul class="dropdown-menu">
                                       <li class = "post-action-delete" data-id = <?php echo $post->id?> >
                                          <a href="#confirmDeletePostModal" data-toggle="modal">Xóa</a></li>
                                       <li class = "post-action-edit" id = "<?php echo $post->id?>" >
                                          <a href="javascript:void(0)">Chỉnh Sửa</a>
                                       </li>
                                    </ul>
                                 </div>
                              </div>
                           </a>
                        </h3>     
                     </div>
                     <!-- post body -->
                     <div class="panel-body">
                        <div>
                           <p class="text-post" id = "<?php echo 'text-post-'.$post->id?>">
                              <?php echo $post->content;?>
                           </p>
                           <div class = "edit-post" id = "<?php echo 'edit-post-'.$post->id?>">
                              <textarea class = "edit-post-preview"><?php echo $post->content;?></textarea>
                              <div class = "edit-post-action">
                                 <button class = "btn btn-danger pull-right" onclick="saveEditPost('<?php echo $post->id?>')">Lưu Lại</button>
                                 <button class = "btn btn-info pull-right" onclick="cancelEditPost('<?php echo $post->id?>')">Hủy Bỏ</button>
                              </div>
                           </div>
                        </div>
                        <div class = "post-action-social">  
                           <div align = "center" class = "col-xs-4 col-sm-4 col-md-4">
                              <a href="javascript:void(0)" onclick="likePost(this,'<?php echo $post->id?>')">
                                 <?php if($post->current_user_is_like_post) :?>
                                    <span  data-toggle="tooltip" data-placement="bottom" title="Like">
                                       <i class="fa fa-thumbs-up"></i> Like
                                    </span>
                                 <?php else:?>
                                    <span  data-toggle="tooltip" data-placement="bottom" title="Like">
                                       <i class="fa">&#xf087;</i> Like
                                    </span>
                                 <?php endif?>
                              </a>
                           </div>
                           <div align = "center" class = "col-xs-4 col-sm-4 col-md-4">
                              <a href="javascript:void(0)"> 
                                 <span  data-toggle="tooltip" data-placement="bottom" title="Comment">
                                    <span class="glyphicon glyphicon-comment" aria-hidden="true"></span> Comment
                                 </span>
                              </a>
                           </div>
                           <div align = "center" class = "col-xs-4 col-sm-4 col-md-4">
                              <a href="#previewPostShareModal" data-toggle="modal" onclick="sharePostPreview('<?php echo $post->id?>')">
                                 <span  data-toggle="tooltip" data-placement="bottom" title="Share">
                                    <span class="glyphicon glyphicon-share" aria-hidden="true"></span> Share
                                 </span>
                              </a>
                           </div>
                        </div>
                     </div>
                     <!-- post footer -->
                     <div class="panel-footer">
                        <div class = "comment-list" <?php echo "id = comment-list-" . $post->id?> >
                           <?php foreach($post->comments as $comment) : ?>
                              <div class="comment">
                                 <div class="comment-avatar-user">
                                    <a href="javascript:void(0)">
                                       <?php echo $this->Html->image($comment->user->avatar, array("alt" => "","class" => "media-object img-rounded comment-user-avatar"))?>
                                    </a>
                                 </div>
                                 <div class = "comment-body" id = "<?php echo $comment->id?>">
                                    <div class = "sub-comment"  id = "<?php echo 'parent-comment-' . $comment->id?>">
                                       <p> 
                                          <span>
                                             <a href="javascript:void(0)"><?php echo $comment->user->username;?></a>
                                          </span> <?php echo $comment->message;?> 
                                       </p>
                                       <p> 
                                          <small>
                                             <span> <a href="javascript:void(0)">Like </a></span> 
                                             <span><a href="javascript:void(0)">Comment </a></span>
                                          </small> 
                                          <small><span><time>22 min </time></span><span>ago</span></small>
                                       </p>
                                       <?php if($comment->children_comments) : ?>
                                          <?php foreach($comment->children_comments as $subComment) : ?>
                                             <div class = "sub-comment-item">
                                                <div class = "comment">
                                                   <div class = "comment-avatar-user">
                                                      <a href="javascript:void(0)">
                                                         <?php echo $this->Html->image($subComment->user->avatar, array("alt" => "","class" => "media-object img-rounded sub-comment-user-avatar"))?>
                                                      </a>
                                                   </div>
                                                   <div class="comment-body">
                                                      <p> 
                                                         <span>
                                                            <a href="javascript:void(0)"><?php echo $subComment->user->username?></a>
                                                         </span> <?php echo $subComment->message?> 
                                                      </p>
                                                      <div>
                                                         <small>
                                                            <span> <a href="javascript:void(0)">Like </a></span> 
                                                            <span> <a href="javascript:void(0)">Comment </a></span>
                                                         </small>
                                                         <small>
                                                            <span><time>2 min </time></span><span>ago</span>
                                                         </small>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          <?php endforeach?>
                                       <?php endif?>
                                    </div>
                                    <?php echo $this->Html->image($avatarCurrentUser, array("alt" => "","class" => "img-rounded sub-comment-user-avatar"))?>
                                    <input class = "comment-typing sub-comment-typing" id = "<?php echo $post->id?>" placeholder=" Write a comment...">
                                 </div>
                              </div> 
                           <?php endforeach?>
                        </div>
                        <?php echo $this->Html->image($avatarCurrentUser, array("alt" => "","class" => "img-rounded comment-user-avatar"))?>
                        <input class = "comment-typing" id = "<?php echo $post->id?>" placeholder=" Write a comment...">
                     </div>
                  </div>
               <?php endforeach;?>
            </div>
            <button  data-toggle="tooltip" data-placement="bottom" title="Load More" class = "btn btn-success load-more" type="button">
               LOAD MORE 
            </button>
         </div>
         <!---Sidebar menu started-->
         <div class="hidden-xs hidden-sm col-md-3">
            
         </div>
      </div>
   </div>
</div>
<?php  echo $this->element('/Modal/confirm-delete-post-modal')?>  
<?php  echo $this->element('/Modal/preview-post-share-modal')?> 