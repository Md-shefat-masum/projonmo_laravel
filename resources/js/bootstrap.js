window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';



window.axios.interceptors.response.use((response) => {
    $(`label`).children('.text-danger').remove();
    $(`label`).children('.text-danger').remove();


    return response

}, (error) => {
    // whatever you want to do with the error
    // console.log(error.response.data.errors);
    let object = error.response.data.errors;
    $(`label`).children('.text-danger').remove();
    $(`label`).children('.text-danger').remove();
    for (const key in object) {
        if (Object.hasOwnProperty.call(object, key)) {
            const element = object[key];
            $(`input[name="${key}"]`).parent('div').children('label').append(`<div class="text-danger">${element[0]}</div>`);
            $(`input[name="${key}"]`).trigger('focus');
            $(`textarea[name="${key}"]`).parent('div').children('label').append(`<div class="text-danger">${element[0]}</div>`);
            $(`textarea[name="${key}"]`).trigger('focus');
            console.log({
                [key]: element
            });
        }
    }
    throw error;
});

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
