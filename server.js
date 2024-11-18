const express = require('express');
const crawlLinks = require('./crawler');

const app = express();
const PORT = 3000;

let cachedLinks = [];

app.set('view engine', 'ejs');
app.set('views', __dirname + '/views');

app.use(express.urlencoded({ extended: true }));

app.get('/', (req, res) => {
    res.render('index', { error: null });
});

app.post('/', async (req, res) => {
    const targetUrl = req.body.url;

    try {
        cachedLinks = await crawlLinks(targetUrl);
        res.redirect('/admin');
    } catch (err) {
        console.error(err);
        res.render('index', { error: "Impossible de scraper l'URL. Vérifiez l'URL et réessayez." });
    }
});

app.get('/admin', (req, res) => {
    res.render('admin', { links: cachedLinks });
});

app.listen(PORT, () => {
    console.log(`Serveur en écoute sur http://localhost:${PORT}`);
});
