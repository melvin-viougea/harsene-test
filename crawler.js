const axios = require('axios');
const cheerio = require('cheerio');

async function crawlLinks(url) {
    try {
        const { data } = await axios.get(url);
        const $ = cheerio.load(data);

        const links = [];
        $('a').each((index, element) => {
            const link = $(element).attr('href');
            if (link && link.startsWith('http')) {
                links.push(link);
            }
        });

        return links;
    } catch (error) {
        console.error(`Erreur lors du scraping: ${error.message}`);
        return [];
    }
}

module.exports = crawlLinks;
