const _ = require('lodash');
const combos = require('combos');
const WooCommerceAPI = require('woocommerce-api');
const glob = require('glob');

const WooCommerce = new WooCommerceAPI({
    url: 'http://localhost:9000/',
    consumerKey: 'ck_eda621663c4c50b2bc0853c8b014a96278c99400',
    consumerSecret: 'cs_f4212c333683e44ad553ec193a66f0f6a9d5c0cf',
    wpAPI: true,
    version: 'wc/v2'
});

init();

async function init() {
    console.log('Product Creator Result');
    console.log('-------------------------------------------');
    const rawProductsData = await getRawProductsData();
    const products = await getAllProducts();
    const productsKeyedByName = _.keyBy(products, 'sku');
    const createdAndUpdatedProducts = await createAllProducts(rawProductsData, productsKeyedByName);

    createdAndUpdatedProducts.map(product => {
        const rawData = _.find(rawProductsData, { sku: product.sku });
        const skuBase = product.sku;
        const names = _.map(rawData.attributes, 'name');
        const options = _.map(rawData.attributes, 'options');
        const optionKeys = _.map(rawData.attributes, 'option_keys');
        const namesAndOptions = _.zipObject(names, options);

        let normalized = {};
        let i = 0;
        _.forEach(namesAndOptions, (obj, name) => {
            const result = _.zipObject(obj, optionKeys[i]);
            i++;
            normalized[name] = result;
        });

        const variations = combos(namesAndOptions);
        variations.map(variation => {
            const attributes = _.map(variation, (option, name) => ({ name, option }));

            const sku = skuBase + _.chain(variation)
                .map((value, key) => {
                    const normalizedValues = normalized[key];
                    return !_.isUndefined(normalizedValues[value]) ? normalizedValues[value] : value;
                })
                .values()
                .join('')
                .value();

            const definedVariation = _.find(rawData.variations, { sku });
            const allVariations = rawData.allVariations;
            if (allVariations) {
                const variationData = _.extend({}, allVariations, { sku, attributes });
                createOrUpdateProductVariation(product.id, variationData);
            } else if (definedVariation) {
                const variationData = _.extend({}, definedVariation, { attributes });
                createOrUpdateProductVariation(product.id, variationData);
            } else {
                // console.log(' - skipping variation: ' + sku);
            }
        });
    });
}

function getRawProductsData() {
    return new Promise((resolve, reject) => {
        glob('./products/**/*.json', (err, files) => {
            if (err) {
                return reject(err);
            }

            const data = _.reduce(files, (data, file) => {
                const nextData = require(file);
                return data.concat(nextData);
            }, []);

            resolve(data);
        });
    });
}

function getAllProducts() {
    return new Promise((resolve, reject) => {
        WooCommerce.get('products?per_page=100', function(err, data, res) {
            if (err) {
                return reject(err);
            }
            resolve(JSON.parse(res));
        });
    });
}

function createAllProducts(rawProductsData, productsKeyedByName) {
    const createOrUpdatePromises = rawProductsData.map(productData => {
        if (_.has(productsKeyedByName, productData.sku)) {
            const product = _.get(productsKeyedByName, productData.sku);
            return updateProduct(product.id, productData);
        }
        return createProduct(productData).then(product => _.extend({}, product, { created: true }));
    });

    return Promise.all(createOrUpdatePromises);
}

function createProduct(productData) {
    return new Promise((resolve, reject) => {
        WooCommerce.post('products', productData, function(err, data, res) {
            if (err) {
                return reject(err);
            }
            // console.log('Created: ' + productData.name);
            resolve(JSON.parse(res));
        });
    });
}

function updateProduct(productId, productData) {
    return new Promise((resolve, reject) => {
        WooCommerce.post('products/' + productId, productData, function(err, data, res) {
            if (err) {
                return reject(err);
            }
            // console.log('Updated: ' + productData.name);
            resolve(JSON.parse(res));
        });
    });
}

async function createOrUpdateProductVariation(productId, productVariationData) {
    const sku = productVariationData.sku;
    const existingVariation = await getProductVariation(productId, sku);
    if (existingVariation.length) {
        updateProductVariation(productId, existingVariation[0].id, productVariationData);
    } else {
        createProductVariation(productId, productVariationData);
    }
}

function getProductVariation(productId, variationSku) {
    return new Promise((resolve, reject) => {
        WooCommerce.get('products/' + productId + '/variations?sku=' + variationSku, function(err, data, res) {
            if (err) {
                return reject(err);
            }
            resolve(JSON.parse(res));
        });
    });
}

function createProductVariation(productId, productVariationData) {
    return new Promise((resolve, reject) => {
        WooCommerce.post('products/' + productId + '/variations', productVariationData, function(err, data, res) {
            if (err) {
                return reject(err);
            }
            console.log(' - created variation: ' + productVariationData.sku);
            resolve(JSON.parse(res));
        });
    });
}

function updateProductVariation(productId, variationId, productVariationData) {
    return new Promise((resolve, reject) => {
        WooCommerce.put('products/' + productId + '/variations/' + variationId, productVariationData, function(err, data, res) {
            if (err) {
                return reject(err);
            }
            console.log(' - updated variation: ' + productVariationData.sku);
            resolve(JSON.parse(res));
        });
    });
}