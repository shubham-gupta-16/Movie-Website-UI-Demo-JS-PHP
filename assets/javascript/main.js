const docContainer = document.getElementById('document-container');
const moreLoader = document.getElementById("more-loader");
const mainLoader = document.getElementById("main-loader");

var globalPage = 1
var totalPages = 1
var isLoading = true


window.addEventListener("scroll", () => {
    tryFetchMore()
}, false);

function tryFetchMore() {
    if (window.scrollY + window.innerHeight - 20 > docContainer.offsetHeight && !isLoading && totalPages >= globalPage) {
        console.log("fetch more")
        fetch(PARAM_TYPE, PARAM_VALUE)
    }
}
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
        });
        isLoading = false
        tryFetchMore()
    }, (code, message) => {
        alert(message)
        isLoading = false
    })
}


function renderArticleCard(data) {
    let html = `<div class="doc-card">
                <div></div>
                <header>
                    <div class="d-name">${data['name']}</div>
                    <div>${data['year']}</div>
                </header>
            </div>
        `
    let doc = document.createElement('a')
    doc.href = `./document?uri=${data['uri']}`
    doc.target = '_blank'
    doc.innerHTML = html
    loadImage(doc.firstChild.children[0], data['image']);
    return doc
}

function loadImage(element, src) {
    var image = new Image();
    image.addEventListener('load', function () {
        element.style.backgroundImage = 'url(' + src + ')';
        element.style.opacity = 1
    });
    image.src = src;
}