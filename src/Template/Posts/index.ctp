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
                 <button class="btnPost btn btn-success" type="submit" name="post">Post</button>
               </span>
            </div><hr>
            <div id="main">
               <!--main-->
               <?php foreach($posts as $post) : ?>
                  <div class="post panel panel-default">
                     <!-- post header -->
                     <div class="post-header panel-heading" >
                        <div class="post-header-avatar">
                           <a href="javascript:void(0)">
                              <?php echo $this->Html->image($post->user->avatar, array("height" => 35,"width" => 35,"class" => "media-object img-rounded","id" => "post-header-avatar-" . $post->id))?>
                           </a>
                        </div>
                        <div class="post-header-title">
                           <p>
                              <a href="javascript:void(0)" id = "<?php echo 'post-header-title-username-'.$post->id?>">
                                 <?php echo $post->user->username;?>
                              </a>
                              <?php echo ($post->shareFrom) ? " đã chia sẻ bài viết của <a href='javascript:void(0)'>" . $post->shareFrom . "</a>": "" ?>
                           </p>
                           <small>
                              <span><time>22 minutes</time></span>
                              <span>ago</span>
                           </small>
                        </div>
                        <div class="post-header-action dropdown pull-right">
                           <div class = "post-action-dropdown" data-toggle="dropdown">...</div>
                           <ul class="dropdown-menu">
                              <li class = "post-action-delete" data-id = <?php echo $post->id?> >
                                 <a href="#confirmDeletePostModal" data-toggle="modal">Xóa</a>
                              </li>
                              <li class = "post-action-edit" id = "<?php echo $post->id?>" >
                                 <a href="javascript:void(0)">Chỉnh Sửa</a>
                              </li>
                           </ul>
                        </div>      
                     </div>
                     <!-- post body -->
                     <div class="post-body panel-body">
                        <div class = "post-body-content">
                           <p id = "<?php echo 'post-body-content-'.$post->id?>">
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
                           <div align = "center" class = "post-action-social-like col-xs-4 col-sm-4 col-md-4">
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
                           <div align = "center" class = "post-action-social-comment col-xs-4 col-sm-4 col-md-4">
                              <a href="javascript:void(0)"> 
                                 <span  data-toggle="tooltip" data-placement="bottom" title="Comment">
                                    <span class="glyphicon glyphicon-comment" aria-hidden="true"></span> Comment
                                 </span>
                              </a>
                           </div>
                           <div align = "center" class = "post_action_social_share col-xs-4 col-sm-4 col-md-4">
                              <a href="#previewPostShareModal" data-toggle="modal" onclick="sharePostPreview('<?php echo $post->id?>')">
                                 <span  data-toggle="tooltip" data-placement="bottom" title="Share">
                                    <span class="glyphicon glyphicon-share" aria-hidden="true"></span> Share
                                 </span>
                              </a>
                           </div>
                        </div>
                     </div>
                     <!-- post footer -->
                     <div class="post-footer panel-footer">
                        <div class = "comment-list" <?php echo "id = comment-list-" . $post->id?> >
                           <?php foreach($post->comments as $comment) : ?>
                              <div class="comment">
                                 <div class="comment-avatar-user">
                                    <a href="javascript:void(0)">
                                       <?php echo $this->Html->image($comment->user->avatar, array("height" => 27,"width" => 27,"class" => "media-object img-rounded","style" => "margin-top:-4px"))?>
                                    </a>
                                 </div>
                                 <div class = "comment-body" id = "<?php echo $comment->id?>">
                                    <div class = "parent-comment" id = "<?php echo 'parent-comment-' . $comment->id?>">
                                       <div class = "parent-comment-message"> 
                                          <span>
                                             <a href="javascript:void(0)"><?php echo $comment->user->username;?></a>
                                          </span> <?php echo $comment->message;?> 
                                       </div>
                                       <div class = "parent-comment-action-social"> 
                                          <small>
                                             <span> <a href="javascript:void(0)">Like </a></span> 
                                             <span><a href="javascript:void(0)">Comment </a></span>
                                          </small> 
                                          <small>
                                             <span><time>22 min </time></span>
                                             <span>ago</span>
                                          </small>
                                       </div>
                                       <?php if($comment->children_comments) : ?>
                                          <?php foreach($comment->children_comments as $subComment) : ?>
                                             <div class = "sub-comment-item">
                                                <div class = "comment">
                                                   <div class = "comment-avatar-user">
                                                      <a href="javascript:void(0)">
                                                         <?php echo $this->Html->image($subComment->user->avatar, array("height" => 20,"width" => 20,"class" => "media-object img-rounded","style" => "margin-bottom: 4px"))?>
                                                      </a>
                                                   </div>
                                                   <div class="comment-body">
                                                      <div class = "sub-comment-message"> 
                                                         <span>
                                                            <a href="javascript:void(0)"><?php echo $subComment->user->username?></a>
                                                         </span> <?php echo $subComment->message?> 
                                                      <div class = "sub-comment-action-social">
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
                                    <?php echo $this->Html->image($avatarCurrentUser, array("height" => 20,"width" => 20,"class" => "img-rounded","style" => "margin-bottom: 4px"))?>
                                    <input class = "comment-typing sub-comment-typing" id = "<?php echo $post->id?>" placeholder=" Write a comment...">
                                 </div>
                              </div> 
                           <?php endforeach?>
                        </div>
                        <?php echo $this->Html->image($avatarCurrentUser, array("height" => 27,"width" => 27,"class" => "img-rounded","style" => "margin-top:-4px"))?>
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