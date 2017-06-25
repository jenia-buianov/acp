<table class="table" id="FileManageTable">
    <thead>
    <tr>
        <th style="width: 2em">{{translate('icon')}}</th>
        <th>{{translate('filename')}}</th>
        <th>{{translate('size')}}</th>
    </tr>
    </thead>
    <tbody>
    @for($f=1;$f<count($files);$f++)
        <tr onclick='APPLICATION.APPS.FileManager.fileInfo("{{$files[$f]}}")' style="cursor:pointer">
            <td><i class="fa fa-{{$icon[$f]}} fa-2x" aria-hidden="true" style="color: @if($icon[$f]=='folder') #FFB300; @else #039BE5 @endif"></i></td>
            <td><a href="#" class="ajax_request" data-url="{{$url[$f]}}" data-post="{{$post[$f]}}">{{$files[$f]}}</a></td>
            <td>{{$size[$f]}}</td>
        </tr>
    @endfor
    </tbody>
</table>