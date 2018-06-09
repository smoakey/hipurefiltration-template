const csvWriter = require('csv-write-stream');
// const writer = csvWriter();
const fs = require('fs');
const combos = require('combos');
const _ = require('lodash');

const data = require('./products/ics.json');

const parentSku = data.sku;
const names = _.map(data.attributes, 'name');
const options = _.map(data.attributes, 'options');
const optionKeys = _.map(data.attributes, 'option_keys');
const namesAndOptions = _.zipObject(names, options);

let normalized = {};
let i = 0;
_.forEach(namesAndOptions, (obj, name) => {
  const result = _.zipObject(obj, optionKeys[i]);
  i++;
  normalized[name] = result;
});

const variations = combos(namesAndOptions);

const defaultCSVData = {
  type: 'variation',
  featured: 0,
  stock_status: 0, // in stock?
  backorders: 'notify',
};

const csvDataToFill = {
  width: '',
  height: '',
  length: '',
  weight: '',
  regular_price: '',
};

const results = _.map(variations, variation => {
  let i = 0;

  const sku = parentSku + _.chain(variation)
    .map((value, key) => {
      const normalizedValues = normalized[key];
      return !_.isUndefined(normalizedValues[value]) ? normalizedValues[value] : value;
    })
    .values()
    .join('')
    .value();

  const csvData = _.reduce(variation, (result, value, key) => {
    i++;
    return {
      ...result,
      [`Attribute ${i} name`]: key,
      [`Attribute ${i} value(s)`]: value
    };
  }, {}); 

  return _.extend(
    {
      parent_id: parentSku,
      sku: sku
    },
    csvDataToFill, 
    defaultCSVData, 
    csvData,
  );
});

const writer = csvWriter();
writer.pipe(fs.createWriteStream('ics.csv'));
_.each(results, result => writer.write(result));
writer.end()