# node-phpexcel-stream

**Memory-efficient spreadsheet to CSV converter. Won't make you love PHP, but it handles big files well and supports 8 different file formats.**

[![npm status](http://img.shields.io/npm/v/phpexcel-stream.svg?style=flat-square)](https://www.npmjs.org/package/phpexcel-stream) [![Travis build status](https://img.shields.io/travis/vweevers/node-phpexcel-stream.svg?style=flat-square&label=travis)](http://travis-ci.org/vweevers/node-phpexcel-stream) [![AppVeyor build status](https://img.shields.io/appveyor/ci/vweevers/node-phpexcel-stream.svg?style=flat-square&label=appveyor)](https://ci.appveyor.com/project/vweevers/node-phpexcel-stream) [![Dependency status](https://img.shields.io/david/vweevers/node-phpexcel-stream.svg?style=flat-square)](https://david-dm.org/vweevers/node-phpexcel-stream)

## example

```js
var excel      = require('phpexcel-stream')
  , fs         = require('fs')
  , csvParser  = require('csv-parser')
  , JSONStream = require('jsonstream')

fs.createReadStream('test/air_pollution_nl.xlsx')
  .pipe( excel() )
  .pipe( csvParser() )
  .pipe( JSONStream.stringify() )
  .pipe( process.stdout )
```

## api

### `excel([extension])`

Returns a duplex stream - give it a spreadsheet, get back CSV. Optionally pass `extension` as a file format hint to [PHPExcel](https://github.com/PHPOffice/PHPExcel) (format is autodetected otherwise).

## supported file formats

- Office Open XML (.xlsx) (Excel 2007 and above)
- SpreadsheetML (.xml) (Excel 2003)
- BIFF 5-8 (.xls) (Excel 95 and above)
- Open Document Format/OASIS (.ods)
- Gnumeric (GNOME)
- HTML (why)
- SYLK (no idea)
- CSV (but you can and should use [csv-parser](https://npmjs.com/package/csv-parser) in node)

## requirements

- PHP >= 5.4.0, must be available in `PATH`
- [composer](https://getcomposer.org), must be available in `PATH`
- PHP extensions:
  - `sqlite3` (used for caching, keeps memory usage low while reading)
  - `zip` (required for xlsx, ods or gnumeric files)
  - `xml`

## install

With [npm](https://npmjs.org) do:

```
npm install phpexcel-stream
```

## license

[MIT](http://opensource.org/licenses/MIT) © [Vincent Weevers](http://vincentweevers.nl). Test data © Statistics Netherlands, The Hague/Heerlen.
