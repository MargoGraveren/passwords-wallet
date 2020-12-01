function json(url) {
    return fetch(url).then(res => res.json());
}

let apiKey = 'your_api_key';
json(`https://api.ipdata.co?api-key=${apiKey}`).then(data => {
    console.log(data.ip);
    // so many more properties
});
