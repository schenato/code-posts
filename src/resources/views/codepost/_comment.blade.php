<div class="card">
    <div class="card-body">
        <hr>
        <h3 class="text-center p-3 mb-2 bg-dark text-white">Want to do a comment?</h3>
        <hr>
        
        <div class="widget-area no-padding blank">
            <div class="status-upload">
                {!! Form::open(['route' => 'admin.comments.store', 'method' => 'post']) !!}
                {!! Form::hidden('post_id', $post->id) !!}
                {!! Form::textarea('content', null, ['id' => 'comment', 'placeholder' => 'Yesss I want']) !!}
                {!! Form::submit('Comment', ['class' => 'btn btn-success green']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
            
        @foreach ($post->comments as $comment)
        <div class='container'>
            <div class="media comment-box">
                <div class="media-left">
                    <a href="#">
                        <img class="img-responsive user-photo" src="https://ssl.gstatic.com/accounts/ui/avatar_2x.png">
                    </a>
                </div>
                <div class="media-body">
                    <h4 class="media-heading">{{ $comment->user->name }}</h4>
                    <p>{{ $comment->content }}</p>

                </div>
            </div>
        </div>
        @endforeach
</div>

@section('stylesheet')
<style>
    /* CSS Test begin */
    .comment-box {
        margin-top: 30px !important;
    }
    /* CSS Test end */

    .comment-box img {
        width: 50px;
        height: 50px;
    }
    .comment-box .media-left {
        padding-right: 10px;
        width: 65px;
    }
    .comment-box .media-body p {
        border: 1px solid #ddd;
        padding: 10px;
    }
    .comment-box .media-body .media p {
        margin-bottom: 0;
    }
    .comment-box .media-heading {
        background-color: #f5f5f5;
        border: 1px solid #ddd;
        padding: 7px 10px;
        position: relative;
        margin-bottom: -1px;
    }
    .comment-box .media-heading:before {
        content: "";
        width: 12px;
        height: 12px;
        background-color: #f5f5f5;
        border: 1px solid #ddd;
        border-width: 1px 0 0 1px;
        -webkit-transform: rotate(-45deg);
        transform: rotate(-45deg);
        position: absolute;
        top: 10px;
        left: -6px;
    }
    body{ background: #fafafa;}
    .widget-area.blank {
        background: none repeat scroll 0 0 rgba(0, 0, 0, 0);
        -webkit-box-shadow: none;
        -moz-box-shadow: none;
        -ms-box-shadow: none;
        -o-box-shadow: none;
        box-shadow: none;
    }
    body .no-padding {
        padding: 0;
    }
    .widget-area {
        background-color: #fff;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -ms-border-radius: 4px;
        -o-border-radius: 4px;
        border-radius: 4px;
        -webkit-box-shadow: 0 0 16px rgba(0, 0, 0, 0.05);
        -moz-box-shadow: 0 0 16px rgba(0, 0, 0, 0.05);
        -ms-box-shadow: 0 0 16px rgba(0, 0, 0, 0.05);
        -o-box-shadow: 0 0 16px rgba(0, 0, 0, 0.05);
        box-shadow: 0 0 16px rgba(0, 0, 0, 0.05);
        float: left;
        margin-top: 30px;
        padding: 25px 30px;
        position: relative;
        width: 100%;
    }
    .status-upload {
        background: none repeat scroll 0 0 #f5f5f5;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -ms-border-radius: 4px;
        -o-border-radius: 4px;
        border-radius: 4px;
        float: left;
        width: 100%;
    }
    .status-upload form {
        float: left;
        width: 100%;
    }
    .status-upload form textarea {
        background: none repeat scroll 0 0 #fff;
        border: medium none;
        -webkit-border-radius: 4px 4px 0 0;
        -moz-border-radius: 4px 4px 0 0;
        -ms-border-radius: 4px 4px 0 0;
        -o-border-radius: 4px 4px 0 0;
        border-radius: 4px 4px 0 0;
        color: #777777;
        float: left;
        font-family: Lato;
        font-size: 14px;
        height: 142px;
        letter-spacing: 0.3px;
        padding: 20px;
        width: 100%;
        resize:vertical;
        outline:none;
        border: 1px solid #F2F2F2;
    }

    .status-upload ul {
        float: left;
        list-style: none outside none;
        margin: 0;
        padding: 0 0 0 15px;
        width: auto;
    }
    .status-upload ul > li {
        float: left;
    }
    .status-upload ul > li > a {
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -ms-border-radius: 4px;
        -o-border-radius: 4px;
        border-radius: 4px;
        color: #777777;
        float: left;
        font-size: 14px;
        height: 30px;
        line-height: 30px;
        margin: 10px 0 10px 10px;
        text-align: center;
        -webkit-transition: all 0.4s ease 0s;
        -moz-transition: all 0.4s ease 0s;
        -ms-transition: all 0.4s ease 0s;
        -o-transition: all 0.4s ease 0s;
        transition: all 0.4s ease 0s;
        width: 30px;
        cursor: pointer;
    }
    .status-upload ul > li > a:hover {
        background: none repeat scroll 0 0 #606060;
        color: #fff;
    }
    #comment{
        background-color: activecaption;
        color: white;
        font-size: 20px;
    }
    .status-upload form input {
        border: medium none;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -ms-border-radius: 4px;
        -o-border-radius: 4px;
        border-radius: 4px;
        color: #fff;
        float: right;
        font-family: Lato;
        font-size: 14px;
        letter-spacing: 0.3px;
        margin-right: 9px;
        margin-top: 9px;
        padding: 6px 15px;
    }
    .dropdown > a > span.green:before {
        border-left-color: #2dcb73;
    }
    .status-upload form input > i {
        margin-right: 7px;
    }
</style>
@endsection