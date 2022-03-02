const docContainer = document.getElementById('document-container');

console.log(renderArticleCard({
    'uri': '123',
    'image': 'https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_272x92dp.png',
    'name': 'Google',
    'year': '2019'
}));

requestAPI('', {}, response => {
    console.log(response);
    response.documents.forEach(element => {
        console.log('wowl');
        docContainer.innerHTML += renderArticleCard(element)            
        console.log(docContainer);
    });
}, (code, message) => {
    alert(message)
})


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