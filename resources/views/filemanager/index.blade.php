<section class="panel">
    <header class="panel-heading">
        {{$title}}
    </header>
    <div class="panel-body">
        <div class="col-xs-12 col-sm-8 col-md-10">
            <form action="#" onsubmit="APPLICATION.APPS.FileManager.search()"  method="post" id="searchForm" style="display: inline;">
                <div class="form-group " style="margin-bottom: 1em">
                    <input id="query" type="text" class="form-control" name="query" must="1" placeholder="{{ translate('search') }}" style="background: url({{url('assets/images/search-icon.png')}}) no-repeat 10px 8px;padding: 0 5px 0 35px;">
                </div>
            </form>
            <form action="{{url('module/filemanager/upload')}}" method="post" id="UForm" enctype="multipart/form-data" style="display: inline;">
               <div class="fileupload fileupload-new" data-provides="fileupload" style="width: auto;    display: inline;">
                                                <span class="btn btn-white btn-file">
                                                <span class="fileupload-new"><i class="fa fa-upload" style="color:#ff6c60"></i> {{translate('upload_file')}}</span>
                                                <input type="file" class="default" name="file" onchange="$('#UForm').submit()">
                                                </span>
                        <span class="fileupload-preview" style="margin-left:5px;"></span>
                        <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
               </div>

                <input id="path" name="path" value="<?php echo urldecode($path); ?>" type="hidden">
                <input name="_token" value="{{csrf_token()}}" type="hidden">
            </form>

            <font id="createfolder" style="margin-left:1em">
                <button data-toggle="button" class="btn btn-white active" aria-pressed="true" onclick="APPLICATION.APPS.FileManager.CreateFolder('<?php echo urldecode($path); ?>')">
                    <i class="fa fa-folder" style="color:#58c9f3"></i> {{translate('create_folder')}}  </button>
            </font>
            <div id="DivFileManager" class="table-responsive" tabindex="1" style="outline: none;    overflow: auto;margin-top: 1em">
                @include('filemanager.files')
            </div>
        </div>
        <div class="col-xs-12 col-sm-4 col-md-2" id="fileInfo">
        </div>

    </div>
</section>