
(function () {
    var httpRequest;

    document.getElementById("ajax__button").onclick = function () {

        // console.log(document.getElementById("user__name"));

        var name = document.getElementById("user__name").value;
        var email = document.getElementById("user__email").value;
        var message = document.getElementById("user__message").value;

        makeRequest('server.php?action=ajax_message', { name, email, message });
    };


    function makeRequest(url, request) {
        httpRequest = new XMLHttpRequest();

        if (!httpRequest) {
            alert('Giving up :( Cannot create an XMLHTTP instance');
            return false;
        }
        httpRequest.onreadystatechange = feedback;

        httpRequest.open('POST', url);
        httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        httpRequest.send('name=' + encodeURIComponent(request.name)
            + '&email=' + encodeURIComponent(request.email)
            + '&message=' + encodeURIComponent(request.message));
    }


    function feedback() {
        if (httpRequest.readyState === XMLHttpRequest.DONE) {
            if (httpRequest.status === 200) {
                var response = JSON.parse(httpRequest.responseText);
                renderFeedback(response.greeting);
            } else {
                alert('There was a problem with the request.');
            }
        }
    }


    function renderFeedback(greeting) {
        var content = document.getElementById('content');

        content.innerHTML = '';

        var template = document.getElementById('feedback');
        var clone = document.importNode(template.content, true);

        clone.getElementById('greeting').innerHTML = greeting;
        clone.getElementById('greeting').id = '';

        content.appendChild(clone);

        document.getElementById("reload__button").onclick = function () {
            window.location.reload();
        };
    }


})();
