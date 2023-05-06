
// we will pass the text the user entered in the text box to the API to check for profanity then post it.

var text = 'test text';
$.ajax({
    method: 'GET',
    url: 'https://api.api-ninjas.com/v1/profanityfilter?text=' + text,
    headers: { 'X-Api-Key': 'YOUR_API_KEY'},
    contentType: 'application/json',
    success: function(result) {
        console.log(result);
    },
    error: function ajaxError(jqXHR) {
        console.error('Error: ', jqXHR.responseText);
    }
});