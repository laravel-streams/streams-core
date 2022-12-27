var webpack = require('webpack');
var fs = require('fs');
module.exports = exports = function() {
  var dir =  process.cwd();

  var env = require(dir + '/\.' + (process.env.NODE_ENV? process.env.NODE_ENV + '_' : '') + 'env.js');
  if (!(typeof env === 'object')) {
    console.log('WARNING: .env.js did not return an object!');
    env = {};
  }

  var keys = Object.keys(env);
  for (var i = 0; i < keys.length; i++) {
    env[keys[i]] = '\"' + env[keys[i]] + '\"';
  }
  return new webpack.DefinePlugin(env);
}
