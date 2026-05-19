function chatbotReply(userMessage){

    let response = "Sorry, I didn't understand.";

    if(userMessage.includes("lost")){

        response = "Please report your lost item from dashboard.";

    }else if(userMessage.includes("found")){

        response = "You can upload found items easily.";
    }

    return response;
}