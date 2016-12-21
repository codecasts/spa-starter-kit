// https://github.com/shelljs/shelljs
require('./check-versions')()
require('shelljs/global')
env.NODE_ENV = 'production'

var path = require('path')
var fs = require('fs')
var config = require('../config')
var ora = require('ora')
var webpack = require('webpack')
var webpackConfig = require('./webpack.prod.conf')
var assetsPath = path.join(config.build.assetsRoot, config.build.assetsSubDirectory)
var statsFile = path.join(config.build.assetsRoot, '/stats.json')
var spinner = ora('building for production...')

console.log(
  '  Tip:\n' +
  '  Built files are meant to be served over an HTTP server.\n' +
  '  Opening index.html over file:// won\'t work.\n' +
  '  Build path: ' + config.build.assetsRoot + '\n'
)

spinner.start()

rm('-rf', assetsPath)
mkdir('-p', assetsPath)
cp('-R', 'static/*', assetsPath)

webpack(webpackConfig, function (err, stats) {
  spinner.stop()
  if (err) throw err

  fs.writeFile(statsFile, JSON.stringify(stats.toJson()), () => {
    process.stdout.write(stats.toString({
      colors: true,
      modules: false,
      children: false,
      chunks: false,
      chunkModules: false,
    }) + '\n')
  })
})
