const BASE_URL_SEP = '/api/'

function requestAPI(loc, { post, get }, successCallback, errorCallback) {
    console.log(window.location.origin + BASE_URL_SEP + loc);
    requestAJAX(window.location.origin + BASE_URL_SEP + loc, { post, get }, (responseText) => {
        console.log(responseText);
        try {
            let jsonResponse = JSON.parse(responseText);
            successCallback(jsonResponse)
        } catch (e) {
            errorCallback(e.code, e.message)
        }

    }, errorCallback)
}

function requestAJAX(url, { post, get }, successCallback, errorCallback) {
    const target = new URL(url)
    target.search = new URLSearchParams(get).toString()
    var request = new XMLHttpRequest();
    request.open("POST", target);
    request.addEventListener("progress", function (evt) {
        if (evt.lengthComputable) {
            var percentComplete = evt.loaded / evt.total;
            console.log("Upload ", Math.round(percentComplete * 100) + "% complete.");
        }
    }, false);
    // request.onprogress = (evt) => {
    // console.log('progress');
    // console.log(evt);
    // };
    request.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            successCallback(this.responseText);
        } else if (this.readyState === 4) {
            errorCallback(this.status, this.message);
        }
    };
    var formData = new FormData();
    console.log({ post })
    if (post != null)
        for (var key in post) {
            formData.append(key, post[key]);
        }
    request.send(formData);
}