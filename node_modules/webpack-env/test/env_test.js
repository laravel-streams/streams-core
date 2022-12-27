var nodenvDirBackup = process.env.NODENV_DIR;
process.env.NODENV_DIR = __dirname;
process.cwd = function() {
  return __dirname;
};
var expect = require('chai').expect;

describe('webpack_env default', function() {
  before(function() {
    this.webpackEnv = require(__dirname + '/../index');
  });

  after(function() {
    process.env.NODENV_DIR = nodenvDirBackup;
  });

  it('should be able to grab basic .env.json file', function() {
    expect(this.webpackEnv.definitions.TEST).to.eql('"test value"'); 
  });

  describe('not dev environment', function() {
    before(function() {
      this.cwdBackup = process.cwd;
      this.nodeEnvBackup = process.env.NODE_ENV;
      process.env.NODE_ENV = 'production';
      delete require.cache[require.resolve(__dirname + '/../index')];
      this.webpackEnv = require(__dirname + '/../index'); 
    });

    after(function() {
      process.env.NODE_ENV = this.nodeEnvBackup;
    });

    it('should be able to read other env files', function() {
      expect(this.webpackEnv.definitions.TEST).to.eql('"prod value"');
    });
  });
});
