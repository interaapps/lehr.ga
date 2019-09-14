<div id="filepickerbackground"></div>
<div id="filepicker">
    <div id="filepickertoolbar">
    <a id="closefilepickertoolbar" class="waves-effect"><i class="material-icons">close</i></a>
    <div id="filepickertoolbarToolbar">
        <div id="filepickerscreen_upload" class="waves-effect filepickertoolbarToolbarSelected">
            <i class="material-icons">file_upload</i>
            Upload
        </div>

        <div id="filepickerscreen_myfiles" class="waves-effect">
            <i class="material-icons-outlined">cloud</i>
            My Files
        </div>
    </div>
    
    <div id="filepickerpage_upload">
        <input style="display: none" id="filepickeruploadinput" type="file">
        <div id="filepickeruploadbutton" class="waves-effect">
            <i class="material-icons">file_upload</i>
            <span>Upload</span>
        </div>

        <br><br><img id="filepickeruploadpreview" src="" width="30%" />
    </div>

    <div id="filepickerpage_myfiles">
        <div id="filepickermyfiles"></div>
    </div>

    <div id="filepickerbottomtoolbar">
        <a id="filepickerselectbutton" class="waves-effect waves-light">Choose</a>
    </div>
</div>
</div>

<script src="/assets/js/filepicker.js"></script>
<link rel="stylesheet" href="/assets/css/filepicker.css">