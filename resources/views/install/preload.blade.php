@if(!isAjax()&&isset($_SESSION['user']))
    @include("template.top_bar")
    @include("template.left_bar")
@endif
<div class="wrapper_preload">
    <div id="preloader_2">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
</div>