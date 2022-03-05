const docContainer = document.getElementById('document-container');

console.log(renderArticleCard({
    'uri': '123',
    'image': 'https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_272x92dp.png',
    'name': 'Google',
    'year': '2019'
}));

var globalPage = 1
var totalPages = 1
var isLoading = true


let wrapper = document.getElementById("doc-wrapper");
(function () {
    console.log(wrapper);
    wrapper.addEventListener("scroll", () => {
        if (wrapper.scrollTop + wrapper.offsetHeight > docContainer.offsetHeight && !isLoading && totalPages >= globalPage) {
            fetch(globalPage, PARAM_TYPE, PARAM_VALUE)
        }
    }, false);

})();
// var more = '<div style="height:1000px; background:#EEE;"></div>';
// content.innerHTML = more;


fetch(1, PARAM_TYPE, PARAM_VALUE)


function fetch(page, paramType, paramValue) {
    isLoading = true
    var get = {
        page: page
    }
    if (paramType != null && paramValue != null) {

    }
    get[paramType] = paramValue

    requestAPI('', {
        get: get
    }, response => {
        console.log(response);
        globalPage++
        totalPages = response.pages
        response.documents.forEach(element => {
            docContainer.innerHTML += renderArticleCard(element)
            console.log(docContainer);
        });
        isLoading = false
    }, (code, message) => {
        alert(message)
        isLoading = false
    })
}


function renderArticleCard(data) {
    return `<a href="./document?uri=${data['uri']}" class="">
            <div class="doc-card">
                <div style="background-image: url(${data['image']});"></div>
                <header>
                    <div class="d-name">${data['name']}</div>
                    <div>${data['year']}</div>
                </header>
            </div>
        </a>
        `
}