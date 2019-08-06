$(document).ready(function() {
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
                    console.log(data);
                    
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



