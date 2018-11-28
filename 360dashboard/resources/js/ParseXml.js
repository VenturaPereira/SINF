var _ = require('lodash');
var $ = require('jquery');
const fs = require('fs'),
xml2js = require('xml2js');



function parsing(path)
{
var parser = new xml2js.Parser();
fs.readFile(path, function(err, data) {
parser.parseString(data, function (err, result) {
});
});

return JSON.stringify(result);

}