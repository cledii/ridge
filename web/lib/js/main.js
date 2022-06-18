/**
 * ridge.js
 * created by: rgb and contributors...
 */

// main functions

/**
 * redirects to the given url
 * 
 * @param {string} url
 */
function redirect(url) {
    window.location.href = url;
};

// jquery functions
$(function() {
    // reg form
    $('#register').on('submit', function(e) {
        console.log('ridge.JS: sending AJAX request to req/register');
        
        // get form data
        let sanitizedData = DOMPurify.sanitize(
            $('#register').serialize()
        );

        $.ajax({
            type: 'POST',
            url: 'req/register.php',

            data: sanitizedData,

            success: function(data) {
                console.log('ridge.JS: AJAX request successful');
                console.log(data);

                switch (data.status) {
                    case 'success':
                        console.log('ridge.JS: registration successful');
                        redirect('/login');
                        break;
                    case 'error':
                        console.log('ridge.JS: registration failed');
                        $('#register-error').text(data.message);
                        break;
                }
                
            },

            failure: function(data) {
                console.error('ridge.JS: AJAX request failed');
                $('#register-error').text('couldn\'t send request, try again later..');
            }
        })

        e.preventDefault();
    })
});

console.log('ridge, another video sharing site.. created by rgb and contributors.\n\nwant to contribute? https://github.com/cledii/ridge');
console.log('%cDO NOT PUT JS CODE THAT YOU DONT UNDERSTAND IN HERE. 11/10 your getting token logged.', 'font-size: 1.5em; color: red;');
console.log('ridge.js loaded');
