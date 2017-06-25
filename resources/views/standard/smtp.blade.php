<div style="padding-left: 1em;padding-right: 1em">

    <h4 style="text-align: center">{{translate('smtp_top_text')}}</h4>

    <form method="post" class="form-horizontal ajax_request" data-url="settings/smtp" style="width: calc(100% - 1em);">
        <div class="form-group " style="margin-bottom: 1em">
            <label for="host" class="col-md-4 control-label">{{ translate('smtp_host') }}</label>

            <div class="col-md-6">
                <input id="host" type="text" class="form-control" name="host" must="1" placeholder="{{ translate('smtp_host') }}" required autofocus>
            </div>
        </div>

        <div class="form-group " style="margin-bottom: 1em">
            <label for="port" class="col-md-4 control-label">{{ translate('smtp_port') }}</label>

            <div class="col-md-6">
                <input id="port" type="number" class="form-control" name="port"  must="1" placeholder="{{ translate('smtp_port') }}" required>
            </div>
        </div>

        <div class="form-group " style="margin-bottom: 1em">
            <label for="con" class="col-md-4 control-label">{{ translate('smtp_connection') }}</label>

            <div class="col-md-6">
                <input id="con" type="text" class="form-control" name="con"  must="1" placeholder="{{ translate('smtp_connection') }}" required>
            </div>
        </div>

        <div class="form-group " style="margin-bottom: 1em">
            <label for="user" class="col-md-4 control-label">{{ translate('smtp_user') }}</label>

            <div class="col-md-6">
                <input id="user" type="text" class="form-control" name="user"  must="1" placeholder="{{ translate('smtp_user') }}" required>
            </div>
        </div>

        <div class="form-group ">
            <label for="password" class="col-md-4 control-label">{{ translate('smtp_password') }}</label>

            <div class="col-md-6">
                <input id="password" type="password" class="form-control" name="password" placeholder="{{ translate('smtp_password') }}" required>
            </div>
        </div>
        <div class="col-md-12 form-group" style="text-align: center">
            <button type="submit" class="btn btn-primary">
                {{ translate('next') }}
            </button>
        </div>
    </form>
</div>