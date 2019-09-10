<div id="previewPostShareModal" class="modal fade">
   <div class="modal-dialog modal-confirm" style = "width:600px;">
      <div class="modal-content" style = "padding:0px 0px 15px 0px;">
         <div class="panel panel-default">
            <!-- post header -->
            <div class="panel-heading" >
               <h3 class="panel-title">
                  <a href="javascript:void(0)">
                     <div class="post-header">
                        <div class="post-header-avatar">
                           <a href="javascript:void(0)">
                              <?php echo $this->Html->image("/img/user.png", array("alt" => "","class" => "media-object img-rounded post-user-avatar","id" => "avatarOfUserPostShare"))?>
                           </a>
                        </div>
                        <div class="post-header-body">
                              <a href="javascript:void(0)" id = "nameOfUserPostShare" style = "float:left;"></a>
                              <br>
                           <small><span><time>22 minutes</time></span><span>ago</span></small>
                        </div>
                     </div>
                  </a>
               </h3>
            </div>
            <!-- post body -->
            <div class="panel-body" style = "padding-bottom:0px">
               <div>
                  <p id = "textPostShare"></p>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-danger share-post-button" onclick="sharePost()">Share</button>
         </div>
      </div>
   </div>
</div>