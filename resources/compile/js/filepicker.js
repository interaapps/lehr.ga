var filePicker = {
    fileBase: "",
    fileName: "",
    fileOriginalName: "",
    whenSelected: function(file) {},
    whenUploaded: function() {},
    parsedJSON: {},
    selected: false,
    folder: "m",
    openFilepicker: function() {
        $("#filepickerbackground").css("display","block");
        $("#filepicker").css("display","block");
    },
    closeFilepicker: function () {
        $("#filepickerbackground").hide();
        $("#filepicker").hide();
    }
};
function setSelected() {
    if (filePicker.selected !== false)
        $("#filepickerselectbutton").addClass("filepickerselectbuttonselected");
    else
        $("#filepickerselectbutton").removeClass("filepickerselectbuttonselected");
}

function openUploadSection() {
    $(".filepickertoolbarToolbarSelected").removeClass("filepickertoolbarToolbarSelected");
    $("#filepickerscreen_upload").addClass("filepickertoolbarToolbarSelected");

    $("#filepickerpage_upload").show();
    $("#filepickerpage_myfiles").hide();
    filePicker.selected = false;
    setSelected();
}

function openFilesSection() {
    $(".filepickertoolbarToolbarSelected").removeClass("filepickertoolbarToolbarSelected");
    $("#filepickerscreen_myfiles").addClass("filepickertoolbarToolbarSelected");
    
    $("#filepickerpage_upload").hide();
    $("#filepickerpage_myfiles").show();
    filePicker.folder = "m";
    loadFilePickerFolder();
    filePicker.selected = false;
    setSelected();
}

function readFileFilePicker() {
    if (this.files && this.files[0]) {   
        var FR = new FileReader();
        var files = this.files;
        FR.addEventListener("load", function(e) {
            $("#filepickeruploadpreview").attr("src", "");
            if ((e.target.result).includes("data:image/")) 
                $("#filepickeruploadpreview").attr("src", e.target.result);
            
            request = {
                file: e.target.result,
                folder: filePicker.folder
            };
            
            if (files[0]) {
                request.fileName = files[0].name;
                console.log(files[0].name);
            }
            Cajax.post("/fileupload:file", request).then(function(resp) {
                parsedJSONReadFilePicker = JSON.parse(resp.responseText);
                if (parsedJSONReadFilePicker.done) {
                    filePicker.whenUploaded();
                    filePicker.fileName = parsedJSONReadFilePicker.file;
                    filePicker.fileOriginalName = parsedJSONReadFilePicker.name;
                } 
            }).send();
            filePicker.selected = -1;
            setSelected();
            filePicker.fileBase = e.target.result;
        }); 
        FR.readAsDataURL( this.files[0] );
    }
}

function loadFilePickerFolder() {
    console.log("asdf");
$("#filepickermyfiles").html("");
Cajax.post("/folder/"+filePicker.folder).then(function(resp) {
    filePicker.parsedJSON = JSON.parse(resp.responseText);
    console.log(filePicker.parsedJSON);
    if (filePicker.parsedJSON.done) {
            var out = '<div id="classPostsMove" class="grid">';
            for (var obj in filePicker.parsedJSON.data) {
                out += '<div style="width: 100px;" class="filesFile waves-effect" href="'+filePicker.parsedJSON.data[obj].link+'" postid="'+obj+'">';
                if (filePicker.parsedJSON.data[obj].type == "folder")
                    out += '    <i class="material-icons filetypeicon">folder</i>';
                else
                    out += '    <i class="material-icons filetypeicon">insert_drive_file</i>';
                out += '    <a style="font-size: 13px; overflow-wrap: break-word;">'+filePicker.parsedJSON.data[obj].name+'</a>';
                out += '</div>';
            }
            out += "</div>";
            $("#filepickermyfiles").append(out);
            $(".filesFile").click(function(e) {
                //window.location = $(this).attr("href");
                if (filePicker.parsedJSON.data[$(this).attr("postid")].type == "file")
                    if (filePicker.selected != $(this).attr("postid")) {
                        filePicker.selected = $(this).attr("postid");
                        $(".filesFileSelected").removeClass("filesFileSelected");
                        filePicker.fileName = filePicker.parsedJSON.data[$(this).attr("postid")].link;
                        filePicker.fileOriginalName = filePicker.parsedJSON.data[$(this).attr("postid")].name;
                    } else {
                        filePicker.selected = false;
                        filePicker.fileName = "";
                        filePicker.fileOriginalName = "";
                    }
                else {
                    filePicker.folder = filePicker.parsedJSON.data[$(this).attr("postid")].id;
                    loadFilePickerFolder();
                }

                if (filePicker.selected == $(this).attr("postid"))
                    $(this).addClass("filesFileSelected");
                else
                    $(this).removeClass("filesFileSelected");
                setSelected();
            });
    }
    }).send();
    }

$(document).ready(function(){
    $("#filepickerselectbutton").click(function() {
        if (filePicker.selected !== false)
            filePicker.whenSelected(filePicker.fileName);
    });

    

    $("#filepickerscreen_upload").click(openUploadSection);
    $("#filepickerscreen_myfiles").click(openFilesSection);


    filePicker.closeFilepicker();

    $("#filepickerbackground").click(function() {
        filePicker.closeFilepicker();
    });

    $("#closefilepickertoolbar").click(function() {
        filePicker.closeFilepicker();
    });

        $("#filepickeruploadinput").on("change", readFileFilePicker);

        $("#filepickeruploadbutton").click(function() {
            $("#filepickeruploadinput").click();
        });








});