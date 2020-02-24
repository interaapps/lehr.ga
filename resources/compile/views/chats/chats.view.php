@template(("dash/header", ["title"=>"Messages"]))!

<div id="chat_container">
    <div id="chat_sidebar">
        <div class="chat_user">
            <span class="chat_user_name">Tom Erissonoar</span>
            <span class="chat_user_last_message"><span>You</span> Hello, could you please give me the worksheet?</span>
        </div>
    </div>
    <div id="chat_message_container">
        <div id="chat_message_container_toolbar">
            <span id="chat_message_container_toolbar_username">Tom Erissonoar</span>
        </div>
        <div id="chat_message_container_messages">
            <div class="chat_message">
                <p class="chat_message_contents">Hello, could you please give me the worksheet?</p>
                <span class="chat_message_sent_timestamp">18:00 1.1.1111</span>
            </div>
        </div>
        <div id="chat_message_container_bottom_bar">
            <a id="chat_message_container_attach">attach_file</a>
            <input type="text" id="chat_message_container_input" placeholder="Message">
            <a id="chat_message_container_send">send</a>
        </div>
    </div>
</div>

<style>

html, body, #main, #navbar_spacer {
    height: calc(100% - 24px);
}

#navbar_spacer {
    padding-top: 65px !important;
}

#chat_container {
    display: flex;
    height: 100%;
}

#chat_sidebar {
    width: 200px;
    background: #00000022;
    height: 100%;
    display: block;
}

#chat_message_container_toolbar {
    height: 50px;
    background: #00000022;
    width: 100%;
    padding-left: 7px;

    box-sizing: border-box;
}

#chat_message_container_toolbar_username {
    line-height: 50px;
    font-size: 20px;
}

#chat_message_container {
    padding-bottom: 55px;
    width: 100%;
}

#chat_message_container_bottom_bar {
    height: 50px;
    background: #00000022;
    line-height: 50px;
    vertical-align: middle;
    
    position: absolute;
    bottom: 0px;
    width: 100%;
}

#chat_message_container_input {
    height: 50px;
    vertical-align: top;
    background: #00000000;
    border: none;
    width: calc(100% - 100px);
    font-size: 18px;
}

#chat_message_container_send {
    font-family: "Material Icons Outlined";
    color: #4566ee;
    font-size: 30px;
    padding: 6px;
    cursor: pointer;
}

#chat_message_container_send:hover {
    background: #00000022;
    border-radius: 40px;
}

#chat_message_container_attach {
    font-family: "Material Icons Outlined";
    color: #4566ee;
    font-size: 30px;
    padding: 6px;
    cursor: pointer;
    color: #323232
}

#chat_message_container_attach:hover {
    background: #00000022;
    border-radius: 40px;
}

#chat_message_container_messages {
    padding: 10px;
    border-box: box-sizing;
}

.chat_message {
    background: #4287f5;
    color: #FFFFFF;
    padding: 4px 7px;
    box-sizing: border-box;
    border-radius: 4px;
}

.chat_message_contents {

}

.chat_message_sent_timestamp {
    color: #FFFFFF55;
    font-size: 13px;
    text-align: right;
    display: block;
    width: 100%;
}

.chat_user {
    background: #00000011;
    padding: 4px;
    border-box: box-sizing;
}

.chat_user_name {
    display: block;
}

.chat_user_last_message {
    font-size: 10px;
    height: 15px;
    display: block;
    overflow: hidden;
}

</style>


@template(("dash/footer"))!