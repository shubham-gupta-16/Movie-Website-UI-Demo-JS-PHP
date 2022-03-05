const docContainer = document.getElementById('document-container');
const moreLoader = document.getElementById("more-loader");
const mainLoader = document.getElementById("main-loader");

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
            fetch(PARAM_TYPE, PARAM_VALUE)
        }
    }, false);

})();
// var more = '<div style="height:1000px; background:#EEE;"></div>';
// content.innerHTML = more;


fetch(PARAM_TYPE, PARAM_VALUE)


function fetch(paramType, paramValue) {
    isLoading = true
    var get = {
        page: globalPage
    }
    if (paramType != null && paramValue != null) {

    }
    get[paramType] = paramValue

    if (globalPage == 1) {
        mainLoader.style.display = "block"
    }
    requestAPI('', {
        get: get
    }, response => {
        console.log(response);
        totalPages = response.pages
        mainLoader.style.display = "none"
        if (totalPages > globalPage) {
            moreLoader.style.display = "flex"
        } else {
            moreLoader.style.display = "none"
        }
        globalPage++

        response.documents.forEach(element => {
            // docContainer.innerHTML += renderArticleCard(element)
            docContainer.appendChild(renderArticleCard(element))
            console.log(docContainer);
        });
        isLoading = false
    }, (code, message) => {
        alert(message)
        isLoading = false
    })
}


function renderArticleCard(data) {
    let html =  `<div class="doc-card">
                <div></div>
                <header>
                    <div class="d-name">${data['name']}</div>
                    <div>${data['year']}</div>
                </header>
            </div>
        `
    let doc = document.createElement('a')
    doc.href = `./document?uri=${data['uri']}`
    doc.innerHTML = html
    loadImage(doc.firstChild.children[0], data['image']);
    return doc
}

function loadImage(element, src) {
    var image = new Image();
    image.addEventListener('load', function () {
        console.log(element);
        element.style.backgroundImage = 'url(' + src + ')';
        element.style.opacity = 1
    });
    image.src = src;
}