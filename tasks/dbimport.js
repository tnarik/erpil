var fs = require('fs');
var byline = require('byline');
var csv = require('csv');
var async = require('async');

var childProcess = require('child_process');

module.exports = function(grunt) {
    grunt.registerTask('dbimport', 'Import simpledo/UserManagement database', function() {
        var done = this.async();

        grunt.log.writeln('reading the file from a parameter.');

        var sql = grunt.option('sql');
        if (sql == undefined) sql = '../dump.sql';
        grunt.log.writeln(sql);


        grunt.log.writeln('adapt the file first to the erpil format.');
        var sqlfile = fs.createReadStream(sql);
        var streamsqlfile = byline(sqlfile,  { keepEmptyLines: false });

        streamsqlfile.on('data', function(line) {
            if (/^--/.test(line)) return;
            if (/^DROP/.test(line)) return;
            if (/^\/\*.*\*\//.test(line)) return;
            if (/^LOCK/.test(line)) return;
            if (/^UNLOCK/.test(line)) return;
            if (/^CREATE/.test(line)) {
                this.mode = 'create';
                return;
            }
            if (this.mode == 'create') {
                if ( /^\)/.test(line)) {
                    delete this.mode;
                }
                return;
            }

            if (/^INSERT INTO/.test(line)) {
                var parser = csv.parse({delimiter: '(', quote: ''});
                    parser.on('readable', function(){
                        while(data = parser.read()){
                            table_name = data[0].match(/insert into `(.*)` values/i)[1];
                            data.splice(0,1);
                            count = 0;
                            async.each(data, function( values_set, callback ) {
                                count++;
                                // we get entries per 'VALUES' set
                                var parserValues = csv.parse({quote: '\''});
                                parserValues.on('readable', function() {
                                    while(data = parserValues.read()){
                                        console.log(data.length);
                                        console.log(data[0]+" "+data[1]+" " +data[2]);
                                    }
                                });

                                parserValues.on('error', function(err){
                                    console.log('values '+err.message);
                                });
                                parserValues.on('finish', function(err){
                                    //console.log('values finished');
                                    //console.log("did "+count);
                                });

                                parserValues.write(values_set);
                                parserValues.end();
                            });
                            console.log(table_name+" with "+count+" entries");

                        }
                    });

                // Catch any error
                parser.on('error', function(err){
                    console.log(err.message);
                });
                parser.on('finish', function(err){
                    //console.log('finished');
                });
                parser.write(line);
                parser.end();
            }
        });

grunt.log.writeln('generate the corresponding translations.');
grunt.log.writeln('create the entries for seeding in laravel and execute that way, if possible.');

        //var transformer = new stream.Transform( { objectMode: true } );
        //transformer._transform = function (chunk, encoding, done) {
        //    this.push("a\n");
        //    done();
        //};
        //var os = process.stdout;
        //// pipe the input to the output, via transformation functions
        //seed.pipe(transformer) // transform the data
        //    .pipe(os); // write the data to the output stream
//

        /*
        seed.on('open', function() {
            var child = childProcess.spawn('psql', ['thedb'], {
                stdio: [seed, process.stdout, process.stderr] 
            });

            child.on('exit', done);
        });
*/

streamsqlfile.on('error', done);
});    
};
