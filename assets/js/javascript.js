document.getElementById('showChatButton').addEventListener('click', function() {
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
});

document.getElementById('closeChatBody').addEventListener('click', function() {
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
});

function showChatRoom(){
    var chatBodyDisplay = document.getElementById('users-chat').style.display;
    if(chatBodyDisplay==""){
        document.getElementById('users-chat').style.display='none';
    }else{
        document.getElementById('users-chat').style.display='';
    }
    
}