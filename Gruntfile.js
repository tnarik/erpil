module.exports = function(grunt) {

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    concurrent: {
      test: {
        tasks: ['shell', 'watch'],
        options: {
          logConcurrentOutput: true
        }
      }
    },

    watch: {
      mostfile: {
        files: [ 'Gruntfile.js', 'app/**/*.php', 'assets/**/*' ],   
        options: {
          livereload: true
        }
      }
    },

    shell: {
      startApp: {
        command: 'php artisan serve'
      }

    }
  });

  // Load the plugins
  grunt.loadNpmTasks('grunt-concurrent');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-shell');
  grunt.loadTasks('tasks');

  // Default task(s)
  grunt.registerTask('default', ['concurrent:test']);
}