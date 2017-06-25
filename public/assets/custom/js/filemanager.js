function FileManager() {
    this.path = '.';
    this.uploading = 0;
    this.folder = '';
    this.startModule('.');
    this.setHeight();
}

FileManager.prototype = {
    setHeight: function () {
        var html = parseInt(screen.height);
        if (html<768) return ;
        var top = parseInt($('#main-content').offset().top);
        var height = html - top - 350;
        $('#DivFileManager').css('height',height+'px');

    },
    startModule: function (path) {
        var self = this;
        self.path = path;
        this.uploadFile();
    },
    search: function () {
        event.preventDefault();
        APPLICATION.sendRequest({controller:"module/filemanager/search",post:JSON.stringify({q:$('#query').val(),path:$('#path').val()})})
    },
    SaveRenamed: function () {
        event.preventDefault();
        APPLICATION.sendRequest({controller:"module/filemanager/rename",post:JSON.stringify({old:$('#oldname').val(),q:$('#Rename').val(),path:$('#path').val()})})
    },
    Rename: function()
    {
        Title = $('#fileInfo h3').html();
        $('#fileInfo h3').html('<form action="#" onsubmit="APPLICATION.APPS.FileManager.SaveRenamed()"  method="post" id="renameForm" style="display: inline;">        <input id="Rename" type="text" class="form-control" name="Rename" must="1"  value="'+Title+'"> <input type="hidden" id="oldname" value="'+Title+'"> </form>');
        $('#Rename').focus();
    },
    uploadFile: function(){
        var self = this;

        $('#UForm').on('submit', function(e){
            e.preventDefault();
            var $that = $(this),
                formData = new FormData($that.get(0));
            APPLICATION.showNotification({
                type:"danger",
                html:LANG.uploading
            });
            $('#UForm')[0].reset();
            $.ajax({
                url: $that.attr('action'),
                type: $that.attr('method'),
                contentType: false, // важно - убираем форматирование данных по умолчанию
                processData: false, // важно - убираем преобразование строк по умолчанию
                data: formData,
                async: true,
                dataType: "json",
                success: function(json){
                    APPLICATION.responseJob(json);
                }
            });
        });

    },
    CopyFile: function () {
        var clipboard = new Clipboard('#CopyBtn', {
            text: function() {
                APPLICATION.showNotification({type:"success","text":LANG.link_copied});
                return $('#CopyBtn').attr('data-text');
            }
        });
    },
    setPath:function (path) {
        var self = this;
        self.path = path;
    },
    CreateFolder: function (path) {
        this.folder = $('#createfolder').html();
        var Form = '<form action="#" method="post" id="CreateFld" onsubmit="APPLICATION.APPS.FileManager.CreateFld(';
        Form+="'"+path+"')";
        Form+='" style="width: auto;    display: inline;"><input type="text" id="newfolder" style="width:auto;   display: inline;" class="form-control" onchange="APPLICATION.APPS.FileManager.CreateFld(';
        Form+="'"+path+"')";
        Form+='"/></form>';
        $('#createfolder').html(Form);

    },
    CreateFld: function (path) {
        var self = this;
        event.preventDefault();
        if ($('#newfolder').val().length==0) return false;
        APPLICATION.sendRequest({controller:"module/filemanager/folder",post:JSON.stringify({folder:$('#newfolder').val(),path:$('#path').val()})});
        $('#createfolder').html(self.folder);
        return false;
    },
    fileInfo: function (name) {
        event.preventDefault();
        var self = this;
        APPLICATION.sendRequest({controller:"module/filemanager/info",post:JSON.stringify({file:name,path:$('#path').val()})});
        $('body,html').animate({
            scrollTop: $('#fileInfo').offset().top+'px'
        }, 500);
    }
};

APPLICATION.APPS.FileManager  = new FileManager();