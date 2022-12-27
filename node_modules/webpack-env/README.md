Webpack Env
================
[![Build Status](https://travis-ci.org/toastynerd/webpack_env.svg)](https://travis-ci.org/toastynerd/webpack_env)

Webpack ENV is a webpack plug-in for creating ENV-variable-like globals in webpack.

## Setup
First add Webpack Env as a webpack plug-in, using gulp this would 
look something like this:
```js
//gulpfile.js
var gulp = require('gulp');
var webpack = require('webpack');
var webpackEnv = require('webpack-env');

gulp.task('webpack', function() {
  return gulp.src('./entry.js')
    .pipe(webpack({
      output: {
        filename: 'bundle.js'
      },
      plugins: [webpackEnv]
    }))
    .pipe(gulp.dest('build/'));
});
```
Create a `.env.js` file in the same directory as your gulpfile.js.
This file should export an object that contains the eventual globals
you want your webpack code to contain:
```js
module.exports = {
  SOME_VAR: 'some val'
}
```

## Multiple Environments

Weback Env also supports having multiple files for multiple environments.
To create a set of Production environment globals, just create a `.production_env.js`
file and run gulp with NODE_ENV set to 'production'.

## Keep your secrets out of the repo

Be sure you've added all your `.env` files to your `.gitignore`.
