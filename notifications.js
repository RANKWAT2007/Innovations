function showNotification(message){

    const notification = document.createElement("div");

    notification.className = "alert alert-success position-fixed top-0 end-0 m-4";

    notification.innerText = message;

    document.body.appendChild(notification);

    setTimeout(() => {

        notification.remove();

    },3000);
}