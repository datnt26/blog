$(document).ready(function() {  
    $(".post-action-edit").click(function(){        
        var textarea = $('#edit-post-' + $(this).attr('id')).find('textarea');
        textarea.height($('#text-post-' + $(this).attr('id')).height());
        $('#text-post-' + $(this).attr('id')).hide();
        $('#edit-post-' + $(this).attr('id')).show();
    });
    $(".delete-post-button").click(function(){
        var postId = $('.delete-post-button').val();
        $.ajax({
                method: "POST",
                url: '/blog/posts/delete',
                dataType: 'json',
                data: {
                    postId : postId
                },
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                },
                success: function (data) {
                    $('#main').empty();
                    $.each(data, function(k,v) {
                        console.log(data);
                        // init new post
                        var post = $('<div>').attr({class: 'panel panel-default'}).appendTo($('#main'));

                        /* Part header of post*/
                        var post_header = $('<div>').attr({class:'panel-heading'}).appendTo($(post));
                        var post_header_title = $('<h3 class="panel-title"><a href="javascript:void(0)"><div class="post-header"></div></a></h3>').appendTo($(post_header));
                        var post_header_avatar = $('<div>').attr({class:'post-header-avatar',}).appendTo($(post_header_title));
                        $('<a href="javascript:void(0)"><img src="/blog'+ v.user.avatar +'" alt="" class="media-object img-rounded post-user-avatar"></a>').appendTo($(post_header_avatar));
                        var post_header_body = $('<div>').attr({class:'post-header-body',}).appendTo($(post_header_title));
                        $('<span> <a href="javascript:void(0)">' + v.user.username +'</a> </span><br> <small><span><time>22 minutes</time></span><span>ago</span></small>').appendTo($(post_header_body));
                        /* End part header of post*/ 

                        /* Part content of post*/
                        var post_content = $('<div>').attr({ class:'panel-body',}).appendTo($(post));
                        $('<div><p class="text-post">' + v.content + '</p></div>').appendTo($(post_content));
                        $('<div style = "border-top:2px solid #EDEDED;padding-top:10px"><div align = "center" class = "col-xs-4 col-sm-4 col-md-4"> <a href="javascript:void(0)"> <span data-toggle="tooltip" data-placement="bottom" title="Like"> <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> Like </span> </a></div><div align = "center" class = "col-xs-4 col-sm-4 col-md-4"><a href="javascript:void(0)"><span data-toggle="tooltip" data-placement="bottom" title="Comment"><span class="glyphicon glyphicon-comment" aria-hidden="true"></span> Comment </span></a></div><div align = "center" class = "col-xs-4 col-sm-4 col-md-4"><a href="javascript:void(0)"><span data-toggle="tooltip" data-placement="bottom" title="Share"><span class="glyphicon glyphicon-share" aria-hidden="true"></span> Share </span></a></div></div>').appendTo($(post_content));
                        /* End part content of post*/                   

                        /* Part footer of post*/
                        var post_footer = $('<div>').attr({class:'panel-footer',}).appendTo($(post));
                        var comment_list = $('<div>').attr({class:'comment-list',id: v.id}).appendTo($(post_footer));
                        $.each(v.comments, function(key,comment) {
                            var commentDiv = $('<div>').attr({class:'comment'}).appendTo($(comment_list));
                            var comment_avatar_user = $('<div>').attr({class:'comment-avatar-user'}).appendTo($(commentDiv));
                            $('<a href="javascript:void(0)"><img src="/blog'+ comment.user.avatar +'" alt="" class="media-object img-rounded comment-user-avatar"></a>').appendTo($(comment_avatar_user));
                            var comment_body = $('<div>').attr({class:'comment-body',id:comment.id}).appendTo($(commentDiv));
                            var sub_comment = $('<div>').attr({class:'sub-comment',id:'parent-comment-' + comment.id}).appendTo($(comment_body));
                            var comment_body_content = $('<p>').attr({class: 'comment',style:'margin: 0;padding: 0;'}).appendTo($(sub_comment));
                            $(comment_body_content).append('<span>'+'<a href="javascript:void(0">'+comment.user.username+'</a>'+'</span> '+comment.message);
                            $(sub_comment).append('<p class="comment" style = "margin: 0;padding: 0;"><small><span><a href="javascript:void(0)">Like </a></span> <span> <a href="javascript:void(0)">Comment </a></span></small><small><span><time>2 min </time></span><span>ago</span></small></p>');
                            $.each(comment.children_comments, function(key,subComment) {
                                var sub_comment_item = $('<div>').attr({class: 'sub-comment-item'}).appendTo($('.sub-comment#parent-comment-' + subComment.parent_id));
                                var comment = $('<div>').attr({class: 'comment'}).appendTo($(sub_comment_item));
                                var comment_avatar_user = $('<div>').attr({class: 'comment-avatar-user'}).appendTo($(comment));
                                var link_comment_avatar_user = $('<a>').attr({href:'javascript:void(0)'}).appendTo($(comment_avatar_user))
                                $('<img>').attr({class:'media-object img-rounded sub-comment-user-avatar',src:'/blog' + subComment.user.avatar}).appendTo($(link_comment_avatar_user));
                                var comment_body = $('<div>').attr({class: 'comment-body'}).appendTo($(comment));
                                var comment_body_content = $('<p>').attr({class: 'comment',style:'margin: 0;padding: 0;'}).appendTo($(comment_body));
                                $(comment_body_content).append('<span>'+'<a href="javascript:void(0">'+subComment.user.username+'</a>'+'</span> '+subComment.message);
                                $(comment_body).append('<div><small><span><a href="javascript:void(0)">Like </a></span> <span> <a href="javascript:void(0)">Comment </a></span></small><small><span><time>2 min </time></span><span>ago</span></small></div>');
                            });
                            $('<img>').attr({class:'img-rounded sub-comment-user-avatar',src:'/blog' + comment.user.avatar}).appendTo($(comment_body));
                            $('<input>').attr({class:'comment-typing sub-comment-typing',id:v.id,placeholder:'Write a comment...',style:'margin-left:3px;'}).appendTo($(comment_body));
                        });
                        $('<img src="/blog' + v.user.avatar + '" alt="" class="img-rounded comment-user-avatar">').appendTo($(post_footer));
                        $('<input class="comment-typing" id="' + v.id + '" placeholder="Write a comment..." style="margin-left:3px;">').appendTo($(post_footer));
                        /* End part footer of post*/
                    });
                }
        });
        $('#confirmDeletePostModal').modal('hide');
    });
    $(".post").click(function(){
        var content = $('.post-message').val();
        $.ajax({
                method: "POST",
                url: '/blog/posts/create',
                dataType: 'json',
                data: {
                    content : content
                },
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                },
                success: function (data) {
                    // init new post
                    var post = $('<div>').attr({class: 'panel panel-default'}).prependTo($('#main'));

                    /* Part header of post*/
                    var post_header = $('<div>').attr({class:'panel-heading'}).appendTo($(post));
                    var post_header_title = $('<h3 class="panel-title"><a href="javascript:void(0)"><div class="post-header"></div></a></h3>').appendTo($(post_header));
                    var post_header_avatar = $('<div>').attr({class:'post-header-avatar',}).appendTo($(post_header_title));
                    $('<a href="javascript:void(0)"><img src="/blog'+ data.user.avatar +'" alt="" class="media-object img-rounded post-user-avatar"></a>').appendTo($(post_header_avatar));
                    var post_header_body = $('<div>').attr({class:'post-header-body',}).appendTo($(post_header_title));
                    $('<span> <a href="javascript:void(0)">' + data.user.username +'</a> </span><br> <small><span><time>22 minutes</time></span><span>ago</span></small>').appendTo($(post_header_body));
                    /* End part header of post*/ 

                    /* Part content of post*/
                    var post_content = $('<div>').attr({ class:'panel-body',}).appendTo($(post));
                    $('<div><p class="text-post">' + data.content + '</p></div>').appendTo($(post_content));
                    $('<div style = "border-top:2px solid #EDEDED;padding-top:10px"> <div align = "center" class = "col-xs-4 col-sm-4 col-md-4"> <a href="javascript:void(0)"> <span data-toggle="tooltip" data-placement="bottom" title="Like"> <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> Like </span> </a> </div> <div align = "center" class = "col-xs-4 col-sm-4 col-md-4"> <a href="javascript:void(0)"> <span data-toggle="tooltip" data-placement="bottom" title="Comment"> <span class="glyphicon glyphicon-comment" aria-hidden="true"></span> Comment </span> </a> </div> <div align = "center" class = "col-xs-4 col-sm-4 col-md-4"> <a href="javascript:void(0)"> <span data-toggle="tooltip" data-placement="bottom" title="Share"> <span class="glyphicon glyphicon-share" aria-hidden="true"></span> Share </span> </a> </div> </div>').appendTo($(post_content));
                    /* End part content of post*/                   

                    /* Part footer of post*/
                    var post_footer = $('<div>').attr({class:'panel-footer',}).appendTo($(post));
                    var comment_list = $('<div>').attr({class:'comment-list',id: data.id}).appendTo($(post_footer));
                    $('<img src="/blog' + data.user.avatar + '" alt="" class="img-rounded comment-user-avatar">').appendTo($(post_footer));
                    $('<input class="comment-typing" id="' + data.id + '" placeholder=" Write a comment..." style="margin-left:3px;">').appendTo($(post_footer));
                    /* End part footer of post*/

                    //empty input after create post success
                    $('.post-message').val('');
                }
            });
    });
    $(".load-more").click(function(){
        // Each page has 5 posts
        if ($("#main").children("div").length < 5) return;
        var currentPage = (Math.floor($("#main").children("div").length % 5) == 0) ? Math.floor($("#main").children("div").length / 5) : Math.floor($("#main").children("div").length / 5) + 1;
        $.ajax({
                method: "POST",
                url: '/blog/posts/loadMore',
                dataType: 'json',
                data: {
                    currentPage : currentPage
                },
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                },
                success: function (data) {
                    $.each(data, function(k,v) {
                        // init new post
                        var post = $('<div>').attr({class: 'panel panel-default'}).appendTo($('#main'));

                        /* Part header of post*/
                        var post_header = $('<div>').attr({class:'panel-heading'}).appendTo($(post));
                        var post_header_title = $('<h3 class="panel-title"><a href="javascript:void(0)"><div class="post-header"></div></a></h3>').appendTo($(post_header));
                        var post_header_avatar = $('<div>').attr({class:'post-header-avatar',}).appendTo($(post_header_title));
                        $('<a href="javascript:void(0)"><img src="/blog'+ v.user.avatar +'" alt="" class="media-object img-rounded post-user-avatar"></a>').appendTo($(post_header_avatar));
                        var post_header_body = $('<div>').attr({class:'post-header-body',}).appendTo($(post_header_title));
                        $('<span> <a href="javascript:void(0)">' + v.user.username +'</a> </span><br> <small><span><time>22 minutes</time></span><span>ago</span></small>').appendTo($(post_header_body));
                        /* End part header of post*/ 

                        /* Part content of post*/
                        var post_content = $('<div>').attr({ class:'panel-body',}).appendTo($(post));
                        $('<div><p class="text-post">' + v.content + '</p></div>').appendTo($(post_content));
                        $('<div style = "border-top:2px solid #EDEDED;padding-top:10px"><div align = "center" class = "col-xs-4 col-sm-4 col-md-4"> <a href="javascript:void(0)"> <span data-toggle="tooltip" data-placement="bottom" title="Like"> <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> Like </span> </a></div><div align = "center" class = "col-xs-4 col-sm-4 col-md-4"><a href="javascript:void(0)"><span data-toggle="tooltip" data-placement="bottom" title="Comment"><span class="glyphicon glyphicon-comment" aria-hidden="true"></span> Comment </span></a></div><div align = "center" class = "col-xs-4 col-sm-4 col-md-4"><a href="javascript:void(0)"><span data-toggle="tooltip" data-placement="bottom" title="Share"><span class="glyphicon glyphicon-share" aria-hidden="true"></span> Share </span></a></div></div>').appendTo($(post_content));
                        /* End part content of post*/                   

                        /* Part footer of post*/
                        var post_footer = $('<div>').attr({class:'panel-footer',}).appendTo($(post));
                        var comment_list = $('<div>').attr({class:'comment-list',id: v.id}).appendTo($(post_footer));
                        $.each(v.Comment, function(key,comment) {
                            var commentDiv = $('<div>').attr({class:'comment'}).appendTo($(comment_list));
                            var comment_avatar_user = $('<div>').attr({class:'comment-avatar-user'}).appendTo($(commentDiv));
                            $('<a href="javascript:void(0)"><img src="/blog'+ comment.user.avatar +'" alt="" class="media-object img-rounded comment-user-avatar"></a>').appendTo($(comment_avatar_user));
                            var comment_body = $('<div>').attr({class:'comment-body',id:comment.id}).appendTo($(commentDiv));
                            var sub_comment = $('<div>').attr({class:'sub-comment',id:'parent-comment-' + comment.id}).appendTo($(comment_body));
                            var comment_body_content = $('<p>').attr({class: 'comment',style:'margin: 0;padding: 0;'}).appendTo($(sub_comment));
                            $(comment_body_content).append('<span>'+'<a href="javascript:void(0">'+comment.user.username+'</a>'+'</span> '+comment.message);
                            $(sub_comment).append('<p class="comment" style = "margin: 0;padding: 0;"><small><span><a href="javascript:void(0)">Like </a></span> <span> <a href="javascript:void(0)">Comment </a></span></small><small><span><time>2 min </time></span><span>ago</span></small></p>');
                            $.each(comment.children, function(key,subComment) {
                                var sub_comment_item = $('<div>').attr({class: 'sub-comment-item'}).appendTo($('.sub-comment#parent-comment-' + subComment.parent_id));
                                var comment = $('<div>').attr({class: 'comment'}).appendTo($(sub_comment_item));
                                var comment_avatar_user = $('<div>').attr({class: 'comment-avatar-user'}).appendTo($(comment));
                                var link_comment_avatar_user = $('<a>').attr({href:'javascript:void(0)'}).appendTo($(comment_avatar_user))
                                $('<img>').attr({class:'media-object img-rounded sub-comment-user-avatar',src:'/blog' + subComment.user.avatar}).appendTo($(link_comment_avatar_user));
                                var comment_body = $('<div>').attr({class: 'comment-body'}).appendTo($(comment));
                                var comment_body_content = $('<p>').attr({class: 'comment',style:'margin: 0;padding: 0;'}).appendTo($(comment_body));
                                $(comment_body_content).append('<span>'+'<a href="javascript:void(0">'+subComment.user.username+'</a>'+'</span> '+subComment.message);
                                $(comment_body).append('<div><small><span><a href="javascript:void(0)">Like </a></span> <span> <a href="javascript:void(0)">Comment </a></span></small><small><span><time>2 min </time></span><span>ago</span></small></div>');
                            });
                            $('<img>').attr({class:'img-rounded sub-comment-user-avatar',src:'/blog' + comment.user.avatar}).appendTo($(comment_body));
                            $('<input>').attr({class:'comment-typing sub-comment-typing',id:v.id,placeholder:'Write a comment...',style:'margin-left:3px;'}).appendTo($(comment_body));
                        });
                        $('<img src="/blog' + v.user.avatar + '" alt="" class="img-rounded comment-user-avatar">').appendTo($(post_footer));
                        $('<input class="comment-typing" id="' + v.id + '" placeholder="Write a comment..." style="margin-left:3px;">').appendTo($(post_footer));
                        /* End part footer of post*/
                    });
                }
            });
    });
    $('body').on('keypress','input.comment-typing', function (e) {
        if (e.which === 13) {
            createComment($(this));
        }
    });
});
function createComment($this) {
    var postId = $this.attr('id');
    var parent_id = null;
    var message = $this.val();
    var type = $this.attr('class');
    if (type.includes('sub-comment-typing')) {
        parent_id = $this.closest('div').attr('id');
    }
    $.ajax({
            method: "POST",
            url: '/blog/comments/addComment',
            dataType: 'json',
            data: {
                postId : postId,
                message : message,
                parent_id : parent_id
            },
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function (data) {
                $('input').val('');
                if (type.includes('sub-comment-typing')) {
                    // init new post
                    var sub_comment_item = $('<div>').attr({class: 'sub-comment-item'}).appendTo($('.sub-comment#parent-comment-' + parent_id));
                    var comment = $('<div>').attr({class: 'comment'}).appendTo($(sub_comment_item));
                    var comment_avatar_user = $('<div>').attr({class: 'comment-avatar-user'}).appendTo($(comment));
                    var link_comment_avatar_user = $('<a>').attr({href:'javascript:void(0)'}).appendTo($(comment_avatar_user))
                    $('<img>').attr({class:'media-object img-rounded sub-comment-user-avatar',src:'/blog' + data.user.avatar}).appendTo($(link_comment_avatar_user));
                    var comment_body = $('<div>').attr({class: 'comment-body'}).appendTo($(comment));
                    var comment_body_content = $('<p>').attr({class: 'comment',style:'margin: 0;padding: 0;'}).appendTo($(comment_body));
                    $(comment_body_content).append('<span>'+'<a href="javascript:void(0">'+data.user.username+'</a>'+'</span> '+data.message);
                    $(comment_body).append('<div><small><span><a href="javascript:void(0)">Like </a></span> <span> <a href="javascript:void(0)">Comment </a></span></small><small><span><time>2 min </time></span><span>ago</span></small></div>');
                    return;
                }
                // when type of input is comment
                var comment = $('<div>').attr({class: 'sub-comment-item'}).appendTo($('.comment-list#' + postId));
                var comment_avatar_user = $('<div>').attr({class: 'comment-avatar-user'}).appendTo($(comment));
                var link_comment_avatar_user = $('<a>').attr({href:'javascript:void(0)'}).appendTo($(comment_avatar_user))
                $('<img>').attr({class:'media-object img-rounded comment-user-avatar',src:'/blog' + data.user.avatar}).appendTo($(link_comment_avatar_user));
                var comment_body = $('<div>').attr({class:'comment-body',id:data.id}).appendTo($(comment));
                var sub_comment = $('<div>').attr({class:'sub-comment',id:'parent-comment-' + data.id}).appendTo($(comment_body));
                var comment_body_content = $('<p>').attr({class: 'comment',style:'margin: 0;padding: 0;'}).appendTo($(sub_comment));
                $(comment_body_content).append('<span>'+'<a href="javascript:void(0">'+data.user.username+'</a>'+'</span> '+data.message);
                $(sub_comment).append('<p class="comment" style = "margin: 0;padding: 0;"><small><span><a href="javascript:void(0)">Like </a></span> <span> <a href="javascript:void(0)">Comment </a></span></small><small><span><time>2 min </time></span><span>ago</span></small></p>');
                $('<img>').attr({class:'img-rounded sub-comment-user-avatar',src:'/blog' + data.user.avatar}).appendTo($(comment_body));
                $('<input>').attr({class:'comment-typing sub-comment-typing',id:postId,placeholder:'Write a comment...',style:'margin-left:3px;'}).appendTo($(comment_body));
            }
    });
}

$(document).on("click", ".post-action-delete", function () {
    var eventId = $(this).data('id');
    $('.delete-post-button').val( eventId );
});

function saveEditPost(postId) {
    var content = $('#edit-post-' + postId).find('textarea').val();
    $.ajax({
            method: "POST",
            url: '/blog/posts/saveEditPost',
            dataType: 'json',
            data: {
                postId : postId,
                content : content
            },
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function (data) {
                $('#text-post-' + postId).text(data.content);
                $('#edit-post-' + postId).hide();
                $('#text-post-' + postId).show();
            }
    });
}

function cancelEditPost(postId) {
    $('#edit-post-' + postId).hide();
    $('#text-post-' + postId).show();
}

function likePost(elem,postId) {
    $.ajax({
            method: "POST",
            url: '/blog/posts/likePost',
            dataType: 'json',
            data: {
                postId : postId
            },
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
            },
            success: function (data) {
                $(elem).empty();
                var span = $('<span>').attr({'data-toggle':'tooltip','data-placement':'bottom','title':'Like'}).appendTo($(elem));
                if (!data.isLike) {                    
                    $('<i>').attr({class:'fa','style':'font-size:19px'}).html('&#xf087;').appendTo(span);
                    $(elem).append(' Like');
                    return;
                }
                $('<i>').attr({class:'fa fa-thumbs-up','style':'color:blue;font-size:19px'}).appendTo(span);
                $(elem).append(' Like');
            }
    });
}

function sharePostPreview(postId){
    $("#avatarOfUserPostShare").attr("src", $('#user-avatar-post-' + postId).attr('src'));
    $("#nameOfUserPostShare").html($("#username-post-" + postId).text());
    $("#textPostShare").text($('#text-post-' + postId).text());
}

function sharePost() {
    var content = $.trim($("#textPostShare").text());
    var shareFrom =  $.trim($("#nameOfUserPostShare").text());
    $.ajax({
        method: "POST",
        url: '/blog/posts/sharePost',
        dataType: 'json',
        data: {
            content : content,
            shareFrom : shareFrom
        },
        beforeSend: function (xhr) {
            xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
        },
        success: function (data) {
            console.log(data);
            $("#previewPostShareModal").modal("hide");
        }
    });
}


