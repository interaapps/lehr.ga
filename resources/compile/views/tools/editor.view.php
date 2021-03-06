@view(("tools/filepicker"))!

<div id="lehrgaeditorouter">
    <div class="toolbar">
    <a href="#" data-command="undo"><i class="material-icons">arrow_back</i></a>
    <a href="#" data-command="redo"><i class="material-icons">arrow_forward</i></a>
    <div style="padding-bottom: 0px;" class="fore-wrapper"><i class="material-icons" style="color:#C96;">format_color_text</i>
        <div class="fore-palette">
        </div>
    </div>
    <div style="padding-bottom: 0px;" class="back-wrapper"><i class="material-icons" style="color:#C96;">format_color_fill</i>
        <div class="back-palette">
        </div>
    </div>

    <a href="#" data-command="bold"><i class="material-icons">format_bold</i></a>
    <a href="#" data-command="italic"><i class="material-icons">format_italic</i></a>
    <a href="#" data-command="underline"><i class="material-icons">format_underlined</i></a>
    <a href="#" data-command="strikeThrough"><i class="material-icons">format_strikethrough</i></a>
    <a href="#" data-command="justifyLeft"><i class="material-icons">format_align_left</i></a>
    <a href="#" data-command="justifyCenter"><i class="material-icons">format_align_center</i></a>
    <a href="#" data-command="justifyRight"><i class="material-icons">format_align_right</i></a>
    <a href="#" data-command="justifyFull"><i class="material-icons">format_align_justify</i></a>
    <a href="#" data-command="indent"><i class="material-icons">format_indent_increase</i></a>
    <a href="#" data-command="outdent"><i class="material-icons">format_indent_decrease</i></a>

    <a href="#" data-command="insertUnorderedList"><i class="material-icons">format_list_bulleted</i></a>
    <a href="#" data-command="insertOrderedList"><i class="material-icons">format_list_numbered</i></a>
    <a href="#" data-command="createlink"><i class="material-icons">insert_link</i></a>
    <a href="#" data-command="unlink"><i style="color: #EE3333" class="material-icons">insert_link</i></a>
    <a id="imageUploadButton"><i class="material-icons">image</i></a>
    <a data-command="insertVideo"><i class="material-icons">featured_video</i></a>
    <a id="fileUploadButton"><i class="material-icons">attach_file</i></a>

    <a href="#" data-command="h1">H1</a>
    <a href="#" data-command="h2">H2</a>
    <a href="#" data-command="h3">H3</a>
    <a href="#" data-command="h4">H4</a>
    <a href="#" data-command="lehrgaeditor_quote">Quote</a>
    <a href="#" data-command="p">P</a>

    <div style="display: none" id="forminputs">
        <a data-command="input">Input field</a>
        <a data-command="textarea">Textarea field</a>
    </div>


</div>
<div id="lehrgaeditor" contenteditable>
    <p>Try making some changes here. Add your own text or maybe an image.</p>
</div>
</div>
<div id="lehrgaeditor_a"></div>
<textarea name="lehrgaeditor_data" style="display: none;" id="text_lehrgaeditor"></textarea>

<style>

    #lehrgaeditor:focus .toolbar {
        background: #434343;
    }

    a {
        cursor: pointer;
    }

    #lehrgaeditor a:link, #lehrgaeditor a:visited {
        color: #2068ff;
    }


    #lehrgaeditorouter {
        border: 2px solid #EEEEEE;
        border-radius: 7px;
    }

    #lehrgaeditor {
        /* box-shadow: 0 0 2px #CCC; */
        min-height: 150px;
        overflow: auto;
        padding: 0px 30px;
        margin-top: 20px;
        resize: vertical;
        outline: none;
    }

    .toolbar {
        text-align: center;
        background: #FFF;
        padding: 13px;
        border-bottom: 2px solid #EEEEEE;
    }

    .toolbar a,
    .fore-wrapper,
    .back-wrapper {
        color: black;
        padding: 5px;
        min-width: 1.5em;
        margin: -2px;
        margin-top: 10px;
        display: inline-block;
        text-decoration: none;
        line-height: 27px;
        border-radius: 10px;
    }

    .toolbar a:hover,
    .fore-wrapper:hover,
    .back-wrapper:hover {
        background: #f2f2f2;
        border-color: #8c8c8c;
    }



    a.palette-item {
        height: 25px;
        border-radius: 1000px;
        margin: 2px;
        width: 25px;
        border: 1px solid #EEE;
    }

    a.palette-item:hover {
        border: 1px solid #DDD;
    }

    .fore-palette,
    .back-palette {
        display: none;

    }

    .fore-wrapper,
    .back-wrapper {
        display: inline-block;
        cursor: pointer;
    }

    .fore-wrapper:hover .fore-palette,
    .back-wrapper:hover .back-palette {
        display: block;
        float: left;
        position: absolute;
        padding: 3px;
        width: 160px;
        background: #FFF;
        border: 1px solid #DDD;
        box-shadow: 0 0 3px #CCC;
        min-height: 70px;
        border-radius: 5px;
        z-index: 4;
    }

    .fore-palette a,
    .back-palette a {
        background: #FFFFFF;
        margin-bottom: 2px;
    }

    .lehrgaeditor_quote::before {
        height: 100%;
        width: 10px;
        background: #212121;
    }
</style>
<script>

    

    var colorPalette = [
                    'transparent',
                    '#000000',
                    '#FF9966',
                    '#6699FF',
                    '#99FF66',
                    '#CC0000',
                    '#00CC00',
                    '#0000CC',
                    '#333333',
                    '#0066FF',
                    '#FFFFFF'
    ];

    var forePalette = $('.fore-palette');
    var backPalette = $('.back-palette');
    var lehrgaeditor = $("#lehrgaeditor");

    $(document).ready(function() {
        $("#imageUploadButton").click(function () {
            //$("#imageUpload").click();
            filePicker.openFilepicker();
            filePicker.whenSelected = function(file) {
                if (window.getSelection().focusNode.parentNode.parentNode == document.getElementById("lehrgaeditor")) {
                    var selection = window.getSelection().focusNode.parentNode;
                    $(selection).append("<img style=\"max-width: 100%;\" src=\"" + file+ "\" />");
                } else {
                    lehrgaeditor.append("<img style=\"max-width: 100%;\" src=\"" + file + "\" />");
                }
                filePicker.closeFilepicker();
            };
        });

        $("#fileUploadButton").click(function () {
            filePicker.openFilepicker();
            filePicker.whenSelected = function(file) {
                var html = "<a class='downloadButton rippleeffect' target='_blank' download='"+filePicker.fileOriginalName+"' href='"+file+"'><i class='material-icons'>get_app</i><span>"+filePicker.fileOriginalName+"</span></a>";
                if (window.getSelection().focusNode.parentNode.parentNode == document.getElementById("lehrgaeditor")) {
                    var selection = window.getSelection().focusNode.parentNode;
                    $(selection).append(html);
                } else {
                    lehrgaeditor.append(html);
                }
                filePicker.closeFilepicker();
            };
        });

        //$("#imageUpload").on("change", readFile);
    });

    var lehrgaeditor_name = $("#text_lehrgaeditor");

    $("#text_lehrgaeditor").val($("#lehrgaeditor").html());
    document.getElementById("lehrgaeditor").addEventListener("input", function() {
        lehrgaeditor_name.val($("#lehrgaeditor").html());
    }, false);

    function setForeColor(color) {
        document.execCommand("foreColor", false, color);
    }

    function setBackColor(color) {
        document.execCommand("backColor", false, color);
    }
    
    for (var i = 0; i < colorPalette.length; i++) {
        forePalette.append('<a href="#" onclick="setForeColor(\'' + colorPalette[i] + '\');" style="background-color:' + '' + colorPalette[i] + ';" class="palette-item palette-foreground"></a>');
        backPalette.append('<a href="#" onclick="setBackColor(\'' + colorPalette[i] + '\');" style="background-color:' + '' + colorPalette[i] + ';" class="palette-item"></a>');
    }

    $('.toolbar a').click(function(e) {

        var command = $(this).attr('data-command');
        var aa = ["h1", "h2", "h3", "h4", "p"];
        if (aa.includes(command)) {
            document.execCommand('formatBlock', false, command);
        }


        if (command == "lehrgaeditor_quote") {
            document.execCommand('formatBlock', false, "quote");
            var quote = window.getSelection().focusNode.parentNode;
            $(quote).addClass("editor_quote");
        }

        if (command == "input") {
            promptIn = prompt("Name it", "inputField1");
            inputHtml = "<input type='text' name='"+promptIn+"' placeholder='"+promptIn+"'>";
            if (window.getSelection().focusNode.parentNode.parentNode == document.getElementById("lehrgaeditor")) {
                if (name == "") {
                } else {
                    try {
                        var vids = window.getSelection().focusNode.parentNode;
                        $(window.getSelection().focusNode.parentNode).after(inputHtml);
                    } catch {
                        lehrgaeditor.append(inputHtml);
                    }
                }
            } else {
                lehrgaeditor.append(inputHtml);
            }
        }

        if (command == "textarea") {
            promptIn = prompt("Name it", "areaField1");
            inputHtml = "<textarea name='"+promptIn+"' placeholder='"+promptIn+"'></textarea>";
            if (window.getSelection().focusNode.parentNode.parentNode == document.getElementById("lehrgaeditor")) {
                if (name == "") {
                } else {
                    try {
                        var vids = window.getSelection().focusNode.parentNode;
                        $(window.getSelection().focusNode.parentNode).after(inputHtml);
                    } catch {
                        lehrgaeditor.append(inputHtml);
                    }
                }
            } else {
                lehrgaeditor.append(inputHtml);
            }
        }

        if (command == "insertVideo") {
            console.log(window.getSelection().focusNode.parentNode);
            url = "";
            url = prompt('Enter the link here: (Like vrV4t5dvx6I) https://www.youtube.com/watch?v=', 'xcJtL7QggTI');
            if (window.getSelection().focusNode.parentNode.parentNode == document.getElementById("lehrgaeditor")) {
                if (url == "") {
                } else {
                    try {
                        var vids = window.getSelection().focusNode.parentNode;
                        $(vids).after('<iframe width="560" height="315" style="max-width: 100%;" src="https://www.youtube.com/embed/' + url + '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
                    } catch {
                        lehrgaeditor.append('<iframe width="560" height="315" style="max-width: 100%;" src="https://www.youtube.com/embed/' + url + '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
                    }
                }
            }else {
                lehrgaeditor.append('<iframe width="560" height="315" style="max-width: 100%;" src="https://www.youtube.com/embed/' + url + '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
            }
        }
        if (command == 'createlink' || command == 'insertimage' || command == 'insertFile') {
            url = prompt('Enter the link here: ', 'http:\/\/');
            document.execCommand($(this).attr('data-command'), false, url);

        } else
            document.execCommand($(this).attr('data-command'), false, null);
    });
</script>
