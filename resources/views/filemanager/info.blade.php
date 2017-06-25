<div style="text-align: center"><i class="fa fa-{{$icon}}" aria-hidden="true" style="color: @if($icon=='folder') #FFB300 @else #039BE5 @endif font-size:7em"></i></div>
<h3 style="text-align: center;margin-top: 1em;margin-bottom: 2em; ">{{$name}}</h3>
<p><label style="width:50%">{{translate('size')}}:</label> {{$size}}</p>
<div class="form-inline" style="margin-top: 1em;text-align: center" >
    @if($icon!=='folder')
    <button class="btn btn-info active ajax_request" data-url="module/filemanager/download" data-post="{{data_to_attribute(array('file'=>$file))}}" aria-pressed="true" style="font-size:0.92em;margin-right: 0.16em">
            <i class="fa fa-download" style="color:white"></i> DOWNLOAD
    </button>
   @endif

    <p style="text-align: center"><br>
        <button class="btn btn-primary active" aria-pressed="true" style="font-size:0.92em" id="RenameBtn" onclick="APPLICATION.APPS.FileManager.Rename()">
            <i class="fa fa-pencil-square-o" style="color:white;"></i> RENAME
        </button>
    </p>
    <p style="text-align: center">
        <button class="btn btn-danger active" aria-pressed="true" style="font-size:0.92em" id="CopyBtn" onclick="APPLICATION.APPS.FileManager.CopyFile()" data-text="{{$file}}">
            <i class="fa fa-link" style="color:white;"></i> COPY LINK
        </button>
    </p>
</div>