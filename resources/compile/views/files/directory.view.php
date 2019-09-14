@template(("dash/header", ["title"=>"Directory"]))!

@view(("tools/filepicker"))!
<div id="toolbar">
    <a id="openfile" class="waves-effect files-showifoneselected">Open</a>
    <a id="openmoremenu" style="right: 10px;" class="waves-effect menuicon"><i class="material-icons">more_vert</i></a>
    <div id="moremenu">
        
        <a onclick="$('#newfile').click()" class="waves-effect files-showifnoneselected"><i class="material-icons">file_upload</i>Upload File</a>

        <hr class="files-showifnoneselected">
        <!--<a onclick="$('#newfile').click()" class="waves-effect files-showifnoneselected"><i class="material-icons">add</i>New File</a>-->
        <a onclick="newFolderAlert.open()" class="waves-effect files-showifnoneselected"><i class="material-icons">create_new_folder</i>New Folder</a>
        
        
        <a onclick="$('#openfile').click()" class="waves-effect files-showifoneselected"><i class="material-icons">open_in_new</i>Open</a>
        <a onclick="renameAlert.open()" class="waves-effect files-showifoneselected"><i class="material-icons">edit</i><span>Rename</span></a>
        <a id="downloadFile" class="waves-effect files-showifoneselected"><i class="material-icons">file_download</i>Download</a>
        <a class="waves-effect files-showifoneselected"><i class="material-icons">delete</i><span>Delete</span></a>
    </div>
</div>
<a id="newfile" class="flatButton2 waves-effect waves-light"><i class="material-icons">add</i><span>Add</span></a>
<div class="contents" style="margin-right: 0px;" id="classPosts"></div>
<style>
#toolbar {
    width: calc(100% + 32.7px);
    padding: 5px;
    padding-bottom: 39px;
    top: -15px;
    box-sizing: border-box;
    margin-left: -15.9px;
    border-bottom: #00000022 solid 1.3px;
}

#toolbar a {
    padding: 6px 16px;
    position: absolute;
    border-radius: 5px;
}

#toolbar .menuicon {
    border-radius: 100px;
    padding: 5px;
    font-size: 20px;
    height: 25px;
}

#moremenu {
    width: 200px;
    position: absolute;
    top: 46px;
    background: #FFFFFF;
    box-shadow: 0 2px 1px -1px rgba(0,0,0,0.2),0 1px 1px 0 rgba(0,0,0,0.141),0 1px 3px 0 rgba(0,0,0,0.122);
    border-radius: 7px;
    right: 20px;
    padding-top: 10px;
    padding-bottom: 10px;
    z-index: 1000;
}

#moremenu hr {
    border: #00000022 solid 0.1px;
    margin: 5px 2px;
}

#moremenu a {
    padding: 5px 15px;
    width: 200px;
    box-sizing: border-box;
    border-radius: 0px;
    position: relative;
    display: block;
    font-size: 16px;
    vertical-align: middle;
}

#moremenu a i {
    font-size: 16px;
    vertical-align: middle;
    margin-right: 5px;
    padding-bottom: 3px;
}

#moremenu a:hover {
    background: #00000011;
}

</style>
<script>
    var drag = false;
    var dragName = false;
    var selected = [];
    var lastSelected;
    var shifting = false;
    var lastPosition = {
        x: 0,
        y: 0
    };
    var doubleclick = -1;
    var moreMenuOpened = false;

    $(document).on('keyup keydown', function(e){
        shifting = e.shiftKey;
    });

    var newFolderAlert = new Alert({
        canexit: true,
        closebtn: true,
        title: "Add new Folder"
    });

    newFolderAlert.addHtml('<input id="newFolderInput" type="text" class="flatInput">');

    newFolderAlert.addButton("Add Folder", function() {
        Cajax.post("/new/folder", {
            name: $("#newFolderInput").val(),
            folder: "{{$folder}}"
        }).then(function(resp) {
            loadFolder();
            newFolderAlert.close();
        }).send();
    }, "add");

    $("#newfile").click(function() {
        filePicker.openFilepicker();
        filePicker.folder = "{{$folder}}";
        $("#filepickertoolbarToolbar").hide();
        $("#filepickerbottomtoolbar").hide();
        filePicker.whenUploaded = function(file) {
            filePicker.closeFilepicker();
            loadFolder();
        }; 
    });

    $("#downloadFile").click(function() {
        fetch(parsedJSON.data[lastSelected].link).then(function (resp) {
            resp.blob();
        }).then(function (blob) {
            a = document.createElement('a');
            a.style.display = 'none';
            a.href = window.URL.createObjectURL(blob);
            a.download = parsedJSON.data[lastSelected].name;
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
        }).catch(function () {
            alert("Couln't download!");
        });
    });

    var renameAlert = new Alert({
        canexit: true,
        closebtn: true,
        title: "Rename"
    });

    renameAlert.addHtml('<input id="renameInput" type="text" class="flatInput">');

    renameAlert.addButton("Rename", function() {
        Cajax.post("/", {
            file: $("#renameInput").val(),
            type: "folder",
            name: ""
        }).then(function(resp) {
            loadFolder();
            renameAlert.close();
        }).send();
    }, "edit");

    $("#newfile").click(function() {
        filePicker.openFilepicker();
        filePicker.folder = "{{$folder}}";
        $("#filepickertoolbarToolbar").hide();
        $("#filepickerbottomtoolbar").hide();
        filePicker.whenUploaded = function(file) {
            filePicker.closeFilepicker();
            loadFolder();
        }; 
    });

    $("#moremenu").hide();
    
    $(window).click(function() {
        $("#moremenu").hide();
        moreMenuOpened = false;
        selected = [];
        $(".classPost").css({
            background: "none"
        });
        updateToolbar();
    });

    $("#openmoremenu").click(function(e) {
        if (moreMenuOpened) {
            $("#moremenu").hide();
            moreMenuOpened = false;
        } else {
            $("#moremenu").show();
            moreMenuOpened = true;
        }
        $("#moremenu").css({
            top: "46px",
            right: "20px",
            left: ""
        });
        e.stopPropagation();
    });

    $("#openfile").click(function(){
        if (parsedJSON.data[lastSelected].type=="folder") 
            window.location = parsedJSON.data[lastSelected].link;
        else if (window.open(parsedJSON.data[lastSelected].link) == null)
            window.location = parsedJSON.data[lastSelected].link;
    });

    function updateToolbar() {
        selectedLenght = 0;
        for (i in selected) {
            if (selected[i]==true) { 
                selectedLenght++;
                lastSelected = i;
            }
        }
        
        if (selectedLenght == 0) {
            $(".files-showifoneselected").hide();
            $(".files-showifnoneselected").show();
        } else if (selectedLenght == 1) {
            $(".files-showifoneselected").show();
            $(".files-showifnoneselected").hide();
        } else {
            $(".files-showifoneselected").hide();
            $(".files-showifnoneselected").hide();
        }
    }

    updateToolbar();

    function loadFolder() {
        $("#classPosts").html("");
        Cajax.post("/folder/{{$folder}}").then(function(resp) {
            parsedJSON = JSON.parse(resp.responseText);
            if (parsedJSON.done) {
                    var out = '<div id="classPostsMove" class="grid">';
                    for (var obj in parsedJSON.data) {
                        out += '<div style="width: 120px;" class="classPost waves-effect" href="'+parsedJSON.data[obj].link+'" postid="'+obj+'">';
                        if (parsedJSON.data[obj].type == "folder")
                            out += '    <i class="material-icons filetypeicon">folder</i>';
                        else
                            out += '    <i class="material-icons filetypeicon">insert_drive_file</i>';
                        out += '    <a style="font-size: 12px;overflow-wrap: break-word;">'+parsedJSON.data[obj].name+'</a>';
                        out += '</div>';
                    }
                    out += "</div>";
                    $("#classPosts").append(out);
                    $(".classPost").click(function(e) {
                        $("#moremenu").hide();
                        moreMenuOpened = false;
                        if (selected[$(this).attr("postid")] == null || selected[$(this).attr("postid")] == false) {     
                            if (!shifting) {
                                selected = [];
                                $(".classPost").css({
                                    background: "none"
                                });
                                if (doubleclick == $(this).attr("postid")) {
                                    if (parsedJSON.data[$(this).attr("postid")].type == "folder")
                                        window.location = parsedJSON.data[$(this).attr("postid")].link;
                                    else if (window.open(parsedJSON.data[$(this).attr("postid")].link) == null)
                                        window.location = parsedJSON.data[$(this).attr("postid")].link;
                                }

                                setTimeout(() => {
                                    doubleclick = -1;
                                    console.log("d");
                                }, 1200);
                                doubleclick = $(this).attr("postid");
                            }
                            selected[$(this).attr("postid")] = true;
                        } else
                            selected[$(this).attr("postid")] = false;
                        
                        if (selected[$(this).attr("postid")] == true)
                            $(this).css({
                                background: "#4566ee44"
                            });
                        else
                            $(this).css({
                                background: "none"
                            });
                        updateToolbar();
                        e.stopPropagation();
                    });

                    $(".classPost").on("contextmenu", function(e) {
                        $(this).click();
                        $("#moremenu").css({
                            top: e.originalEvent.clientY-60,
                            right: "",
                            left: e.originalEvent.clientX-270
                        });
                        $("#moremenu").show();
                        moreMenuOpened = true;
                        e.preventDefault();
                        return false;
                    });

                    $("#classPosts").on("contextmenu", function(e) {
                        $(this).click();
                        $("#moremenu").css({
                            top: e.originalEvent.clientY-60,
                            right: "",
                            left: e.originalEvent.clientX-270
                        });
                        $("#moremenu").show();
                        moreMenuOpened = true;
                        e.preventDefault();
                        return false;
                    });

                    $(".classPost").on("mousedown", function(e) {
                        dragName = $(this).attr("postid");
                        drag = $(this);
                        lastPosition.y = e.originalEvent.clientY;
                        lastPosition.x = e.originalEvent.clientX;
                    });

                    $("html").on("mouseup", function(e) {
                        if (drag !== false)
                            drag.css({
                                position: "relative",
                                top: "0",
                                left: "0"
                            });
                        drag = false;
                        dragName = false;
                    });

                    $("[moveto]").on("mouseup", function(e) {
                        console.log(parsedJSON.data[drag.attr("postid")].type);
                        if (parsedJSON.data[drag.attr("postid")].type == "file")
                            Cajax.post("/move/file", {
                                folder: $(this).attr("moveto"),
                                file: parsedJSON.data[drag.attr("postid")].id
                            }).then(function(resp){
                                loadFolder();
                            }).send();
                        else if (parsedJSON.data[$(drag).attr("postid")].type == "folder")
                            Cajax.post("/move/folder", {
                                folder: $(this).attr("moveto"),
                                file: parsedJSON.data[drag.attr("postid")].id
                            }).then(function(resp){
                                loadFolder();
                            }).send();
                    });

                    $(".classPost").on("mouseup", function(e) {
                        if(dragName != $(this).attr("postid")) {
                            if (parsedJSON.data[$(this).attr("postid")].type == "folder") {
                                if (parsedJSON.data[drag.attr("postid")].type == "file")
                                    Cajax.post("/move/file", {
                                        folder: parsedJSON.data[$(this).attr("postid")].id,
                                        file: parsedJSON.data[drag.attr("postid")].id
                                    }).then(function(resp){
                                        loadFolder();
                                    }).send();
                                else if (parsedJSON.data[$(drag).attr("postid")].type == "folder")
                                    Cajax.post("/move/folder", {
                                        folder: parsedJSON.data[$(this).attr("postid")].id,
                                        file: parsedJSON.data[drag.attr("postid")].id
                                    }).then(function(resp){
                                        loadFolder();
                                    }).send();
                            }
                        }
                    });
                    $(".classPost").on("mousemove", function(e) {
                        if (drag === false) {} else {
                        if (parsedJSON.data[$(this).attr("postid")].type == "folder")
                            $(this).css({
                                background: "#656565"
                            });
                        }
                    });

                    $("html").on("mousemove", function(e) {
                        if (drag === false) {} else {
                            if (lastPosition.x > e.originalEvent.clientX+40 ||
                                lastPosition.y > e.originalEvent.clientY+40 ||
                                lastPosition.x < e.originalEvent.clientX-40 ||
                                lastPosition.y < e.originalEvent.clientY-40)
                            drag.css({
                                position: "fixed",
                                zIndex: 100,
                                top: e.originalEvent.clientY,
                                left: e.originalEvent.clientX
                            });
                        }
                    });
                }
        }).send();
    };
    loadFolder();
</script>

<style>
.grid {
  display: grid;
  grid-gap: 10px;
  grid-template-columns: repeat(auto-fill, 120px);
}

.grid div {
    height: 120px;
}

.filetypeicon {
    font-size: 30px;
    display: block;
}

</style>

@template(("dash/footer"))!