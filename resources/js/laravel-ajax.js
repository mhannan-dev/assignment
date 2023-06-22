// public/js/laravel-ajax.js

function handleAjaxResponse(response) {
    if (response.status === 200) {
        // Flash success message
        let message = response.data.message;
        alert(message); // You can use a more user-friendly notification library or customize the message display as per your needs
    } else {
        // Handle other response statuses if needed
    }
}
