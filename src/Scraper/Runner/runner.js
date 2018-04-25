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
        // console.log('Started');

        const chrome = await chromeLauncher.launch({
            chromeFlags: ['--disable-gpu', '--headless']
        });

        const protocol = await CDP({port: chrome.port});

        // See API docs: https://chromedevtools.github.io/devtools-protocol/
        const {Page, Runtime, DOM} = protocol;

        await Promise.all([Page.enable(), Runtime.enable(), DOM.enable()]);

        Page.navigate({url});

        // console.log('Navigated to ', url);

        // wait until the page says it's loaded...
        Page.loadEventFired(async () => {
            // console.log('page loaded - waiting for JS');
            await timeout(jsLoadTime || 3000); // give the JS some time to load
            // console.log('JS done - parsing');

            // get the page source
            const rootNode = await DOM.getDocument({depth: -1});

            const html = await getOuterHTML(DOM, rootNode.root.nodeId);

            protocol.close();
            chrome.kill();

            resolve(
                // JSON.stringify({url, anchors: {inbound, outbound}, objects, iframes})
                html
            );
        });
    });
}

async function selectNodeIds(DOM, selector, rootNodeId) {
    return await new Promise((resolve, reject) => {
        DOM.querySelectorAll({selector, nodeId: rootNodeId}, (error, params) => {
            if (error) {
                reject(error);
            } else {
                resolve(params.nodeIds);
            }
        });
    });
}

async function selectAttr(DOM, nodeId, attr) {
    const attrs = await selectAttrs(DOM, nodeId);
    // attrs is formatted like `[name, value, name, value, ...]`
    //   so we can just search for the index of the name and return the next index along
    //   however, we need to be careful that the names we match only include the even indexes
    //   (as all the key indexes are even and all the data indexes are odd)

    var idx = attrs.indexOf(attr);

    while (idx % 2 == 1) {
        if (idx < 0) {
            break;
        }

        if (idx % 2 == 1) {
            idx = attrs.indexOf(attr, idx);
        }
    }

    if (idx < 0) {
        return null;
    }

    return attrs[idx + 1];
}

async function selectAttrs(DOM, nodeId) {
    return await new Promise((resolve, reject) => {
        DOM.getAttributes({nodeId}, (error, params) => {
            if (error) {
                reject(error);
            } else {
                resolve(params.attributes);
            }
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
