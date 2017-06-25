function FileManager() {
    this.path = '.';
    this.uploading = 0;
    this.startModule('.');
}

FileManager.prototype = {
    startModule: function (path) {
        var self = this;
        self.path = path;
        this.uploadFile();
    },
    uploadFile: function(){
        var self = this;

        $('#UForm').on('submit', function(e){
            e.preventDefault();
            var $that = $(this),
                formData = new FormData($that.get(0));
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
    setPath:function (path) {
        var self = this;
        self.path = path;
    },
    CreateFolder: function (path) {
        var Form = '<form action="#" method="post" id="CreateFld" onsubmit="APPLICATION.APPS.FileManager.CreateFld(';
        Form+="'"+path+"')";
        Form+='" style="display: inline"><input type="text" id="newfolder" class="form-control" onchange="APPLICATION.APPS.FileManager.CreateFld(';
        Form+="'"+path+"')";
        Form+='"/></form>';
        $('#createfolder').html(Form);

    },
    CreateFld: function (path) {
        event.preventDefault();
        if ($('#newfolder').val().length==0) return false;
        APPLICATION.sendRequest({controller:"module/filemanager/folder",post:JSON.stringify({folder:$('#newfolder').val(),path:path})});
        return false;
    },
    fileInfo: function (name) {
        event.preventDefault();
        var self = this;
        APPLICATION.sendRequest({controller:"module/filemanager/info",post:JSON.stringify({file:name,path:self.path})});
    }
};

APPLICATION.APPS.FileManager  = new FileManager();