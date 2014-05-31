var fs = require('fs');
var byline = require('byline');
var csv = require('csv');
var async = require('async');
var natural = require('natural');
var changeCase = require('change-case');

function sqlEscape(stringToEscape){
    return stringToEscape
        .replace("\\", "\\\\")
        .replace("\'", "\\\'")
        .replace("\"", "\\\"")
        .replace("\n", "\\\n")
        .replace("\r", "\\\r")
        .replace("\x00", "\\\x00")
        .replace("\x1a", "\\\x1a");
}

function create_seeder(db, seeder, mapping) {
    console.log('creating DB seeder for laravel as '+seeder);
    //console.log(db);
    var stream = fs.createWriteStream(seeder, { flags : 'w' });
    stream.write( "<?php\n\n" );
    stream.write( "class ImportTableSeeder extends Seeder { \n\n");
    stream.write( "    public function run() {\n" );

    nounInflector = new natural.NounInflector();

    for (table_index in db) {
        table_name = table_index;
        model_name = changeCase.pascalCase(nounInflector.singularize(table_name));
        table_mapping = null;
        if (mapping) {
            if ( (mapping[table_name] === undefined) || (mapping[table_name] == false) ) continue;

            table_mapping = (mapping[table_name] === true) ? table_name : mapping[table_name];
            if (typeof table_mapping == 'object') {
                table_name = (table_mapping['name']) ? table_mapping['name'] : table_index;
                model_name = (table_mapping['model']) ? table_mapping['model'] : changeCase.pascalCase(nounInflector.singularize(table_name));
            } else {
                table_name = table_mapping;
                model_name = changeCase.pascalCase(nounInflector.singularize(table_name));
            }
           // model_name = nounInflector.singularize(table_name);
        }

        stream.write( "        DB::table('"+table_name+"')->delete();\n");
        for (entry_index in db[table_index]) {
            table_entry = db[table_index][entry_index];
            if ( table_mapping && table_mapping['fields'] ) {
                var table_entry_values_migration = "";
                table_entry_values =[];
                for (field in table_mapping['fields'] ) {
                    table_entry_values[field] = table_entry[table_mapping['fields'][field]];
                    //console.log(field+" from "+table_mapping['fields'][field]+" as "+table_entry[table_mapping['fields'][field]]);
                    //table_entry_values_migration = "'name' => '"+table_entry[1]+"', 'card_id' => '234'";
                }
                for (table_entry_values_index in table_entry_values) {
                    table_entry_values_migration += ( table_entry_values_migration.length == 0 ) ? "" : ", ";
                    table_entry_values_migration += "'"+sqlEscape(table_entry_values_index)+"' => '"+sqlEscape(table_entry_values[table_entry_values_index])+"'";
                }
                stream.write( "        "+model_name+"::create(array("+table_entry_values_migration+"));\n");
            } else {
                // insertion without mapping
                stream.write( "        "+model_name+"::create(array('test' => 'test'));\n");

            }
        }
    }

    stream.write( "    }\n" );
    stream.end( "}" );

}
module.exports = function(grunt) {
    grunt.registerTask('dbimport', 'Import simpledo/UserManagement database', function() {
        var done = this.async();

        grunt.log.writeln('reading the file from a parameter.');

        var seeder = grunt.option('seeder');
        if (seeder == undefined) seeder = '/tmp/test.php';

        var sql = grunt.option('sql');
        if (sql == undefined) sql = '../dump.sql';
        grunt.log.writeln(sql);


        grunt.log.writeln('adapt the file first to the erpil format.');
        var sqlfile = fs.createReadStream(sql);
        var streamsqlfile = byline(sqlfile,  { keepEmptyLines: false });

        var db = [];

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
                var parser = csv.parse({delimiter: '', quote: '', rowDelimiter: '),('});
                parser.on('readable', function() {
                    while(data = parser.read()){
                        if (/^INSERT INTO/.test(data[0])) {
                            table_name = data[0].match(/insert into `(.*)` values/i)[1];
                            //data.splice(0,1);
                            data[0] = data[0].replace(/insert into `(.*)` values\ *\(/i, '');
                            count = 0;
                            count_err = 0;
                            db[table_name] = [];
                        }

                        async.each(data, function( values_set, callback ) {
                            values_set = values_set.replace(/\)[;,]$/,"");
                            count++;
                            // we get entries per 'VALUES' set
                            var parserValues = csv.parse({quote: '\'', escape: '\\'});
                            parserValues.on('readable', function() {
                                while(data = parserValues.read()){
                                    //console.log(table_name+" "+data.length+" : "+data[1]);
                                    normalized_data = data.map(Function.prototype.call, String.prototype.trim);
                                    db[table_name].push(normalized_data);
                                }
                            });

                            parserValues.on('error', function(err){
                                count_err++;
                                console.log(values_set);
                                console.log('VALUES ERROR '+err.message);
                            });
                            parserValues.on('finish', function(err){
                                //console.log('values finished');
                                //console.log("did "+count);
                            });

                            parserValues.write(values_set);
                            parserValues.end();
                        });
                    }
                });

                // Catch any error
                parser.on('error', function(err){
                    console.log(err.message);
                });
                parser.on('finish', function(err){
                    //every line
                    //console.log('finished');
                    //console.log(table_name+" with "+count+" entries with "+count_err+" errors");
                });
                parser.write(line);
                parser.end();
            }
        });

        grunt.log.writeln('generate the corresponding translations.');
        grunt.log.writeln('create the entries for seeding in laravel and execute that way, if possible.');

        streamsqlfile.on('error', done);
        
        streamsqlfile.on('end', function (){
            create_seeder(db, seeder,
                 {  'access_log': 'card_events',
                    'members' : { 'name': 'customers',
                        'model' : 'Customer',
                        'fields': { 'name': 1, 'email': 2, 'verified': 0, 'card_id': 4,
                            'created_at': 5, 'updated_at': 6, 'phone': 7, 'address': 8,
                            'national_id': 9, 'surname': 10, 'payment_last_date': 11,
                            'payment_next_date': 12, 'comment': 13, 'payment_method': 14,
                            'customer_id': 15, 'has_parking': 16, 'flag_disabled': 17 } },
                    'sites' : true,
                    'users' : true});
            console.log('finished all this processing');
        });

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

    });
};