const chromeLauncher = require('chrome-launcher');
const CDP = require('chrome-remote-interface');

const domain = process.argv[2];
const jsLoadTime = process.argv[3];

getComputedDOM(domain, parseInt(jsLoadTime, 10)).then(html => {
    process.stdout.write(html);
});

function getComputedDOM(url, jsLoadTime) {
    const timeout = ms => new Promise(resolve => setTimeout(resolve, ms));

    return new Promise(async resolve => {
        const chrome = await chromeLauncher.launch({
            chromeFlags: ['--disable-gpu', '--headless']
        });

        const protocol = await CDP({port: chrome.port});
        const {Page, Runtime, DOM} = protocol;

        await Promise.all([Page.enable(), Runtime.enable(), DOM.enable()]);

        Page.navigate({url});

        Page.loadEventFired(async () => {
            await timeout(jsLoadTime || 3000);
            const rootNode = await DOM.getDocument({depth: -1});

            resolve(
                await getOuterHTML(DOM, rootNode.root.nodeId)
            );

            protocol.close();
            chrome.kill();
        });
    });
}

async function getOuterHTML(DOM, nodeId) {
    return await new Promise((resolve, reject) => {
        DOM.getOuterHTML({nodeId}, (error, params) => {
            if (error) {
                reject(error);
            } else {
                resolve(params.outerHTML);
            }
        });
    });
}
