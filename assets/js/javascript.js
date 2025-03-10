function triggerChatBox(){
    // Get the chat div
    var chatDiv = document.querySelector('.user-chat');

    // Check if the chatDiv already has the class
    if (chatDiv.classList.contains('user-chat-show')) {
        // If it does, remove the class
        chatDiv.classList.remove('user-chat-show');
    } else {
        // If it doesn't, add the class
        chatDiv.classList.add('user-chat-show');
    }
}

function closeChatRoom(){

    // Get the chat div
    var chatDiv = document.querySelector('.user-chat');

    chatDiv.classList.remove('user-chat-show');

    document.getElementById('users-chat').style.display='none';
    
}

function showChatRoom(){

    // Get the chat div
    var chatDiv = document.querySelector('.user-chat');

    chatDiv.classList.remove('user-chat-show');

    document.getElementById('users-chat').style.display='none';
    
    chatDiv.classList.add('user-chat-show');

    document.getElementById('users-chat').style.display='';
    
}

function continueChatRoom(){

    // Get the chat div
    var chatDiv = document.querySelector('.user-chat');

    chatDiv.classList.remove('user-chat-show');

    document.getElementById('users-chat').style.display='none';
    
    chatDiv.classList.add('user-chat-show');

    document.getElementById('users-chat').style.display='';
    
}

function scrollToBottom() {
    var chatContainer = document.getElementById('chat-conversation');
    chatContainer.scrollTop = chatContainer.scrollHeight;
}