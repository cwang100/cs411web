var username;
var chatHeartbeatCount = 0;
var minChatHeartbeat = 1000;
var maxChatHeartbeat = 33000;
var chatHeartbeatTime = minChatHeartbeat;

var newMessages = new Array();
var newMessagesWin = new Array();
var chatBoxes = new Array();

$(document).ready(function() {
    start_chat();
});

function chat_with(chatuser) {
    createChatBox(chatuser);
    $("#chatbox_" + chatuser + " .chatboxtextarea").focus();
}

function createChatBox(chatboxtitle, minimizeChatBox) {
    if ($("#chatbox_" + chatboxtitle).length > 0) {
        if ($("#chatbox_" + chatboxtitle).css('display') == 'none') {
            $("#chatbox_" + chatboxtitle).css('display', 'block');
            // restructureChatBoxes();
        }
        $("#chatbox_" + chatboxtitle + " .chatboxtextarea").focus();
        return;
    }

    $(" <div />").attr("id", "chatbox_" + chatboxtitle)
        .addClass("chatbox")
        .html('<div class="chatboxhead"><div class="chatboxtitle">' + chatboxtitle + '</div>' 
            + '<div class="chatboxoptions"><a href="javascript:void(0)" onclick="javascript:toggleChatBoxGrowth(\'' 
            + chatboxtitle + '\')">' + '-</a>&nbsp;&nbsp;<a href="javascript:void(0)" onclick="javascript:closeChatBox(\'' 
            + chatboxtitle + '\')">x</a>' + '</div><br clear="all"/></div><div class="chatboxcontent"></div><div class="chatboxinput">' 
            + '<textarea class="chatboxtextarea" onkeydown="javascript:return checkChatBoxInputKey(event,this,\'' 
            + chatboxtitle + '\');">' + '</textarea></div>')
        .appendTo($("body"));

    $("#chatbox_" + chatboxtitle).css('bottom', '0px');
    chatBoxeslength = 0;
    for (x in chatBoxes) {
        if ($("#chatbox_" + chatBoxes[x]).css('display') != 'none') {
            chatBoxeslength++;
        }
    }
    if (chatBoxeslength == 0) {
        $("#chatbox_" + chatboxtitle).css('right', '20px');
    } else {
        width = (chatBoxeslength) * (225 + 7) + 20;
        $("#chatbox_" + chatboxtitle).css('right', width + 'px');
    }
    chatBoxes.push(chatboxtitle);
    $("#chatbox_" + chatboxtitle).click(function() {
        $("#chatbox_" + chatboxtitle + " .chatboxtextarea").focus();
    });
}


function chatHeartbeat() {
    var itemsfound = 0;

    $.ajax({
        url: baseurl + "chat/chatbox?action=chatheartbeat",
        cache: false,
        dataType: "json",
        success: function(data) {
            $.each(data.items, function(i, item) {
                if (item) {
                    chatboxtitle = item.f;

                    if ($("#chatbox_" + chatboxtitle).length <= 0) {
                        createChatBox(chatboxtitle);
                    }
                    if ($("#chatbox_" + chatboxtitle).css('display') == 'none') {
                        $("#chatbox_" + chatboxtitle).css('display', 'block');
                        // restructureChatBoxes();
                    }

                    if (item.s == 1) {
                        item.f = username;
                    }
                    if (item.s == 2) {
                        $("#chatbox_" + chatboxtitle + " .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxinfo">' 
                            + item.m + '</span></div>');
                    } else {
                        newMessages[chatboxtitle] = true;
                        newMessagesWin[chatboxtitle] = true;
                        $("#chatbox_" + chatboxtitle + " .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxmessagefrom">' 
                            + item.f + ':&nbsp;&nbsp;</span><span class="chatboxmessagecontent">' + item.m + '</span></div>');
                    }
                    $("#chatbox_" + chatboxtitle + " .chatboxcontent").scrollTop($("#chatbox_" + chatboxtitle + " .chatboxcontent")[0].scrollHeight);
                    itemsfound += 1;
                }
            });

            chatHeartbeatCount++;

            if (itemsfound > 0) {
                chatHeartbeatTime = minChatHeartbeat;
                chatHeartbeatCount = 1;
            } else if (chatHeartbeatCount >= 10) {
                chatHeartbeatTime *= 2;
                chatHeartbeatCount = 1;
                if (chatHeartbeatTime > maxChatHeartbeat) {
                    chatHeartbeatTime = maxChatHeartbeat;
                }
            }

            setTimeout('chatHeartbeat();', chatHeartbeatTime);
        }
    });
}


function closeChatBox(chatboxtitle) {
    $('#chatbox_' + chatboxtitle).css('display', 'none');
    // restructureChatBoxes();

    $.post(baseurl + "chat/chatbox?action=closechat", {
        chatbox: chatboxtitle
    }, function(data) {});

}

function toggleChatBoxGrowth(chatboxtitle) {
    if ($('#chatbox_' + chatboxtitle + ' .chatboxcontent').css('display') == 'none') {
        $('#chatbox_' + chatboxtitle + ' .chatboxcontent').css('display', 'block');
        $('#chatbox_' + chatboxtitle + ' .chatboxinput').css('display', 'block');
        $("#chatbox_" + chatboxtitle + " .chatboxcontent").scrollTop($("#chatbox_" + chatboxtitle + " .chatboxcontent")[0].scrollHeight);
    } else {
        $('#chatbox_' + chatboxtitle + ' .chatboxcontent').css('display', 'none');
        $('#chatbox_' + chatboxtitle + ' .chatboxinput').css('display', 'none');
    }

}


function checkChatBoxInputKey(event, chatboxtextarea, chatboxtitle) {

    if (event.keyCode == 13 && event.shiftKey == 0) {
        message = $(chatboxtextarea).val();
        message = message.replace(/^\s+|\s+$/g, "");

        $(chatboxtextarea).val('');
        $(chatboxtextarea).focus();
        $(chatboxtextarea).css('height', '44px');
        if (message != '') {
            $.post(baseurl + "chat/chatbox?action=sendchat", {
                to: chatboxtitle,
                message: message
            }, function(data) {
                message = message.replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/\"/g, "&quot;");
                $("#chatbox_" + chatboxtitle + " .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxmessagefrom">' 
                    + username + ':&nbsp;&nbsp;</span><span class="chatboxmessagecontent">' + message + '</span></div>');
                $("#chatbox_" + chatboxtitle + " .chatboxcontent").scrollTop($("#chatbox_" + chatboxtitle + " .chatboxcontent")[0].scrollHeight);
            });
        }
        chatHeartbeatTime = minChatHeartbeat;
        chatHeartbeatCount = 1;

        return false;
    }
}

function start_chat() {
    $.ajax({
        url: baseurl + "chat/chatbox?action=startchat",
        cache: false,
        dataType: "json",
        success: function(data) {
            username = data.username;

            $.each(data.items, function(i, item_tmp) {
                $.each(item_tmp, function(i, item) {
                    if (item) {
                        chatboxtitle = item.f;
                        if ($("#chatbox_" + chatboxtitle).length <= 0) {
                            createChatBox(chatboxtitle, 1);
                        }
                        if (item.s == 1) {
                            item.f = username;
                        }
                        if (item.s == 2) {
                            $("#chatbox_" + chatboxtitle + " .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxinfo">' 
                                + item.m + '</span></div>');
                        } else {
                            $("#chatbox_" + chatboxtitle 
                                + " .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxmessagefrom">' 
                                + item.f + ':&nbsp;&nbsp;</span><span class="chatboxmessagecontent">' + item.m + '</span></div>');
                        }
                    }
                });
            });

            for (i = 0; i < chatBoxes.length; i++) {
                chatboxtitle = chatBoxes[i];
                $("#chatbox_" + chatboxtitle + " .chatboxcontent").scrollTop($("#chatbox_" + chatboxtitle + " .chatboxcontent")[0].scrollHeight);
                setTimeout('$("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop($("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);', 100);
            }
            setTimeout('chatHeartbeat();', chatHeartbeatTime);
        }
    });
}